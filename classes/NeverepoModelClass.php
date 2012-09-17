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
 * Description of NeverepoModelClass
 *
 * Abstract class used as parent for other model class.
 * Contains useful methods to access properties with getters / setters automagically
 * from property name.
 * 
 * State that getters and setters fits name convention as follow :
 *   $id -> getId() / setId()
 *   $other_example_for_fun -> getOtherExampleForFun() / setOtherExampleForFun()
 * 
 * 
 * @author shino
 */

if (!defined('IN_NEVEREPO')) {
    exit;
}

abstract class NeverepoModelClass {
    protected $rc;
    
    function __construct() {
        $this->rc = new ReflectionClass($this);
    }
    
    public function Fill($array) {
        foreach ($array as $key => $value) {
            $methodName = $this->getCanonicalSetter($key);
            if ($this->rc->hasMethod($methodName)) {
                $this->rc->getMethod($methodName)->invoke($this, $value);
            }
        }
    }
       
    private function getCanonicalSetter($property) {
        return "set".$this->getCanonicalName($property);
    }
    
    private function getCanonicalGetter($property) {
        return "get".$this->getCanonicalName($property);
    }
    
    private function getCanonicalName($property) {
        $tmp = explode("_", $property);
        $canon = "";
        
        foreach ($tmp as $str) {
            $canon = $canon .  ucfirst($str);
        }
        return $canon;
    }
}

?>
