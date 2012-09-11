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

set_include_path("..");

include_once "includes/libs_inc.php";
include_once "includes/classes_inc.php";
include_once "includes/ressources_inc.php";

ConfigManager::loadConfigFile("../config.ini");

$db = DatabaseManager::getDB();


$level = new Level();
$set = new Set();


$level->Fetch(1);
$set->Fetch(1);

echo "<br/>";

$db->query("INSERT INTO playlist (level_id,set_id) VALUES (3,1)");
$db->query("INSERT INTO playlist (level_id,set_id) VALUES (3,3)");
$db->query("INSERT INTO playlist (level_id,set_id) VALUES (1,5)");

$res = $db->query("SELECT * FROM playlist LEFT JOIN level ON level.id=playlist.level_id LEFT JOIN `set` ON set.id=playlist.set_id");

$tpl = new Template('../views/');

$tpl->set_filenames(array(
    'playlist' => 'playlist.tpl'
));

while ( $row = $res->fetch()) {
    $tpl->assign_block_vars('playlist', array(
        'preview' => $row['preview'],
        'set_name' => $row['name'],
        'user_id' => $row['author_id']
    ));
}

$tpl->pparse('playlist');

echo "fin";


        
?>
