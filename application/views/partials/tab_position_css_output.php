<?
    session_cache_limiter("private_no_expire"); 
	header("Content-type: text/css");
	$class = '@charset "utf-8";
			/* CSS Document */
			.tab-cornertab{
				position:fixed;
				width:76px;
				height:76px;
				background-position:no-repeat;
				cursor:pointer;
			}
			.tab-sidetab{
				position:fixed;
				width:31px;
				height:92px;
				background-position:no-repeat;
				cursor:pointer;
			}';
	
	foreach($positions as $pos => $theme){
		if($pos == 'bl'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
				$class .= 'left:0px;';
				$class .= 'bottom:0px}';
			}
		}elseif($pos == 'br'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
				$class .= 'right:0px;';
				$class .= 'bottom:0px}';
			}
		}elseif($pos == 'tl'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
				$class .= 'left:0px;';
				$class .= 'top:0px}';
			}
		}elseif($pos == 'tr'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
				$class .= 'right:0px;';
				$class .= 'top:0px}';
			}			
		}elseif($pos == 'l'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
				$class .= 'left:0px;';
				$class .= 'top:20%}';	
			}
		}elseif($pos == 'r'){
			foreach($theme as $key => $val){
				$class .= '.tab-'.$pos.'-'.$key.'{';
				$class .= 'background:url(/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png);';
				$class .= 'right:0px;';
				$class .= 'top:20%}';
			}
		}
	}
	echo $class;
?>
