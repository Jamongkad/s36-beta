<?php namespace Helpers;

use Request;

class Helpers {
    public static function switchable($element, $id, $hrefaction, $background) { 
        echo "state='".(($element) == 0 ? 0 : 1)."'";
        echo "feedid=".$id;
        echo ($element == 0) ? null : $background;
        echo " hrefaction='".$hrefaction."'";
    }


    //TODO: generalize this
    public static function filter_highlighter($urls, $type=False) {
        $request_uri = Request::uri();
        foreach($urls as $url) { 
            if($request_uri == $url.'/'.$type) {
                return True; 
            }
        }
    }

    public static function nav_switcher() { 

        $request_uri = Request::uri();

        if(preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|[0-9]+)/', $request_uri, $matches)) {
            return Array('inbox/all', 'inbox/4', 'inbox/1', 'inbox/3', 'inbox/profanity', 'inbox/flagged', 'inbox/mostcontent');
        }

        $the_navs = Array('published', 'featured', 'filed');

        foreach($the_navs as $nav) {    
            if(preg_match_all('/'.$nav.'\/(all|profanity|flagged|mostcontent|[0-9]+)/', $request_uri, $matches)) { 
                return Array('inbox/'.$nav.'/all', 'inbox/'.$nav.'/4', 'inbox/'.$nav.'/1', 'inbox/'.$nav.'/3', 
                             'inbox/'.$nav.'/profanity', 'inbox/'.$nav.'/flagged', 'inbox/'.$nav.'/mostcontent');
            }
        }
    }
}
