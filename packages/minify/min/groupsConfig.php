<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
     'Global.js'	=> array(
     			 '//js/jquery-ui-1.8.24.custom.min.js'
     			,'//js/helpers.js'
     			,'//js/jquery.iframe-transport.js'
     			,'//js/jquery.ui.widget.js'
     			,'//js/jquery.fileupload.js'
     			,'//js/jquery.raty.min.js'
     ),
     'FullpageCommon.js' => array(
      			 '//fullpage/common/js/S36FullpageCommon.js'
     			,'//fullpage/common/js/masonry.js'
     			,'//fullpage/common/js/modernizr.js'
     			,'//fullpage/common/js/feedbackactions.js'
     			,'//fullpage/common/js/s36_client_script.js'
     ),
     'FullpageCommon.css' => array(
                     '//fullpage/common/css/S36FullpageCommon.css'
                    ,'//fullpage/common/css/master.css'
                    ,'//fullpage/common/css/flags.css'
                    ,'//fullpage/common/css/grids.css'
                    ,'//fullpage/common/css/s36_client_style.css'
     ),
     'FullpageAdmin.js' => array(
				'//fullpage/admin/js/jcycle.js'
				,'//fullpage/admin/js/jquery.jcarousel.min.js'
				,'//fullpage/admin/js/minicolors.js'
				,'//fullpage/admin/js/colors.min.js'
				,'//fullpage/admin/js/jquery.mousewheel.min.js'
				,'//fullpage/admin/js/jquery.scroll.js'
				,'//fullpage/admin/js/S36FullpageAdmin.js'
     ),
     'FullpageAdmin.css' => array(
                     '//fullpage/admin/css/S36FullpageAdmin.css'
                    ,'//fullpage/admin/css/jcarousel.skin.css'
                    ,'//fullpage/admin/css/minicolors.css'
     ),
);







