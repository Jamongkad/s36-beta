<?php namespace Helpers;

use Request;

class Helpers {
    public static function switchable($element, $id, $hrefaction, $background) { 
        echo "state='".(($element) == 0 ? 0 : 1)."'";
        echo "feedid=".$id;
        echo ($element == 0) ? null : $background;
        echo " hrefaction='".$hrefaction."'";
    }

    public static function filter_highlighter() {
        $request_uri = Request::uri();
        if($request_uri == 'inbox' || $request_uri == 'inbox/published' || $request_uri == 'inbox/featured' || $request_uri == 'inbox/filed') {
            return True; 
        }
    }
}
