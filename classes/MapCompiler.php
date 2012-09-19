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
 
 /*
 @author: Andrea Del Santo
 @copyright: Francois Guillet and contributors (me, the author, for example)
 */

class MapCompiler {
     private $MapcPath;
	 private $MapFile;
     public function __construct($mapc,$mapfile) {
	     $this->MapcPath = $mapc;
		 $this->MapFile = $mapfile;
	     echo shell_exec($mapc." ".$mapfile." ".dirname($mapc)."/data");
	 }
	 public function Update() {
	     echo shell_exec($this->MapcPath." ".$this->MapFile." ".dirname($this->MapcPath)."/data");
	 }
}
 
/*
     // usage example:
 
     $c = new MapCompiler("F:\Application\Neverball\App\Neverball\mapc.exe","file.map");
     $c->Update();
	 
 */
 ?>