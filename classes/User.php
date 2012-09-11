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
 * Description of User
 *
 * @author shino,htnever
 */
include "Connection.php";
class User {

     private $id;
	 private $name;
     private $username;
     private $mail;
     private $website;
	 private $password;
	 private $location;
     private $timestamp;
	
	 public function Fetch($id) {
	     $data = new Connection();
		 $data->Connect();
		 $data->Query("select * from users where id = ".$id);
		 
		 $obj = mysql_fetch_assoc($data->Get());
		 $this->id = $obj['id'];
		 $this->name = $obj['name'];
		 $this->username = $obj['username'];
		 $this->password = $obj['password'];
	 }
    
     public function getId() {
         return $this->id;
     }

     public function setId($id) {
         $this->id = $id;
     }

     public function getName() {
         return $this->name;
     }

     public function setName($name) {
         $this->name = $name;
     }
	
     public function getUsername() {
         return $this->username;
     }

     public function setUsername($username) {
         $this->username = $username;
     }

     public function getMail() {
         return $this->mail;
     }

     public function setMail($mail) {
         $this->mail = $mail;
     }

     public function getPassword() {
         return $this->password;
     }

     public function setPassword($password) {
         $this->password = $password;
     }
	 
     public function getWebsite() {
         return $this->website;
     }

     public function setWebsite($website) {
         $this->website = $website;
     }
	 
     public function getLocation() {
         return $this->location;
     }

     public function setLocation($location) {
         $this->location = $location;
     }

     public function getTimestamp() {
         return $this->timestamp;
     }

     public function setTimestamp($timestamp) {
         $this->timestamp = $timestamp;
     }


}

?>
