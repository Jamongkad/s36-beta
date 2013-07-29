<?php namespace Helpers;

use Request, View, DB, Config, HTML;

class Helpers {

    private static $request;
    private static $regex;

    //TODO: From zeh database this should be Helpers Class managing too many things at once
    public static $tab_themes = Array(
            'aglow'=>'Aglow'
          , 'silver'=>'Silver'
          , 'chrome'=>'Chrome'
          , 'classic'=>'Classic'
          , 'dark' => 'Dark'
          , 'dark-heart' => 'Dark Heart'
          , 'dark-like' => 'Dark Like'
          , 'alum'   => 'Aluminum'
          , 'alum-heart' => 'Aluminum Heart'
          , 'alum-like' => 'Aluminum Like'
          , 'contrast' => 'Contrast'
          , 'contrast-heart' => 'Contrast Heart'
          , 'contrast-like' => 'Contrast Like'
          , 'matte'  => 'Matte' 
          , 'matte-heart'  => 'Matte Heart'
          , 'matte-like'  => 'Matte Like'
          , 'silver-gray'=>'Silver Gray'
          , 'pencil'  => 'Pencil' 
          , 'pencil-heart'  => 'Pencil Heart'
          , 'pencil-like'  => 'Pencil Like'
    );

    public static function request() {
        return Request::uri();
    }
    
    public static function fb_comment_str($str){
        return nl2br(HTML::entities( preg_replace('/[\n]{3,}/', "\n\n", trim($str)) ));
    }
    
    // a function to make a single replacement of $search with $replace in $subject.
    // because str_replace replaces all the matches found.
    public static function single_str_replace($search, $replace, $subject){
        
        $pos = strpos($subject, $search);
        
        if( $pos === false ) return $subject;
            
        return substr_replace($subject, $replace, $pos, strlen($search));
        
    }
    
    public static function urls_to_links($str){
        
        // solution 1.
        // that extra "http" in $link will be removed in link if "http" or "https" already exists.
        $url_regex = '/((https?\:\/\/)?(www\.)?[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*)/i';
        $link = '<a href="http://$1" target="_blank">$1</a>';
        $str = preg_replace($url_regex, $link, $str);
        $str = str_replace('http://http', 'http', $str);
        return $str;
        
        
        // solution 2.
        // don't wanna remove this code as a remembrance. if i'll ever remember this.
        // preg_match_all($url_regex, $str, $urls);
        // $offset = 0;
        
        // foreach( $urls[0] as $url ){
        //     $http = ( ! strstr($url, 'http') ? 'http://' : '' );
        //     $link = '<a href="' . $http . $url . '" target="_blank">' . $url . '</a>';
            
        //     $pos = strpos($str, $url, $offset);
        //     $str = substr_replace($str, $link, $pos, strlen($url));
        //     $offset = $pos + strlen($link);
        // }
        
        // return $str;
        
    }
    
    //TODO: Refactor
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

        $the_navs = Array('published', /*'featured',*/ 'filed');

        foreach($the_navs as $nav) {    
            if(self::$regex->{$nav}) { 
                if($nav == 'published') { 
                    return Array('inbox/'.$nav.'/all',  'inbox/'.$nav.'/profanity', 'inbox/'.$nav.'/flagged', 'inbox/'.$nav.'/mostcontent');
                } else { 
                    return Array('inbox/'.$nav.'/all', 'inbox/'.$nav.'/positive', 'inbox/'.$nav.'/negative', 'inbox/'.$nav.'/neutral', 
                                 'inbox/'.$nav.'/profanity', 'inbox/'.$nav.'/flagged', 'inbox/'.$nav.'/mostcontent');
                }
            }
        }


    }

    public static function nav_regex() { 

        self::$request = self::request();

        return (object)Array( 
            'home'      => preg_match('/^\/$/', self::$request),
            'single'    => preg_match('/^single/', self::$request),
            'dashboard' => preg_match_all('/dashboard/', self::$request, $matches), 
            'deleted'   => preg_match_all('/deleted/', self::$request, $matches),
            'inbox'     => preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'published' => preg_match_all('/published\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'featured'  => preg_match_all('/featured\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'filed'     => preg_match_all('/filed\/(all|profanity|flagged|mostcontent|positive|negative|neutral|[0-9]+)/', self::$request, $matches),
            'feedsetup' => preg_match_all('/(feedsetup|displaysetup|displaypreview)/', self::$request, $matches),
            'contacts'  => preg_match_all('/contacts|contacts\/(important|request)/', self::$request, $matches),
            'admin'     => preg_match_all('/admin/', self::$request, $matches),
            'settings'  => preg_match_all('/settings\/(display|[0-9]+)/', self::$request, $matches),
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

        if($filter == "deleted") {
            return "delete";
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

    public static function secure_link($url) {
        return str_replace('http://', 'https://', $url);
    }

    public static function limit_string($string, $limit = 100) {
        // Return early if the string is already shorter than the limit
        if(strlen($string) < $limit) {return $string;}

        $regex = "/(.{1,$limit})\b/";
        preg_match($regex, $string, $matches);
        return $matches[1]."...";
    }

    public static function limit_text($text, $limit = 5) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;                                          
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
        $positions = Array();
        
        $widget = new \Widget\Repositories\DBWidgetThemes;         
        $widget->build_menu_structure();  
        $widget->build_tab_themes();

        foreach(Array('r', 'l', 'br', 'bl', 'tr', 'tl') as $v) {
            $positions[$v] = $widget->perform()->tab_themes; 
        }
        
        return View::make('partials/tab_position_css_output', Array(
            'positions' => $positions, 'url' => Config::get('application.deploy_env')
        ));
    }

    public static function sanitize($string) {
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $string);
        return $page;
    }

    public static function tab_position($tab_type) {
        $match = null;  
        if ( preg_match('~tab-(br|bl|tr|tl)~', $tab_type, $match) ) {
            return 'corner';
        } else {
            if( preg_match('~(heart|like)~', $tab_type, $match) ) {
                return 'small-side';     
            } 
            return 'side';     
        } 
    }

    public static function wrap($object) {
        $obj = base64_encode( serialize($object) );
        return $obj;  
    }

    public static function unwrap($object) {
        $obj = unserialize( base64_decode($object) );
        return $obj; 
    }

    public static function make_forward_url($company_id, $forward_url) { 
        $company = DB::Table('Company', 'master')->where('companyId', '=', $company_id)->first(array('name'));
        $host_url = strtolower($company->name).'.'.Config::get('application.hostname').'.com';
        $login_url = trim("https://".$host_url."/login?forward_to=".$forward_url);
        return $login_url;
    }

    public static function html_cleaner($url) {
        $U = explode(' ', $url);
         
        foreach ($U as $k => $u) {
            if (stristr($u,".")) { //only preg_match if there is a dot    
                if (self::contains_tld($u) === true) {
                    unset($U[$k]);
                    return self::html_cleaner(implode(' ',$U));
                }      
            }
        }
        return implode(' ',$U);
    }
    

    public static function relative_time($time, $short=False) {
        $SECOND = 1;
        $MINUTE = 60 * $SECOND;
        $HOUR = 60 * $MINUTE;
        $DAY = 24 * $HOUR;
        $MONTH = 30 * $DAY;
        $before = time() - $time;

        if ($before < 0) {
            return "not yet";
        }

        if ($short) {
            if ($before < 1 * $MINUTE) {
                return ($before <5) ? "just now" : $before . " ago";
            }

            if ($before < 2 * $MINUTE) {
                return "1m ago";
            }

            if ($before < 45 * $MINUTE) {
                return floor($before / 60) . "m ago";
            }

            if ($before < 90 * $MINUTE) {
                return "1h ago";
            }

            if ($before < 24 * $HOUR) {
                return floor($before / 60 / 60). "h ago";
            }

            if ($before < 48 * $HOUR) {
                return "1d ago";
            }

            if ($before < 30 * $DAY) {
                return floor($before / 60 / 60 / 24) . "d ago";
            }


            if ($before < 12 * $MONTH) {
                $months = floor($before / 60 / 60 / 24 / 30);
                return $months <= 1 ? "1mo ago" : $months . "mo ago";
            } else {
                $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
                return $years <= 1 ? "1y ago" : $years."y ago";
            }
        }

        if ($before < 1 * $MINUTE) {
            return ($before <= 1) ? "just now" : $before . " seconds ago";
        }

        if ($before < 2 * $MINUTE) {
            return "a minute ago";
        }

        if ($before < 45 * $MINUTE) {
            return floor($before / 60) . " minutes ago";
        }

        if ($before < 90 * $MINUTE) {
            return "an hour ago";
        }

        if ($before < 24 * $HOUR) {

            return (floor($before / 60 / 60) == 1 ? 'about an hour' : floor($before / 60 / 60).' hours'). " ago";
        }

        if ($before < 48 * $HOUR) {
            return "yesterday";
        }

        if ($before < 30 * $DAY) {
            return floor($before / 60 / 60 / 24) . " days ago";
        }

        if ($before < 12 * $MONTH) {
            $months = floor($before / 60 / 60 / 24 / 30);
            return $months <= 1 ? "one month ago" : $months . " months ago";
        } else {
            $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
            return $years <= 1 ? "one year ago" : $years." years ago";
        }

        return $time;       
    }

    public static function contains_tld($string) {
        return \Helpers\HasTld::check($string);
    }

    public static function arrayToObject($data){

        if(is_array($data)) {
            $data = json_encode($data);
            $data = json_decode($data);
            return $data;
        }else{
            return $data;
        }

    }

    public static function randid() {
        return substr(uniqid ('', true), -3);
    }
 
    public static function get_client_ip(){
        
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) ){
            if( preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR']) ){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } 
        return $ip;        
    }

    public static function count_words($str) { 
        while(substr_count($str, "  ") > 0) {
            $str = str_replace("  ", " ", $str);
        }
        return substr_count($str, " ") + 1;
    } 

    public static function avatar_render($avatar, $origin) { 
        if($origin == 'tw' && !empty($avatar)) {
            return $avatar; 
        }

        if(($origin == 'fb' && !empty($avatar)) || !empty($avatar)) {
            return Config::get('application.avatar48_dir').'/'.$avatar;
        }

        return '/img/48x48-blank-avatar.jpg';
    }

    public static function urlExists($url=NULL)
    {
        if($url == NULL) return false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 
        if($httpcode>=200 || $httpcode==301 || $httpcode==302){
            return true;
        } else {
            return false;
        }
    }
}
