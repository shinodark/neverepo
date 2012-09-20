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
 
 */
 
class SetZipArchive {

	 private $id;
	 private $maps;
	 private $name;
	 private $description;
	 
	 public function __construct($name, $id, $description = "") {
	     $this->id = $id;
		 $this->name = $name;
		 $this->description = $description;
	 }
	 
	 public function StoreMaps($maps) {
	     $arc = new ZipArchive();
	     if ($arc->open($this->id . ".zip", ZIPARCHIVE::CREATE)!==TRUE) {
             @exit("Failed to load");
         }
		 $buffer = $this->SetFileHeader($this->name, $this->id, $this->description);
		 $counter_loop_once = true;
		 foreach($maps as $map) {
		 	$base = basename($map);
		    if($counter_loop_once) {
			     $buffer .= "shot-" .$this->id 
				                    ."/"
									.substr($base, 0, strlen($base) - 3)
									."png\n\n";
			     $counter_loop_once = false;
			}
		    $arc->addFromString("map-".$this->id ."/".basename($map), file_get_contents($map));
			$buffer .= "map-" .$this->id ."/". $base . "\n";
		 }
		 $arc->addFromString("map-".$this->id .".txt", $buffer);
		 $arc->close();
     }
	 
	 private function SetFileHeader($name, $id, $description) {
	     $buffer = $name . "\n" . $description . "\n" . $id . "\n";
	     return $buffer;
	 }
	 
	 public function StoreShots($shots) {
	 	 $arc = new ZipArchive();
	     if ($arc->open($this->id . ".zip", ZIPARCHIVE::CREATE)!==TRUE) {
             @exit("Failed to load");
         }
		 foreach($shots as $shot) {
		    $arc->addFromString("shot-".$this->id."/".basename($shot), file_get_contents($shot));
		 }
		 $arc->close();
     }
}
/*

// Example of usage:
$set = new SetZipArchive("Freeland Easy", "hteasy", "A simple set");
$set->StoreMaps (array("data/file.map","data/file2.map"));
$set->StoreShots(array("data/file.png","data/file2.png"));


*/

?>