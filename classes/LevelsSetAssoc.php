<?php

/*
  # ***** BEGIN LICENSE BLOCK *****
  # This file is part of Neverepo .
  # Copyright (c) 2004 Francois Guillet and contributors. All rights
  # reserved.
  #
  # Neverepo is free software; you can redistribute it and/or modify
  # it under the terms of the GNU General Public License as published by
  # the Free Software Foundation; either version 2 of the License, or
  # (at your option) any later version.
  #
  # Neverepo is distributed in the hope that it will be useful,
  # but WITHOUT ANY WARRANTY; without even the implied warranty of
  # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  # GNU General Public License for more details.
  #
  # You should have received a copy of the GNU General Public License
  # along with Neverepo; if not, write to the Free Software
  # Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  #
  # ***** END LICENSE BLOCK *****
 */

/**
 * Helper managing playlist (1 set > N levels)
 *
 * @author shino
 */

if (!defined('IN_NEVEREPO')) {
    exit;
}

require_once 'ressources/DatabaseManager.php';
require_once 'classes/Level.php';

class LevelsSetAssoc {

    /**
     * Add a level to a set.
     * 
     * @param int $levelId ID of level to add to the set
     * @param int $setId ID of set the set
     * @param int $place Position desired of the level in the set, or -1 to add it at the end
     * @throws NeverepoModelException
     */
    static public function addLevel($levelId, $setId, $place = -1) {

        $dbh = DatabaseManager::getDB();

        if (!self::isLevelExist($levelId)) {
            throw new NeverepoModelException("LevelsSetAssoc::addLevel : " . _("Level doesn't exist."));
        }

        if (!self::isSetExist($setId)) {
            throw new NeverepoModelException("LevelsSetAssoc::addLevel : " . _("Set doesn't exist."));
        }

        /* Test if place already exists */
        if ($place == -1) {
            $place = self::getLastPlace($setId) + 1;
        } else if ($place > self::getLastPlace($setId) + 1) {
            throw new NeverepoModelException("LevelsSetAssoc::addLevel : " . _("Invalid place, out of bounds."));
        } else {
            /* Shift all levels before inserting new one to the place $place */
            $sth1 = $dbh->prepare("UPDATE `playlist` SET place=place+1 WHERE place>=:place");
            $sth1->bindParam(':place', $place, PDO::PARAM_INT);
            $sth1->execute();
        }

        /* Add level to set at the place specified */
        $query = 'INSERT INTO `playlist` (level_id,set_id,place) VALUES (:level_id,:set_id,:place)';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':level_id', $levelId, PDO::PARAM_INT);
        $sth->bindParam(':set_id', $setId, PDO::PARAM_INT);
        $sth->bindParam(':place', $place, PDO::PARAM_INT);
        $sth->execute();
    }

    /**
     * Remove a level from a set.
     * 
     * @param type $setId set to modify,
     * @param type $place level position to delete
     */
    static public function removeLevel($setId, $place) {

        $dbh = DatabaseManager::getDB();

        if ($place > self::getLastPlace($setId)) {
            throw new NeverepoModelException("LevelsSetAssoc::removeLevel : " . _("Try to remove an inexisting level."));
        }

        $query = 'DELETE FROM `playlist` WHERE set_id=:set_id AND place=:place';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':set_id', $setId, PDO::PARAM_INT);
        $sth->bindParam(':place', $place, PDO::PARAM_INT);
        $sth->execute();

        /* Get all next positions and decrement them */
        $sth2 = $dbh->prepare("UPDATE `playlist` SET place=place-1 WHERE place>:place");
        $sth2->bindParam(':place', $place, PDO::PARAM_INT);
        $sth2->execute();
    }

    /**
     * 
     * Remove all levels of a set
     * 
     * @param type $setId set to clean
     */
    static public function removeAll($setId) {
        $dbh = DatabaseManager::getDB();

        $query = 'DELETE FROM `playlist` WHERE set_id=:set_id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':set_id', $setId, PDO::PARAM_INT);
        $sth->execute();
    }
    
    /**
     * Return an array containing levels indexing by position
     * 
     * @param type $setId set to get playlist from
     */
    static public function getPlaylist($setId) {
        $dbh = DatabaseManager::getDB();
        
        $arr = array();

        $query = 'SELECT * FROM `playlist` LEFT JOIN `level` ON level.id=playlist.level_id WHERE playlist.set_id=:set_id ORDER BY playlist.place';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':set_id', $setId, PDO::PARAM_INT);
        $sth->execute();
        
        while ($level_arr = $sth->fetch()) {
            $level = new Level();
            $level->Fill($level_arr);
            $arr[$level_arr['place']] = $level;
        }
        
        return $arr;
    }

    /* Test if level exists */
    static private function isLevelExist($levelId) {

        $dbh = DatabaseManager::getDB();
        $sth = $dbh->prepare("SELECT id FROM `level` WHERE id=:id");
        $sth->bindParam(":id", $levelId, PDO::PARAM_INT);
        $sth->execute();

        return ($sth->rowCount() > 0);
    }

    /* Test if set exists */
    static private function isSetExist($setId) {

        $dbh = DatabaseManager::getDB();
        $sth = $dbh->prepare("SELECT id FROM `set` WHERE id=:id");
        $sth->bindParam(":id", $setId, PDO::PARAM_INT);
        $sth->execute();

        return ($sth->rowCount() > 0);
    }

    /* Get last place of a set (in other words number of levels already in it) */
    static private function getLastPlace($setId) {

        $place = 0;
        $dbh = DatabaseManager::getDB();
        $sth = $dbh->prepare("SELECT MAX(place) FROM `playlist` WHERE set_id=:set_id");
        $sth->bindParam(":set_id", $setId, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            $res = $sth->fetch();
            /* First level of the set */
            if ($res['MAX(place)'] == "NULL") {
                $place = 0;
            } else {
                $place = (int) $res['MAX(place)'];
            }
        }
        return (int) $place;
    }

}

?>
