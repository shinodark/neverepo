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

    private $solfileinfo = array();
    private $textinfo = array();
    private $filemanager = null;
    
    public function __construct($solpath) {
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
    
    private function Parse() {
        $inf = &$this->solfileinfo;
        
        $inf['ac']=$this->filemanager->ReadInt();
        $inf['dc']=$this->filemanager->ReadInt();
        $inf['mc']=$this->filemanager->ReadInt();
        $inf['vc']=$this->filemanager->ReadInt();
        $inf['ec']=$this->filemanager->ReadInt();
        $inf['sc']=$this->filemanager->ReadInt();
        $inf['tc']=$this->filemanager->ReadInt();
        $inf['gc']=$this->filemanager->ReadInt();
        $inf['lc']=$this->filemanager->ReadInt();
        $inf['nc']=$this->filemanager->ReadInt();
        $inf['pc']=$this->filemanager->ReadInt();
        $inf['bc']=$this->filemanager->ReadInt();
        $inf['hc']=$this->filemanager->ReadInt();
        $inf['zc']=$this->filemanager->ReadInt();
        $inf['jc']=$this->filemanager->ReadInt();
        $inf['xc']=$this->filemanager->ReadInt();
        $inf['rc']=$this->filemanager->ReadInt();
        $inf['uc']=$this->filemanager->ReadInt();
        $inf['wc']=$this->filemanager->ReadInt();
        $inf['ic']=$this->filemanager->ReadInt();
        
        /* Read text array as buffer */
        $text=$this->filemanager->ReadStringLength($inf['ac']);
        
        /* Read dict struct and create text indexed array $this->textinfo*/
        $ai=0;
        $aj=0;
        for ($i=0; $i<$inf['dc']; $i++) {
            $ai=$this->filemanager->ReadInt();
            $aj=$this->filemanager->ReadInt();
            if (($ai > (int)$inf['ac']) || ($aj > (int)$inf['ac'])) {
                throw new NeverepoLibException("SolParser : " . _("Invalid dict."));    
            }
            $this->textinfo[$this->extractString($text, $ai)] = $this->extractString($text, $aj);
        }
        
    }
    
    public function isPublic() {
        return ($this->textinfo['bonus'] == "1") ? true : false;
    }
    
    public function getMessage() {
        return $this->textinfo['message'];
    }

    public function GetHash() {
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
    
    private function extractString(&$text, $offset, $length=1024) {
        $str = " ";
        $i = 0;
        $j = (int)$offset;
        do {
            $c = $text{$j};
            $str{$i} = $c;
            $i++; $j++;
        } while (($c != chr(0)) && ($i < $length));

        $str{$i-1} = chr(0);
            
        return trim((string)$str);
    }
}
