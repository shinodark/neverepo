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
include "Connection.php";
class Level {
     private $id = -1;
     private $author = "";
     private $preview = "";
     private $timestamp;
	 private $set;
	 
	 public function __construct($id,$author,$set) {
	     $this->id     = $id;
		 $this->author = $author;
		 $this->set    = $set;
	 }
	
	 public function Fetch($id) {
	     $data         = new Connection();
		 $data->Connect();
		 $data->Query("select * from levels where id = ".$id);
		 
		 $obj          = mysql_fetch_assoc($data->query);
		 $this->id     = $obj['id'];
		 $this->author = $obj['author'];
	 }
    
     public function getId() {
         return $this->id;
     }

     public function setId($id) {
         $this->id = $id;
     }

    public function getAuthor() {
        return $this->author;
    }

     public function setAuthor($author) {
         $this->author = $author;
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
    
    public function Insert() {
        $db = new Connection();
		$db->Connect();
        $query = 'INSERT into level (author,preview) VALUES("'.$this->author.'","'.$this->preview.'")';
        $db->Query($query);
    }
}

?>
