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
 * ForumUsersManager
 * 
 * Retrieve user informations from punBB database
 *
 * @author shino
 */
define('FORUM_ROOT', "../" . ConfigManager::getProperty("auth_punroot"));
require_once FORUM_ROOT . 'include/common.php';

class ForumUsersManager {

    static private $forum_users_info;

    /**
     * 
     * @param int $id punBB id of the user
     * @return array users info indexed by ID
     * @throws NeverepoRessourceException
     */
    static public function getUserInfo($id) {

        if (!self::$forum_users_info) {
            self::getUsersInfo();
        }
        if (!array_key_exists($id, self::$forum_users_info)) {
            $msg = sprintf(_("User with id %d doesn't exist."), $id);
            throw new NeverepoRessourceException("ForumUsersManager::getUserInfo() : " . $msg);
        }
        return self::$forum_users_info[$id];
    }

    /**
     * Method getting query results and caching them in static property.
     */
    static private function getUsersInfo() {

        if (!self::$forum_users_info) {
            global $forum_db;
            
            $query_active_topics = array(
                'SELECT' => 'id, group_id, username, email, title, realname, avatar, avatar_width, avatar_height',
                'FROM' => 'users'
            );
            $res = $forum_db->query_build($query_active_topics);
            if ($res == false)
                throw new NeverepoRessourceException("ForumUsersManager::getUsersInfo() : " . _("Error in forum query."));
            if ($forum_db->num_rows($res) < 1) {
                throw new NeverepoRessourceException("ForumUsersManager::getUsersInfo() : " . _("Error in forum query"));
            }

            while ($user_arr = $forum_db->fetch_assoc($res)) {
                $user = new User();
                $user->Fill($user_arr);
                self::$forum_users_info[$user->getId()] = $user;
            }
        }
    }

}
