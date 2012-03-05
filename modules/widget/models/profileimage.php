<?php namespace Widget;

use Resize;

class ProfileImage {

    private $dir150, $dir48, $date;
    protected $targ_w, $targ_h, $jpeg_quality;

    public function __construct() { 

        $this->date = date("mdyhis");
        $this->dir150 = "/var/www/s36-upload-images/uploaded_cropped/150x150/".$this->date."-cropped.jpg";
        $this->dir48 = "/var/www/s36-upload-images/uploaded_cropped/48x48/".$this->date."-cropped.jpg";
 
        $this->targ_w_large = 150;
        $this->targ_h_large = 150;

        $this->targ_w_small = 48;
        $this->targ_h_small = 48;
 
        $this->jpeg_quality = 100;
                    
    }

    public function auto_crop($img_src, $img_src_location) {
        $native_pic   = ($img_src_location == 'native') ? True : False;
        $facebook_pic = ($img_src_location == 'fb') ? True : False;
        $linkedin_pic = ($img_src_location == 'ln') ? True : False;
        $src = Null;
        $x = 0;
        $y = 0;
        $wd = 80;
        $ht = 80;

        if($native_pic) {
            $src = '/var/www/s36-upload-images/uploaded_tmp/'.$img_src;
        }

        if($facebook_pic || $linkedin_pic) {
            $src = $img_src;
        }

        if( strstr(strtolower($src),"graph.facebook.com") || strstr(strtolower($src), "media.linkedin.com") ){
            $extension = ".jpg";
        }else{
            $extension = strtolower(strrchr($src, '.'));
        }

        $maxwidth = 150;
        $maxheight = 150;
        //start image resizing..
        $url = get_all_redirects($src);
        if($url) {
            $file_src = $url[0];
        } else {
            $file_src = $src; 
        }


        $file_name = "/var/www/s36-upload-images/uploaded_tmp/".$this->date."-cropped.jpg"; 
        file_put_contents($file_name, file_get_contents($file_src));
        $resizeObj = new Resize($file_name);
        $resizeObj->resizeImage($maxwidth, $maxheight);
        $resizeObj->saveImage($file_name); 

        /*
        $file_src = file_get_contents($src);
        
        $resizeObj = new Resize($file_src);
        $resizeObj->resizeImage($maxwidth, $maxheight);
        $resizeObj->saveImage("/var/www/s36-upload-images/uploaded_tmp/".$this->date."-cropped.jpg"); 
        */

        /*
        switch($extension) {
            case '.jpg':
            case '.jpeg':
                $img_r150 = @imagecreatefromjpeg($src);
                $img_r48 = @imagecreatefromjpeg($src);
                break;
            case '.gif':
                $img_r150 = @imagecreatefromgif($src);
                $img_r48 = @imagecreatefromgif($src);
                break;
            case '.png':
                $img_r150 = @imagecreatefrompng($src);
                $img_r48 = @imagecreatefrompng($src);
                break;
            default:
                $img_r150 = false;
                $img_r48 = false;
            break;
        }
                    
        $dst_r150 = ImageCreateTrueColor( $this->targ_w_large, $this->targ_h_large ); 
        $dst_r48 = ImageCreateTrueColor( $this->targ_w_small, $this->targ_h_small ); 
        
        imagecopyresampled($dst_r150, $img_r150, 0, 0, $x, $y, $this->targ_w_large, $this->targ_h_large, $wd, $ht);
        imagejpeg($dst_r150, $this->dir150, $this->jpeg_quality);
        
        imagecopyresampled($dst_r48, $img_r48, 0, 0, $x, $y, $this->targ_w_small, $this->targ_h_small, $wd, $ht);
        imagejpeg($dst_r48, $this->dir48, $this->jpeg_quality);

        echo $this->date."-cropped.jpg"; 
        */
    }

    public function crop($input_params) {

        $this->input_params = $input_params;

        $fb_login = property_exists($this->input_params, 'fb_login') ? $this->input_params->fb_login : null; 
        $ln_login = property_exists($this->input_params, 'ln_login') ? $this->input_params->ln_login : null;
        $x  = $this->input_params->x_coords; 
        $y  = $this->input_params->y_coords;
        $wd = $this->input_params->wd; 
        $ht = $this->input_params->ht;
        $img_src = $this->input_params->src;
        $ophoto  = property_exists($this->input_params, 'oldphoto') ? $this->input_params->oldphoto : null;

        $src = '/var/www/s36-upload-images/'.$img_src;
        if($fb_login == 1 || $fb_login == 2) {
            $src = fb_photo_check($fb_login, $img_src);     
        }

        if($ln_login == 1) {
            $src = $img_src;
        }

        if($ophoto != 0){
            $this->remove_profile_photo($ophoto);
        }

        if( strstr(strtolower($src),"graph.facebook.com") || strstr(strtolower($src), "media.linkedin.com") ){
            $extension = ".jpg";
        }else{
            $extension = strtolower(strrchr($src, '.'));
        }

        switch($extension) {
            case '.jpg':
            case '.jpeg':
                $img_r150 = @imagecreatefromjpeg($src);
                $img_r48 = @imagecreatefromjpeg($src);
                break;
            case '.gif':
                $img_r150 = @imagecreatefromgif($src);
                $img_r48 = @imagecreatefromgif($src);
                break;
            case '.png':
                $img_r150 = @imagecreatefrompng($src);
                $img_r48 = @imagecreatefrompng($src);
                break;
            default:
                $img_r150 = false;
                $img_r48 = false;
            break;
        }
                    
        $dst_r150 = ImageCreateTrueColor( $this->targ_w_large, $this->targ_h_large ); 
        $dst_r48 = ImageCreateTrueColor( $this->targ_w_small, $this->targ_h_small ); 
        
        imagecopyresampled($dst_r150, $img_r150, 0, 0, $x, $y, $this->targ_w_large, $this->targ_h_large, $wd, $ht);
        imagejpeg($dst_r150, $this->dir150, $this->jpeg_quality);
        
        imagecopyresampled($dst_r48, $img_r48, 0, 0, $x, $y, $this->targ_w_small, $this->targ_h_small, $wd, $ht);
        imagejpeg($dst_r48, $this->dir48, $this->jpeg_quality);

        echo $this->date."-cropped.jpg";
    }

    public static function upload() { 
        $error = Null;
        $msg = Null;
        $filedir = Null;
        $width = Null;
        $file = 'your_photo';

        if(!empty($_FILES[$file]['error']))
        {
            switch($_FILES[$file]['error'])
            {
                case '1':
                    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                    break;
                case '2':
                    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                    break;
                case '3':
                    $error = 'The uploaded file was only partially uploaded';
                    break;
                case '4':
                    $error = 'No file was uploaded.';
                    break;
                case '6':
                    $error = 'Missing a temporary folder';
                    break;
                case '7':
                    $error = 'Failed to write file to disk';
                    break;
                case '8':
                    $error = 'File upload stopped by extension';
                    break;
                case '999':
                default:
                    $error = 'No error code avaiable';
            }
        }elseif(empty($_FILES[$file]['tmp_name']) || $_FILES[$file]['tmp_name'] == 'none'){
            $error = 'No file was uploaded..';
        }elseif(($_FILES[$file]['type'] != "image/jpeg") && 
                ($_FILES[$file]['type'] != "image/gif")  && 
                ($_FILES[$file]['type'] != "image/pjpeg")&& 
                ($_FILES[$file]['type'] != "image/x-png")&& 
                ($_FILES[$file]['type'] != "image/png")){
                $error = 'Please Upload Image Files Only'.$_FILES[$file]['type'];
        }else{
                                
                $filename = date("Ydmhis").$_FILES[$file]['name'];
                $filedir = "uploaded_tmp/".$filename;
                $maxwidth = 350;
                $maxheight = 230;
                $move = move_uploaded_file($_FILES[$file]['tmp_name'], "/var/www/s36-upload-images/uploaded_tmp/".$filename);
                if($move){    
                     //start image resizing..
                     $resizeObj = new Resize($filedir);
                     $resizeObj->resizeImage($maxwidth, $maxheight, 'auto');
                     $resizeObj->saveImage($filedir, 100);
                     
                     //get the optimal dimensions
                     $dims = $resizeObj->getDimensions($maxwidth, $maxheight, 'auto'); 
                     $width = $dims['optimalWidth'];
                }       
        } 

        echo json_encode(Array(
            "error" => $error
          , "dir" => $filedir
          , "wid" => $width
        ));
    }

    public function remove_profile_photo($name) { 

        $file150 = "/var/www/s36-upload-images/uploaded_cropped/150x150/".$name;
        $file48 = "/var/www/s36-upload-images/uploaded_cropped/48x48/".$name;
        
        $check150 = is_file($file150);
        $check48  = is_file($file48);
        
        if(isset($name) && $check150 && $check48) { 
            @unlink($file150);
            @unlink($file48);	
        } 
    }
}

//helper functions will move to seperate file later on
//WTF DOES THIS MEAN MATHEW!?!?!
function fb_photo_check($fb_login, $photo_src) {    
    if($fb_login == 1) return $photo_src;
    if($fb_login == 2) return "/var/www/s36-beta/public/".$photo_src;
    
    return "/var/www/s36-beta/public/".$photo_src;
}

/**
* get_redirect_url()
* Gets the address that the provided URL redirects to,
* or FALSE if there's no redirect.
*
* @param string $url
* @return string
*/
function get_redirect_url($url){
    $redirect_url = null;

    $url_parts = @parse_url($url);
    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false; //can't process relative URLs
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
    $request .= 'Host: ' . $url_parts['host'] . "\r\n";
    $request .= "Connection: Close\r\n\r\n";
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
        if ( substr($matches[1], 0, 1) == "/" )
        return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        else
        return trim($matches[1]);

    } else {
        return false;
    }

}

/**
* get_all_redirects()
* Follows and collects all redirects, in order, for the given URL.
*
* @param string $url
* @return array
*/
function get_all_redirects($url){
    $redirects = array();
    while ($newurl = get_redirect_url($url)){
        if (in_array($newurl, $redirects)){
            break;
        }
        $redirects[] = $newurl;
        $url = $newurl;
    }
    return $redirects;
}

/**
* get_final_url()
* Gets the address that the URL ultimately leads to.
* Returns $url itself if it isn't a redirect.
*
* @param string $url
* @return string
*/
function get_final_url($url){
    $redirects = get_all_redirects($url);
    if (count($redirects)>0){
        return array_pop($redirects);
    } else {
        return $url;
    }
}

