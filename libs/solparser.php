<?php

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

if (!defined('IN_NEVEREPO')) {
    exit;
}

require_once 'libs/filemanager.php';

define('SOL_MAGIC', 0x4C4F53AF);
define('SOL_VERSION_1_5', 6);

class SolParser {

    private $solinfo = array();
    private $filemanager = null;
    
    function __construct($solpath) {
        $this->filemanager = new FileManager();
        $this->filemanager->SetFileName($solpath);
        $this->filemanager->Open();
        
        $magic = $this->filemanager->ReadInt();
	if ($magic != SOL_MAGIC) {
            throw new NeverepoLibException("SolParser : " . _("Invalid sol file."));    
        }
        $version = $this->filemanager->ReadInt();
	if ($version != SOL_VERSION_1_5) {
            throw new NeverepoLibException("SolParser : " . _("Invalid sol version."));    
        }
        
        $this->solinfo['magic'] = $magic;
        $this->solinfo['version'] = $version;
        
        $this->Parse();
    }
    
    function Parse() {
        
    }
    
    function GetInfo() {
        return $this->solinfo;
    }

    function GetHash() {
        if ($this->filemanager == null) {
            throw new NeverepoLibException("SolParser::GetHash() : " . _("Invalid file."));
        }
        return $this->filemanager->GetHash();
    }

    function GetFileManager() {
        if ($this->filemanager == null) {
            throw new NeverepoLibException("SolParser::GetFileManager() : " . _("Invalid file."));
        }
        return $this->filemanager;
    }
}
