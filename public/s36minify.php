<?php
define('ROOT_DIR', dirname(__FILE__));
$minified_path = ROOT_DIR.'/minified/';
if(!is_dir($minified_path)) {
    mkdir($minified_path,0777,true);
}


$groups = array(
     'Global.js'=> array(
        'type'  =>'js',
        'files' => array(
             '/js/jquery-ui-1.8.24.custom.min.js'
            ,'/js/helpers.js'
            ,'/js/jquery.ui.widget.js'
            ,'/js/jquery.iframe-transport.js'
            ,'/js/jquery.fileupload.js'
            ,'/js/jquery.raty.min.js'
            ,'/js/date.js'
            ,'/js/jquery-autogrow-textarea.js'
            ,'/js/link.preview.js'
            
        )
     ),
     'Global.css' => array(
        'type' =>'css',
        'files'=>array(
             '/css/zebra_pagination.css'
        )
     ),
     'FullpageCommon.js' => array(
        'type' =>'js',
        'files'=>array(
            '/fullpage/common/js/masonry.js'
            ,'/fullpage/common/js/modernizr.js'
            ,'/fullpage/common/js/feedbackactions.js'
            ,'/fullpage/common/js/s36_client_script.js'
            ,'/fullpage/common/js/S36FullpageCommon.js'
            ,'/fullpage/common/js/fullpage_form_script.js'
            
        )
     ),
     'FullpageCommon.css' => array(
        'type' =>'css',
        'files'=>array(
             '/fullpage/common/css/S36FullpageCommon.css'
            ,'/fullpage/common/css/flags.css'
            ,'/fullpage/common/css/grids.css'
            ,'/fullpage/common/css/s36_client_style.css'
            ,'/fullpage/common/css/override.css'
            ,'/fullpage/common/css/fullpage_form.css'
        )
     ),
     'FullpageAdmin.js' => array(
        'type' =>'js',
        'files'=>array(
            //'/fullpage/admin/js/jcycle.js'
            //'/fullpage/admin/js/S36FullpageAdmin.js'  // no longer needed.
            '/fullpage/admin/js/jquery.jcarousel.min.js'
            ,'/fullpage/admin/js/minicolors.js'
            ,'/fullpage/admin/js/colors.min.js'
            ,'/fullpage/admin/js/jquery.mousewheel.min.js'
            ,'/fullpage/admin/js/jquery.scroll.js'
            ,'/admin_dashboard/dashboard.js'
        )
     ),
     /* Weird Angular JS conflicts arise when minified
     'QuickInbox.js' => array(
        'type' =>'js',
        'files'=>array(
            '/js/angular.compilehtml.js' 
           ,'/fullpage/admin/js/quickinbox/controllers/S36QuickInbox.js' 
           ,'/fullpage/admin/js/quickinbox/directives/S36QuickInboxDirectives.js'
           ,'/fullpage/admin/js/quickinbox/services/S36QuickInboxServices.js' 
        )
     ),
     */
     'FullpageAdmin.css' => array(
        'type' =>'css',
        'files'=>array(
             '/fullpage/admin/css/S36FullpageAdmin.css'
            ,'/fullpage/admin/css/jcarousel.skin.css'
            ,'/fullpage/admin/css/minicolors.css'
            ,'/fullpage/admin/css/dashboard.css'
        )
     ),
);


foreach ($groups as $group => $assets) {
	$files = "";
	$type	= $groups[$group]['type'];
	foreach ($groups[$group]['files'] as $file) {
		$files .= ROOT_DIR.$file." ";
	}
	exec("yuicompress -o {$minified_path}{$group} -f {$files}");
}
?>
