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
 
class MapParser {
     private $MapCode;
	 private $Author;
     public function __construct($mapfile) {
	     if(file_exists($mapfile)) {
		     $file_handle = fopen("file.map", "r");
             while (!feof($file_handle)) {
                 $this->MapCode .= fgets($file_handle);
             }
             fclose($file_handle);
		}
	 }
	 public function getAttribute($str) {
	     $arr = explode("\"", $this->MapCode);
		 $counter = 0;
		 foreach($arr as $arvalue) {
		    if($arvalue == $str) {
			     return $arr[$counter+2];
			}
			$counter++;
		 }
	 }
 }
 /*
 // usage example:
 
 $m = new MapParser("file.map");
 echo $m->getAttribute("message");
 */
 
 ?>