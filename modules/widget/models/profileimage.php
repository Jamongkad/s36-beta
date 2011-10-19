<?php namespace Widget;

class ProfileImage {

    private $dir150, $dir48, $date;
    protected $targ_w, $targ_h, $jpeg_quality;

    public function __construct($input_params) { 

       $this->input_params = $input_params;

       $this->date = date("mdyhis");
       $this->dir150 = "/var/www/s36-upload-images/uploaded_cropped/150x150/".$this->date."-cropped.jpg";
       $this->dir48 = "/var/www/s36-upload-images/uploaded_cropped/48x48/".$this->date."-cropped.jpg";

       $this->targ_w_large = 150;
       $this->targ_h_large = 150;

       $this->targ_w_small = 48;
       $this->targ_h_small = 48;

       $this->jpeg_quality = 100;
                    
    }

    public function crop() {

        $fb_login = property_exists($this->input_params, 'fb_login') ? $this->input_params->fb_login : null; 
        $ln_login = property_exists($this->input_params, 'ln_login') ? $this->input_params->ln_login : null;
        $x  = $this->input_params->x_coords; 
        $y  = $this->input_params->y_coords;
        $wd = $this->input_params->wd; 
        $ht = $this->input_params->ht;
        $img_src = $this->input_params->src;
        $ophoto  = property_exists($this->input_params, 'oldphoto') ? $this->input_params->oldphoto : null;

        $src = null;
        if($fb_login == 1 || $fb_login == 2) {
            $src = fb_photo_check($fb_login, $img_src);     
        }

        if($ln_login == 1) {
            $src = $img_src;
        }

        if($ophoto != 0){
            @unlink("/var/www/s36-upload-images/uploaded_cropped/150x150/".$ophoto);
            @unlink("/var/www/s36-upload-images/uploaded_cropped/48x48/".$ophoto);	
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

    public function upload() {}
}

//helper functions will move to seperate file later on
function fb_photo_check($fb_login, $photo_src) {    
    if($fb_login == 1) return $photo_src;
    if($fb_login == 2) return "/var/www/s36-beta/public/".$photo_src;
    
    return "/var/www/s36-beta/public/".$photo_src;
}
