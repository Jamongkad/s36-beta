<?php namespace Helpers;

use Request, View;

class Helpers {

    private static $request;
    private static $regex;

    public static function request() {
        return Request::uri();
    }

    public static function switchable($element, $id, $catid, $hrefaction, $background) { 
        echo "state='".(($element) == 0 ? 0 : 1)."'";
        echo "catid='".$catid."'";
        echo "feedid='".$id."'";
        echo ($element == 0) ? null : $background;
        echo " hrefaction='".$hrefaction."'";
    }

    //TODO: generalize this
    public static function filter_highlighter($urls, $type=False) {

        $request = self::request();

        $filter = function($url) use ($type, $request) {
            $url_match = $url . (($type) ? '/'.$type : null);
            $regex_match = '~^'.$url_match.'$~';
            return preg_match($regex_match, $request, $matches);   
        };
        
        if(is_array($urls)) { 
            return array_filter($urls, $filter);
        } 

        return call_user_func($filter, $urls);     
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
            'dashboard' => preg_match_all('/dashboard/', self::$request, $matches), 
            'deleted'   => preg_match_all('/deleted/', self::$request, $matches),
            'inbox'     => preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'published' => preg_match_all('/published\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'featured'  => preg_match_all('/featured\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'filed'     => preg_match_all('/filed\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'feedsetup' => preg_match_all('/(feedsetup|displaysetup|displaypreview)/', self::$request, $matches),
            'contacts'  => preg_match_all('/contacts|contacts\/(important|request)/', self::$request, $matches),
            'admin'     => preg_match_all('/admin/', self::$request, $matches),
        );
    }

    public static function inbox_state($filter) {

        if($filter == "published") {
            return "publish";          
        }

        if($filter == "featured") {
            return "feature";          
        } 

        if($filter == "filed") {
            return "fileas";
        }

        if($filter == "all") {
           return "inbox";
        }

    }
    
    //retained for legacy shit
    public static function show_data($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    
    //wrapper
    public static function dump($data) {
        return self::show_data($data);
    }


    public static function limit_string($string, $limit = 100) {
        // Return early if the string is already shorter than the limit
        if(strlen($string) < $limit) {return $string;}

        $regex = "/(.{1,$limit})\b/";
        preg_match($regex, $string, $matches);
        return $matches[1]."...";
    }

    public static function render_iframe_code($frame_url, $width, $height) { 
        $iframe = "<span style='z-index:100001'>
                    <iframe id='s36Widget' 
                            allowTransparency='true' 
                            width={$width}
                            height={$height}
                            frameborder='0' 
                            scrolling='no' 
                            src='$frame_url'>Your Widget</iframe>
                    </span>";
         return trim($iframe);
    }

    public static function tab_position_css_output() { 
        //TODO: From zeh database this should be
        $tab_themes = array(
            'aglow'=>'Aglow'
          , 'silver'=>'Silver'
          , 'chrome'=>'Chrome'
          , 'classic'=>'Classic'
          , 'black'=>'Black'
          , 'silver-gray'=>'Silver Gray'
          , 'ocean-blue'=>'Ocean Blue'
          , 'forest-green'=>'Forest Green'
          , 'mandarin'=>'Mandarin'
          , 'sleek-orange'=>'Sleek Orange'
          , 'thin-red'=>'Thin Red'
        );
	
        $positions = Array();
        
        foreach(Array('r', 'l', 'br', 'bl', 'tr', 'tl') as $v) {
            $positions[$v] = $tab_themes;
        }
        
        return View::make('partials/tab_position_css_output', Array('positions' => $positions));
    }

    public static function sanitize($string) {
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $string);
        return $page;
    }

    public static function tab_position($tab_type) {
        $match = null;  
        if ( preg_match('~tab-(br|bl|tr|tl)~', $tab_type, $match) ) {
            $tab_pos = 'corner';
        } else {
            $tab_pos = 'side';
        } 

        return $tab_pos; 
    }
}
