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

require_once "ressources/DatabaseManager.php";
require_once "libs/template.php";
require_once "classes/Set.php";
require_once "classes/Level.php";

$db = DatabaseManager::getDB();


$level = new Level();

$level->setAuthorId(1);
$level->setPreview("pic1");
$level->Insert();
$level->Insert();
$level->Insert();
$level->Insert();
$level->Insert();
$level->Insert();
$level->Insert();
$level->Insert();
$level->Delete();

$level->Fetch(1);
$level->setPreview($level->getPreview() . '+');
$level->Update();

echo "<br/>";

$res = $db->query("SELECT * FROM level");

$tpl = new Template('../views/');

$tpl->set_filenames(array(
    'list_levels' => 'list_levels.tpl'
));

$tpl->assign_var("MSG", _("Test message"));

while ( $row = $res->fetch()) {
    $tpl->assign_block_vars('level', array(
        'ID' => $row['id'],
        'AUTHOR' => $row['author_id'],
        'PREVIEW' => $row['preview']
    ));
}

$tpl->pparse('list_levels');

        
?>
