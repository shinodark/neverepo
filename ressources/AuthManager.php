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
 * AuthManager : Autentication helper using punBB
 *
 * @author shino,htnever
 */

define('FORUM_ROOT', "../".ConfigManager::getProperty("auth_punroot"));
require_once FORUM_ROOT.'include/common.php';

class AuthManager {

    static public function OpenSession() {
        global $forum_user;
        session_name("__neverepo");
        session_start();
        if (!$forum_user["is_guest"]) {
            $_SESSION['user_logged'] = true;
            $_SESSION['user_id'] = $forum_user["id"];
            $_SESSION['user_name'] = $forum_user["username"];
            $_SESSION['user_email'] = $forum_user["mail"];;
            $_SESSION['user_group'] = $forum_user["group_id"];
        }
        else {
            $_SESSION['user_logged'] = false;
            $_SESSION['user_id'] = 0;
        }
    }

    function CloseSession() {
        $_SESSION = array();
        session_unset();
        session_destroy();
    }
}

AuthManager::OpenSession();