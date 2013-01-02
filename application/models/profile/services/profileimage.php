<?php namespace Profile\Services;

use Resize;
use Imagine;

class ProfileImage {

    private $dir150, $dir48, $date;
    protected $targ_w, $targ_h, $jpeg_quality;

    public function __construct() { 

        $this->date   = date("mdyhis");
        $this->dir48  = "/var/www/s36-upload-images/uploaded_cropped/48x48/".$this->date."-cropped.jpg";
        $this->dir150 = "/var/www/s36-upload-images/uploaded_cropped/150x150/".$this->date."-cropped.jpg";
 
        $this->targ_w_large = 150;
        $this->targ_h_large = 150;

        $this->targ_w_small = 48;
        $this->targ_h_small = 48;
 
        $this->jpeg_quality = 100;
                    
    }

    public function auto_resize($img_src, $img_src_location) {
        $src = Null;
        $file_name = Null;

        if($img_src_location == 's36') {
            $file_name = '/var/www/s36-upload-images'.$img_src;
        }

        if($img_src_location == 'fb' || $img_src_location == 'ln') {

            $src = $img_src;
            $url = get_all_redirects($src);
            if($url) {
                //For Facebook url redirects...
                $file_src = $url[0];
            } else {
                //For Linkedin
                $file_src = $src; 
            }
            
            //fucking fix: if user does not like to use his or her pic from FB and LinkedIn
            if(preg_match("~/uploaded_tmp/([a-zA-Z-_0-9]+.[jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG]+)~", strtolower($src), $match)) { 
                $file_name = '/var/www/s36-upload-images'.$src;
            } else { 
                $file_name = "/var/www/s36-upload-images/uploaded_tmp/".$this->date.".jpg";      
                file_put_contents($file_name, file_get_contents($file_src));
            }
        } 
        
        //save and resize pics in 48 and 150 directories
        $this->_save_pic($file_name, $this->dir48, $this->targ_w_small, $this->targ_h_large);
        $this->_save_pic($file_name, $this->dir150, $this->targ_w_large, $this->targ_h_large);
        @unlink($file_name);
        return $this->date."-cropped.jpg";
    }

    private function _save_pic($file_name, $new_file_name, $width, $height) { 
        $imagine = new Imagine\Gd\Imagine();
        $size = new Imagine\Image\Box($width, $height);
        $mode = Imagine\Image\ImageInterface::THUMBNAIL_INSET;

        $options = Array('quality' => 100);
        $imagine->open($file_name)
                ->thumbnail($size, $mode)
                ->save($new_file_name, $options);
    }

    public function crop($input_params) {

        $this->input_params = $input_params;
        $login_type = $this->input_params->login_type;
        $x  = $this->input_params->x_coords; 
        $y  = $this->input_params->y_coords;
        $wd = $this->input_params->wd; 
        $ht = $this->input_params->ht;
        $img_src = $this->input_params->src;
        $ophoto  = $this->input_params->oldphoto;

        $src = null;

        if($login_type == 'fb') {
            $url = get_all_redirects($img_src);
            if($url) {
                //For Facebook url redirects...
                $src = $url[0];
                $image = $this->_verify_image($src);
            }         
        }
        
        if($login_type == '36' || preg_match("~/uploaded_tmp/([a-zA-Z-_0-9]+.[jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG]+)~", strtolower($img_src), $match)) {  
            $image = '/var/www/s36-upload-images'.$img_src;
        }        
   
        if($ophoto != 0){
            $this->remove_profile_photo($ophoto);
        }
        $this->_crop_pic($image, $this->dir150, $x, $y, $wd, $ht, new Imagine\Image\Box(150, 150));
        $this->_crop_pic($image, $this->dir48, $x, $y, $wd, $ht, new Imagine\Image\Box(48, 48));
        echo $this->date."-cropped.jpg";  
    }

    private function _crop_pic($source_file_name, $file_name, $x, $y, $width, $height, $resize) {
        $imagine = new Imagine\Gd\Imagine();
        $point = new Imagine\Image\Point($x, $y);
        $size = new Imagine\Image\Box($width, $height);
        $mode = Imagine\Image\ImageInterface::THUMBNAIL_INSET;

        $options = Array('quality' => 100);

        $imagine->open($source_file_name) 
                ->crop($point, $size)
                ->resize($resize)
                ->save($file_name, $options); 
    }

    private function _verify_image($image_src) {

        //this little function grabs the extension
        $extension = $this->_extract_image_extension($image_src);

        switch($extension) {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($image_src);
                break;
            case '.gif':
                $img_ = @imagecreatefromgif($image_src);
                break;
            case '.png':
                $img = @imagecreatefrompng($image_src);
                break;
            default:
                $img = false;
            break;
        }
        
        if($img) {
            $file_name = "/var/www/s36-upload-images/uploaded_tmp/".$this->date.".jpg";      
            file_put_contents($file_name, file_get_contents($image_src));
            return $file_name;
        } 

    }

    private function _extract_image_extension($image_src) {
        return strtolower(strrchr($image_src, '.')); 
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
                $filedir = "/var/www/s36-upload-images/uploaded_tmp/".$filename;
                $maxwidth = 350;
                $maxheight = 230;
                $move = move_uploaded_file($_FILES[$file]['tmp_name'], $filedir);
                if($move){    
                     //start image resizing..
                     //Change this...
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
          , "dir" => "uploaded_tmp/".$filename
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
