<?
    //CSS preprocessor
    session_cache_limiter("private_no_expire"); 
	header("Content-type: text/css; charset=UTF-8", true);
	$class = '@charset "utf-8";
			/* CSS Document */
			.tab-cornertab{
				position:fixed;
				width:76px;
				height:76px;
				background-position:no-repeat;
				cursor:pointer;
                z-index: 100000;
			}
			.tab-sidetab{
				position:fixed;
				width:31px;
				height:92px;
				background-position:no-repeat;
				cursor:pointer;
                z-index: 100000;
			}                       
            .tab-small-sidetab{ 
                position:fixed; 
                width:31px; 
                height:28px; 
                background-position:no-repeat; 
                cursor:pointer; 
                z-index: 100000;
            }
            ';
    /*	
	foreach($positions as $pos => $theme){
		if($pos == 'bl'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
                $class .= 'background-color:transparent;';
                $class .= 'border:none;';
				$class .= 'left:0px;';
				$class .= 'bottom:0px}';
			}
		}elseif($pos == 'br'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
                $class .= 'background-color:transparent;';
                $class .= 'border:none;';
				$class .= 'right:0px;';
				$class .= 'bottom:0px}';
			}
		}elseif($pos == 'tl'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
                $class .= 'background-color:transparent;';
                $class .= 'border:none;';
				$class .= 'left:0px;';
				$class .= 'top:0px}';
			}
		}elseif($pos == 'tr'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
                $class .= 'background-color:transparent;';
                $class .= 'border:none;';
				$class .= 'right:0px;';
				$class .= 'top:0px}';
			}			
		}elseif($pos == 'l'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
                $class .= 'background-color:transparent;';
                $class .= 'border:none;';
				$class .= 'left:0px;';
				$class .= 'top:20%}';	
			}
		}elseif($pos == 'r'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
                $class .= 'background-color:transparent;';
                $class .= 'border:none;';
				$class .= 'right:0px;';
				$class .= 'top:20%}';
			}
		}
	}
    */
	echo $class;
