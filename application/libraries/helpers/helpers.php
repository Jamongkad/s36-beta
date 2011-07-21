<?php namespace Helpers;

class Helpers {
    public static function switchable($element, $id, $hrefaction, $background) { 
        echo "state='".(($element) == 0 ? 0 : 1)."'";
        echo "feedid=".$id;
        echo ($element == 0) ? null : $background;
        echo " hrefaction='".$hrefaction."'";
    }
}
