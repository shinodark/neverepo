<?php

class Color {
     public $r,$g,$b;
     function __construct($R,$G,$B) {
	     $this->r = $R;
		 $this->g = $G;
		 $this->b = $B;
	 }
}
class Render {
     function Text($text, $font = "monofont", $size = 16, $coeff = 16, $color = null) {
	     if($color == null) $color = new Color(255,0,0);
	     $font = $font.".ttf";
		 $height = ($size * 40) / $coeff;
		 $width = strlen($text) * $size + 20;
         $img  = "libs/libttf.php?text=".$text."&rand=1&font=".$font."&width=".$width;
		 $img .= "&height=".$height."&r=".$color->r."&g=".$color->g."&b=".$color->b;
		 echo "<img src=\"".$img."\">";
	 }
}

?>