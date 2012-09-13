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
 * Description of Set
 *
 * @author shino,htnever
 */
class Set extends NeverepoModelClass {

    private $name = "";
    private $author_id = "";
    private $description = "";
    private $num = 25;
    private $picture;

    public function __construct() {
        parent::__construct();
    }
    
    public function Insert() {
        if ($this->author_id == -1 || empty($this->name)) {
            throw new NeverepoModelException("Set::Insert() : Level is invalid.");
        }
        
        $dbh = DatabaseManager::getDB();
        $query = 'INSERT INTO `set` (name,author_id,description,num,picture) VALUES (:name,:author_id,:description,:num,:picture)';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':name', $this->name, PDO::PARAM_STR, 32);
        $sth->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $sth->bindParam(':description', $this->description, PDO::PARAM_STR, 1024);
        $sth->bindParam(':num', $this->num, PDO::PARAM_INT);
        $sth->bindParam(':picture', $this->picture, PDO::PARAM_STR, 1024);
        $sth->execute();
        
        $this->setId($dbh->lastInsertId());
    }
    
    public function Update() {
        if (!$this->isValid()) {
            throw new NeverepoModelException(_("Set::Delete() : Set is invalid."));
        }
        
        $dbh = DatabaseManager::getDB();
        $query = 'UPDATE `set` SET name=:name,author_id=:author_id,description=:description,num=:num,picture=:picture WHERE id=:id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $this->id, PDO::PARAM_INT);
        $sth->bindParam(':name', $this->name, PDO::PARAM_STR, 32);
        $sth->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $sth->bindParam(':description', $this->description, PDO::PARAM_STR, 1024);
        $sth->bindParam(':num', $this->num, PDO::PARAM_INT);
        $sth->bindParam(':picture', $this->picture, PDO::PARAM_STR, 1024);       
        $sth->execute();        
    }
    
    public function isValid() {
        return ($this->id != -1 && $this->author_id != -1 && !empty($this->name));
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

    public function setAuthorId($author) {
        $this->author_id = $author;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function setPicture($picture) {
        $this->picture = $picture;
    }
    
    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }
}

?>
