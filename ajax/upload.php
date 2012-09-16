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

include_once "includes/classes_inc.php";
include_once "includes/libs_inc.php";
include_once "includes/ressources_inc.php";

$file = $_FILES['file']['tmp_name'];

try {
    $f = new FileManager();
    $f->Upload($_FILES, 'file', '../files', md5_file($file).'.sol', true);
}
catch (NeverepoLibException $e) {
    return $e->getMessage();
}

echo "true";

        
?>
