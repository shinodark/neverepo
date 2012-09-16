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
 *
 * @author shino
 */

include_once "ressources/ConfigManager.php";

class DatabaseManager {

    private static $db;

    public static function getDB() {
        if (!self::$db) {
            $dsn = "mysql:dbname=" . ConfigManager::getProperty("database_name") . ";host=" . ConfigManager::getProperty("database_host");
            $user = ConfigManager::getProperty("database_user");
            $pass = ConfigManager::getProperty("database_pass");

            try {
                self::$db = new PDO($dsn, $user, $pass);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                echo 'Connexion échouée : ' . $e->getMessage();
            }
        }
        return self::$db;
    }

}

?>
