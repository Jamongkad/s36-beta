<?php namespace Helpers;

use Request;

class Helpers {

    private static $request;
    private static $regex;

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
        self::$regex = self::nav_regex();

        if(self::$regex->inbox) {
            return Array('inbox/all', 'inbox/positive', 'inbox/negative', 'inbox/neutral', 'inbox/profanity', 'inbox/flagged', 'inbox/mostcontent');
        }

        $the_navs = Array('published', 'featured', 'filed');

        foreach($the_navs as $nav) {    
            if(self::$regex->{$nav}) { 
                return Array('inbox/'.$nav.'/all', 'inbox/'.$nav.'/positive', 'inbox/'.$nav.'/negative', 'inbox/'.$nav.'/neutral', 
                             'inbox/'.$nav.'/profanity', 'inbox/'.$nav.'/flagged', 'inbox/'.$nav.'/mostcontent');
            }
        }


    }

    public static function nav_regex() { 

        self::$request = self::request();

        return (object)Array( 
            'dashboard' => self::$request == 'dashboard',
            'inbox'     => preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'published' => preg_match_all('/published\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'featured'  => preg_match_all('/featured\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'filed'     => preg_match_all('/filed\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'feedsetup' => preg_match_all('/(feedsetup|displaysetup|displaypreview)/', self::$request, $matches),
            'contacts'  => preg_match_all('/contacts|contacts\/(important|request)/', self::$request, $matches),
        );
    }
}
