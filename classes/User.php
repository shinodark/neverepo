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
 * Description of User according to punBB model
 * It's a read only class.
 *
 * @author shino,htnever
 */
class User extends NeverepoModelClass {
    
    private $id;
    private $group_id;
    private $username;
    private $email;
    private $title;
    private $realname;
    private $avatar;
    private $avatar_width;
    private $avatar_height;    

    public function getId() {
        return $this->id;
    }

    public function getGroup_id() {
        return $this->group_id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getRealname() {
        return $this->realname;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getAvatar_width() {
        return $this->avatar_width;
    }

    public function getAvatar_height() {
        return $this->avatar_height;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setGroup_id($group_id) {
        $this->group_id = $group_id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setRealname($realname) {
        $this->realname = $realname;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function setAvatar_width($avatar_width) {
        $this->avatar_width = $avatar_width;
    }

    public function setAvatar_height($avatar_height) {
        $this->avatar_height = $avatar_height;
    }


}

?>
