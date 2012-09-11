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
 * Description of ConfigManager
 *
 * @author shino
 */
class ConfigManager {
    private static $config = array();
    
    public static function setProperty($property, $value) {
        self::$config[$property] = $value;
    }
    
    public static function setProperties($properties) {
        foreach ($properties as $key => $value) {
            self::$config[$key] = $value;  
        }
    }
    
    public static function getProperty($property) {
        return self::$config[$property];
    }
    
    public static function loadConfigFile($path) {
        $arr = parse_ini_file($path, true);
        
        if ($arr === FALSE) {
            throw new NeverepoRessourceException ("Can't load configuration file.");
        }
        if (!array_key_exists('Database', $arr)) {
            throw new NeverepoRessourceException ("Invalid config file, missing Database section.");
        }
        foreach ($arr["Database"] as $key => $value)
            self::setProperty("database_".$key, $value);
    }
}

?>
