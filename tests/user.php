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

define('IN_NEVEREPO', true);
set_include_path("..");

include_once "includes/ressources_inc.php";
include_once "includes/classes_inc.php";

try {
    $user = ForumUsersManager::getUserInfo(1);

    echo "id 1 is " . $user->getUserName() . "<br/>";

    $user = ForumUsersManager::getUserInfo(2);
    echo "id 2 is " . $user->getUserName() . " <br/>";

    $user = ForumUsersManager::getUserInfo(3);
    echo "id 3 is " . $user->getUserName() . " <br/>";

    $user = ForumUsersManager::getUserInfo(9999);
} catch (NeverepoRessourceException $ex) {
    echo '<span style="color:red;">' . $ex->getMessage() . '</span>';
}