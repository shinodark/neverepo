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
 * @author shino
 */

include "Connection.php";
class Set {

     private $id = -1;
     private $name= "";
     private $author = "";
     private $description = "";
     private $num = 25;
	 
	 public function Fetch($id) {
	     $data = new Connection();
		 $data->Connect();
		 $data->Query("select * from sets where id = ".$id);
		 
		 $obj = mysql_fetch_assoc($data->Get());
		 $this->id = $obj['id'];
		 $this->name = $obj['name'];
		 $this->author = $obj['author'];
		 $this->num = $obj['num'];
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


    
}

?>
