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
 * Description of Level
 *
 * @author shino
 */

class Level extends NeverepoModelClass {

    private $id = -1;
    private $author_id = -1;
    private $preview = "";
    private $timestamp;

    public function Fetch($id) {
        $dbh = DatabaseManager::getDB();
        $query = 'SELECT * FROM level where id=:id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row == FALSE) {
            throw new NeverepoModelException(_("Level::Fecth() : cannot fetch level with id=").$id);
        }
        $this->Fill($row);
    }

    
    public function Insert() {
        if ($this->author_id == -1) {
            throw new NeverepoModelException(_("Level::Insert() : Level is invalid."));
        }
        
        $dbh = DatabaseManager::getDB();
        $query = 'INSERT into level (author_id,preview) VALUES (:author_id,:preview)';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $sth->bindParam(':preview', $this->preview, PDO::PARAM_STR, 1024);
        $sth->execute();
        
        $this->setId($dbh->lastInsertId());
    }
    
    public function Delete() {
        if (!$this->isValid()) {
            throw new NeverepoModelException(_("Level::Delete() : Level is invalid."));
        }
        
        $dbh = DatabaseManager::getDB();
        $query = 'DELETE FROM level WHERE id=:id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $this->id, PDO::PARAM_INT);
        $sth->execute();
    }
    
    public function Update() {
        if (!$this->isValid()) {
            throw new NeverepoModelException(_("Level::Delete() : Level is invalid."));
        }
        
        $dbh = DatabaseManager::getDB();
        $query = 'UPDATE level SET author_id=:author_id,preview=:preview WHERE id=:id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $this->id, PDO::PARAM_INT);
        $sth->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $sth->bindParam(':preview', $this->preview, PDO::PARAM_STR, 1024);        
        $sth->execute();        
    }
    
    private function isValid() {
        return ($this->id != -1 && $this->author_id != -1);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = (int)$id;
    }

    public function getAuthorId() {
        return $this->author_id;
    }

    public function setAuthorId($author_id) {
        $this->author_id = (int)$author_id;
    }

    public function getPreview() {
        return $this->preview;
    }

    public function setPreview($preview) {
        $this->preview = $preview;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
}

?>
