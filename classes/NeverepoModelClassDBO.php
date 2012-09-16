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
 * Description of NeverepoModelException
 *
 * Abstract class used as parent for other model class needing database.
 * 
 * Assume that class name is table name in database, in lowercase.
 * 
 * @author shino
 */
abstract class NeverepoModelClassDBO extends NeverepoModelClass {
    
    protected $tableName;
    protected $className;
    protected $id = -1;  // All model classes should have an id
    
    function __construct() {
        parent::__construct();
        $this->className = $this->rc->getName();
        $this->tableName = lcfirst($this->className);
    }
    
    public function Fetch($id) {
        $dbh = DatabaseManager::getDB();
        $query = 'SELECT * FROM `'. $this->tableName .'` where id=:id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row == FALSE) {
            throw new NeverepoModelException($this->className . "::" . _("Fecth() : cannot fetch with id=").$id);
        }
        $this->Fill($row);
    }
    
    public function Delete() {
        if (!$this->isValid()) {
            throw new NeverepoModelException($this->className . "::" . _("Delete() : invalid data."));
        }
        
        $dbh = DatabaseManager::getDB();
        $query = 'DELETE FROM `'. $this->tableName .'` WHERE id=:id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $this->id, PDO::PARAM_INT);
        $sth->execute();
    }
    
    abstract public function isValid();
}

?>
