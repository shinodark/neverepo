<?php

	class TreeView {
		
		 private $a_objElements = array ();
		 private $iTableID;
		 private static $iInstances = 0;
		
		 public function __construct(){
		     self::$iInstances ++;
			 $this->iTableID = self::$iInstances;
		 }
		
		 public function addDocument ($sName, $sAction=''){
			 $this->a_objElements [] = new TreeviewDocument($sName, $sAction);
		 }
		
		 public function addFolder ($sName, $bExpanded = false){
			 $iElements = count ($this->a_objElements);
			 $this->a_objElements [] = new TreeviewFolder($this->iTableID.'.'.($iElements + 1), $sName, $bExpanded);
			 return $iElements;
		 }
		
		 public function getObjFolder ($iKey){
			 if ($this->a_objElements[$iKey] instanceof TreeviewFolder){
				 return $this->a_objElements[$iKey];
			 }
			 else{
				 throw new Exception('Invalid object requested');
			 }
		 }
		
		 public function render ($iWidth = 0, $iHeight = 0){
			
			 $sCollapse = 'Collapse all';
			 $sExpand = 'Expand all';
					
			
			 $sReturn = '
				 <div style="width: '.($iWidth == 0 ? '100%':" $iWidth px;").'; height: '.($iHeight == 0 ? '100%':" $iHeight px;").'; overflow-x:auto; overflow-y:auto; text-align: left; padding: 5px;">
					 <a href="#" onclick="treeviewExpandAll ('.$this->iTableID.')" class="lnktxt">'.$sExpand.'</a> <a href="#" onclick="treeviewCollapseAll ('.$this->iTableID.')" class="lnktxt">'.$sCollapse.'</a>		
					 <ul id="objTree'.$this->iTableID.'" class="treeview">
			 ';	
			 foreach ($this->a_objElements as $objElement){
				 $sReturn .= $objElement->render ();
			 }
			 $sReturn .= '
					 </ul>
				 </div>
			 ';
			
			 return $sReturn;
		 }
	 }
	
	 class TreeviewDocument {
	 
		 private $sName;
		 private $sAction;
		
		 public function __construct($sName, $sAction){
			 $this->sName = $sName;
			 $this->sAction = $sAction;
		 }
	
		 public function render (){
			 global $objSession;
			 return '
				 <li class="treeviewFolderLi" style="margin-left: 18px;"><img src="img/document.gif">'.($this->sAction != '' ? '<a href="#" id="node_114" class="lnktxt" onclick="'.$this->sAction.'">'.$this->sName.'</a>':$this->sName).'</li>
			 ';
		 }
	}
	
	 class TreeviewFolder {
	
		 private $sName;
		 private $bExpanded;
		 private $sIDPrefix;
		 private $a_objElements = array ();
		
		 public function __construct($sIDPrefix, $sName, $bExpanded){
			 $this->sName = $sName;
			 $this->bExpanded = $bExpanded;
			 $this->sIDPrefix = $sIDPrefix;
		 }

		 public function addDocument ($sName, $sAction=''){
			 $this->a_objElements [] = new TreeviewDocument($sName, $sAction);
		 }
		
		 public function addFolder ($sName, $bExpanded = false){
			 $iElements = count ($this->a_objElements);
			 $this->a_objElements [] = new TreeviewFolder($this->sIDPrefix.'.'.($iElements + 1), $sName, $bExpanded);
			 return $iElements;
		 }
		
		 public function getObjFolder ($iKey){
			 if ($this->a_objElements[$iKey] instanceof TreeviewFolder){
				 return $this->a_objElements[$iKey];
			 }
			 else{
				 throw new Exception('Invalid object requested');
			 }
		 }
		
		 public function render (){
			 global $objSession;
			 $sReturn = '
				 <li class="treeviewFolderLi"><img id="objTreeCollapser'.$this->sIDPrefix.'" src="img/'.($this->bExpanded ? 'collapser':'expander').'.gif" style="visibility:'.(count ($this->a_objElements) > 0 ? 'show':'hidden').'"  onclick="treeviewExpandCollapse(\''.$this->sIDPrefix.'\')"><img src="img/folder.gif" ondblclick="treeviewExpandCollapse(\''.$this->sIDPrefix.'\')"><span ondblclick="treeviewExpandCollapse(\''.$this->sIDPrefix.'\')" onselectstart="return false;">'.$this->sName.'</span>
					 <ul id="objTreeUL'.$this->sIDPrefix.'" class="treeviewFolderUl" style="'.($this->bExpanded ? 'display: block':'display: none').'">
			 ';	
			 foreach ($this->a_objElements as $objElement){
				 $sReturn .= $objElement->render ();
			 }
			 $sReturn .= '
					 </ul>
				 </li>
			 ';
			
			 return $sReturn;
		 }
	 }
?>