<?php namespace Helpers;

use Request;

class Helpers {

    private static $request;

    public static function request() {
        return Request::uri();
    }

    public static function switchable($element, $id, $hrefaction, $background) { 
        echo "state='".(($element) == 0 ? 0 : 1)."'";
        echo "feedid=".$id;
        echo ($element == 0) ? null : $background;
        echo " hrefaction='".$hrefaction."'";
    }

    //TODO: generalize this
    public static function filter_highlighter($urls, $type=False) {

        self::$request = self::request();

        foreach($urls as $url) { 
            $url_match = $url.(($type) ? '/'.$type : null);
            if(self::$request == $url_match) {
                return True; 
            }
        }
    }

    public static function nav_switcher() { 

        self::$request = self::request();

        if(preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|[0-9]+)/', self::$request, $matches)) {
            return Array('inbox/all', 'inbox/4', 'inbox/1', 'inbox/3', 'inbox/profanity', 'inbox/flagged', 'inbox/mostcontent');
        }

        $the_navs = Array('published', 'featured', 'filed');

        foreach($the_navs as $nav) {    
            if(preg_match_all('/'.$nav.'\/(all|profanity|flagged|mostcontent|[0-9]+)/', self::$request, $matches)) { 
                return Array('inbox/'.$nav.'/all', 'inbox/'.$nav.'/4', 'inbox/'.$nav.'/1', 'inbox/'.$nav.'/3', 
                             'inbox/'.$nav.'/profanity', 'inbox/'.$nav.'/flagged', 'inbox/'.$nav.'/mostcontent');
            }
        }


    }

    public static function left_side_nav() { 

        self::$request = self::request();

        return (object)Array( 
            'dashboard' => self::$request == 'dashboard',
            'inbox'     => preg_match_all('/inbox\/(all|[0-9]+|profanity|flagged|mostcontent)/', self::$request, $matches),
            'published' => preg_match_all('/published\/(all|profanity|flagged|mostcontent|[0-9]+)/', self::$request, $matches),
            'featured'  => preg_match_all('/featured\/(all|profanity|flagged|mostcontent|[0-9]+)/', self::$request, $matches),
            'profanity' => preg_match_all('/filed\/(all|profanity|flagged|mostcontent|[0-9]+)/', self::$request, $matches),
            'feedsetup' => preg_match_all('/(feedsetup|displaysetup|displaypreview)/', self::$request, $matches),
            'contacts'  => preg_match_all('/contacts|contacts\/(important|request)/', self::$request, $matches),
        );
    }
}
