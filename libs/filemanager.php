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

require_once 'classes/NeverepoLibException.php';

if (!defined('PATHMAX'))
    define('PATHMAX', 64);

class FileManager {

    private $filename = "";
    private $handle = null;

    /**
     * @param files $_FILES struct 
     * @param ident identification of file to upload
     * @param upload_dir target directory
     * @param file_name target file name
     * @param $always_overwrite overwrite target file
     * */
    function Upload($files, $ident, $upload_dir, $file_name, $always_overwrite = false) {
        $tmp_file = $files[$ident]['tmp_name'];

        if (empty($tmp_file))
            throw new NeverepoLibException(_("No uploaded file found."));

        /* test / at end of path */
        if (preg_match("/\/$/", $upload_dir) == 0)
            $upload_dir = $upload_dir . "/";

        if (version_compare(phpversion(), '4.2.0', '>='))
            $udp_error = $files[$ident]['error'];
        else
            $udp_error = -1;

        if ($udp_error != 0) {
            switch ($udp_error) {
                case 1 : $str = _("File size exceeds the authorized php limit.");
                    break;
                case 2 : $str = _("File size exceeds the configured limit.");
                    break;
                case 3 : $str = _("File was only partially uploaded.");
                    break;
                case 4 : $str = _("What ? No file uploaded !");
                    break;
                default: $str = _("Unknown error, code ") . $udp_error;
            }
            throw new NeverepoLibException($str);
        }

        if (!$always_overwrite) {
            /* Il file already exist, find another name */
            $i = 0;
            $base = $file_name;
            while (file_exists($upload_dir . $file_name)) {
                $file_name = $base . "_" . $i;
                $i++;
            }
        }

        if (@move_uploaded_file($tmp_file, $upload_dir . $file_name)) {
            $this->filename = $upload_dir . $file_name;
            chmod($upload_dir . $file_name, fileperms($upload_dir) & ~0111);
        } else {
            throw new NeverepoLibException(_("Error uploading file on server."));
        }

        return true;
    }

    function Unlink() {
        if (@unlink($this->filename)) {
            return true;
        } else {
            $msg = sprintf(_("Error deleting file %s from server !"), $this->filename);
            throw new NeverepoLibException($msg);
        }
    }

    function Move($newdir, $newname = "", $always_overwrite = false) {
        if (empty($newname))
            $newname = basename($this->filename);
        /* test / at end of path */
        if (preg_match("/\/$/", $newdir) == 0)
            $newdir = $newdir . "/";
        $newfile = $newdir . $newname;

        /* loop to change name it target file already exists */
        /* If a '_' is already there, delete it and incrementing */
        if (preg_match('/^(.*)_[^_]*$/', $newfile, $matches) > 0)
            $base = $matches[1];
        else
            $base = $newfile;

        $i = 0;
        if (!$always_overwrite) {
            while (file_exists($newfile)) {
                $newfile = $base . "_" . $i;
                $i++;
            }
        }

        if (!@rename($this->filename, $newfile)) {
            $msg = sprintf(_("Error Moving file %s to %s."), $this->filename, $newfile);    
            throw new NeverepoLibException($msg);
        } else {
            $this->filename = $newfile;
            return true;
        }
    }

    function Rename($newname) {
        $newname = dirname($this->filename) . "/" . $newname;
        if (file_exists($newname)) {
            $msg = sprintf(_("File with name %s already exists, don't overwrite."), $newname);     
            throw new NeverepoLibException($msg);
        }

        if (!@rename($this->filename, $newname)) {
            throw new NeverepoLibException(_("Error Renaming file %s."));
        } else {
            return true;
        }
    }

    function DirList($dir, $show_hidden = false) {
        $d = 0;
        $f = 0;
        $f_arr = array();
        $d_arr = array();

        if ($dirhandle = @opendir($dir)) {
            while (false !== ($file = @readdir($dirhandle))) {
                if (is_file($dir . "/" . $file)) {
                    if ((($show_hidden === false) && ($file[0] !== '.')) || $show_hidden === true)
                        $f_arr[$f++] = $file;
                }
                else if (is_dir($dir . "/" . $file) && $file !== "." && $file !== "..")
                    $d_arr[$d++] = $file;
            }
            closedir($dirhandle);
            return array("files" => $f_arr, "subdir" => $d_arr);
        }
        else {
            throw new NeverepoLibException(_("Error opening directory " . $dir));
            return false;
        }
    }

    function GetSize($unit = "o") {
        $res = @stat($this->filename);
        if (!$res) {
            throw new NeverepoLibException(_("Error in stat file ") . $this->filename);
            return false;
        }
        switch ($unit) {
            case "Mo": $ret = floor($res['7'] / 1024 / 1024);
                break;
            case "ko": $ret = floor($res['7'] / 1024);
                break;
            case "o":
            default : $ret = $res['7'];
                break;
        }
        return $ret;
    }

    function Stat() {
        return @stat($this->filename);
    }

    function Exists() {
        return @file_exists($this->filename);
    }

    function Open($att = "r") {
        if (!isset($this->handle)) {
            if ($att == "r" && (!file_exists($this->filename) || !is_readable($this->filename))) {
                $msg = sprintf("file %s doesn't exist or is not readable", $this->filename);
                throw new NeverepoLibException($msg);
            }
            $this->handle = @fopen($this->filename, $att);
        }
        if (!$this->handle) {
            $msg = sprintf(_("Error opening file %s with attribute %s"), $this->filename, $att);
            throw new NeverepoLibException($msg);
        }
    }

    function Close() {
        if (isset($this->handle))
            @fclose($this->handle);
        unset($this->handle);
    }

    function IsEof() {
        if (!isset($this->handle))
            return true;
        return @feof($this->handle);
    }

    function Tell() {
        if (!isset($this->handle))
            return false;
        return @ftell($this->handle);
    }

    function Seek($off) {
        if (!isset($this->handle))
            return false;
        return @fseek($this->handle, $off);
    }

    function Read() {
        if (!isset($this->handle)) {
            $ret = $this->Open();
            if (!$ret)
                return false;
        }
        $data = @fread($this->handle, filesize($this->filename));
        $this->Close();
        return $data;
    }

    function ReadLine() {
        if (!isset($this->handle)) {
            $ret = $this->Open();
            if (!$ret)
                return false;
        }
        $line = @fgets($this->handle, 4096);
        return $line;
    }

    function ReadString() {
        $data = file_get_contents($this->filename);
        if (!$data) {
            $msg = sprintf("Error opening file %s for reading.", $this->filename);
            throw new NeverepoLibException($msg);
        }
        return $data;
    }

    function Write($data) {
        if (!isset($this->handle)) {
            $ret = $this->Open("w");
            if (!$ret)
                return false;
        }
        if (!@fwrite($this->handle, $data)) {
            throw new NeverepoLibException(_("Error writing data to file ") . $this->filename);
            return false;
        }
        $this->Close();
        if (!@chmod($this->filename, 0666)) {
            throw new NeverepoLibException(_("Error chmod file " . $this->filename));
        }
        return true;
    }

    function ReadInt() {
        if (!isset($this->handle)) {
            $ret = $this->Open();
            if (!$ret)
                return false;
        }

        $BinaryData = fread($this->handle, 4);
        $UnpackedData = unpack("V", $BinaryData);
        return $UnpackedData[1];
    }

    function WriteInt($value) {
        if (!isset($this->handle)) {
            $ret = $this->Open('a');
            if (!$ret)
                return false;
        }

        $PackedData = pack("V", $value);
        fwrite($this->handle, $PackedData, 4);
        return true;
    }

    function ReadShort() {
        if (!isset($this->handle)) {
            $ret = $this->Open();
            if (!$ret)
                return false;
        }

        $BinaryData = fread($this->handle, 2);
        $UnpackedData = unpack("S", $BinaryData);
        return $UnpackedData[1];
    }

    function WriteShort($value) {
        if (!isset($this->handle)) {
            $ret = $this->Open('a');
            if (!$ret)
                return false;
        }

        $PackedData = pack("S", $value);
        fwrite($this->handle, $PackedData, 2);
        return true;
    }

    function ReadStringLength($length) {
        if (!isset($this->handle)) {
            $this->Open();
        }

        $c = chr(0);
        $str = " ";
        $i = 0;
        $max = $length;
        do {
            $c = fgetc($this->handle);
            $str{$i} = $c;
            $i++;
        } while ((ord($c) != 0) && ($max-- > 0));

        if (ord($str{$i - 1}) != 0)
            $str{$i - 1} = chr(0);

        return $str;
    }

    function WriteStringLength($str, $length) {
        if (!isset($this->handle)) {
            $this->Open('a+');
        }

        if (empty($str) || !($length > 0))
            return false;
        $c = $str{0};
        $i = 0;
        $max = $length - 1; //-1 for chr(0) at the end
        do {
            fwrite($this->handle, $c, 1);
            $i++;
            $c = $str{$i};
        } while ((ord($c) != 0) && ($max-- > 0));
        fwrite($this->handle, chr(0), 1);

        return true;
    }

    function GetHash() {
        return md5_file($this->filename);
    }

    function GetFileName() {
        return $this->filename;
    }

    function GetBaseName() {
        return basename($this->filename);
    }

    function SetFileName($filename) {
        $this->filename = $filename;
    }
}
