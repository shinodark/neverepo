<?php

class Connection {

     private $link;
	 private $db_selected;
	 private $query;
	 
     public function Connect() {
         $this->link = mysql_connect("localhost", 'nblev_admin', 'pwd1');
         if (!$this->link) {
             echo "<script>alert(\"Can't connect: ". mysql_error() ."\");</script>";
         }

         $this->db_selected = mysql_select_db('nblev_db', $this->link);
         if (!$this->db_selected) {
		     echo "<script>alert(\"Can't found your database: ". mysql_error() ."\");</script>";
         } 
	}
	
	public function Query($sqlstring) {
	     $this->query = mysql_query($sqlstring, $this->link);
	}
	
	public function Get() {
	     return $this->query;
    }
	
	public function Close() {
	     mysql_close($this->link);
	}
	
	public function Insert($t,$v,$r = null)
    {
         $istruzione = 'INSERT INTO '.$t;
         if($r != null) {
              $istruzione .= ' ('.$r.')';
         }
 
         for($i = 0; $i < count($v); $i++) {
             if(is_string($v[$i]))
                  $v[$i] = '"'.$v[$i].'"';
         }
         $v = implode(',',$v);
         $istruzione .= ' VALUES ('.$v.')';
 
         $query = mysql_query($istruzione) or die (mysql_error());
    }
	
	public function Extract($result) {
	     return mysql_fetch_object($result);
	}
}

?>