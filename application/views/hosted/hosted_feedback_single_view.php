<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://platform.twitter.com/widgets.js" type="text/javascript"></script>

        <?=HTML::script('js/head.min.js')?>
        <?=HTML::style('css/widget_master/flags_widget.css')?>
        <?=HTML::style('css/widget_master/grids.css')?> 
        <?=HTML::style('css/widget_master/hosted-single.css');?>

        <?if($hosted):?>
            <?=HTML::style('themes/hosted/single/hosted-single-'.$hosted->theme_type.'.css');?>
        <?endif?>

        <meta property="og:title" content="<?=strip_tags($feedback->text)?>"/> 
        <meta property="og:description" content="<?=strip_tags($feedback->text)?>"/> 
        <meta property="og:type" content="article"/> 
        <?if($feedback->avatar):?>
            <meta property="og:image" content='<?=URL::to('uploaded_cropped/150x150/'.$feedback->avatar)?>'/> 
        <?else:?>
            <meta property="og:image" content='<?=URL::to('img/36logo2.png')?>'/> 
        <?endif?>

        <meta property="og:url" content="<?=URL::to('single/'.$feedback->id)?>"/> 
        <meta property="og:site_name" content="36Stories: Feedback made easy."/> 
        <meta property="fb:app_id" content="<?=$fb_id?>"/>

        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>
<body>
<div id="fb-root"></div>

<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($feedback->company_name);?>
        	<strong><?=$company_name?></strong>  
            <span><a href="https://<?=strtolower($feedback->company_name).".".$hostname?>.com">View all feedback</a></span> 
            <span><a class="green-cross" href="<?=$deploy_env.'/'.strtolower($feedback->company_name).'/submit'?>">Send in feedback</a></span>
            <?if($feedback->sitedomain):?>
                <span class="right padfix">
                    <a href="https://<?=$feedback->sitedomain?>" target="_blank"><?="Visit $company_name's Website"?></a>
                </span>
            <?endif?>
        </div>
    </div>
</div>

<div id="bodyWrapper">
	<div id="bodyContent">
    	<div id="feedbackBox">
        	<div class="block">
                <?if($feedback->displayimg):?>
                    <?if($feedback->avatar):?>
            	        <div class="theAvatar">
                            <?=HTML::image('uploaded_cropped/150x150/'.$feedback->avatar)?>
                        </div>
                    <?endif?>
                <?endif?>
                <div class="theAuthor" <?=(($feedback->displayimg == false) or ($feedback->avatar == false)) ? " style='padding-left: 0px;padding-top: 0px'" : null?>>
                	<div class="theAuthorName">
                    	<span><?=$feedback->firstname?> <?=$feedback->lastname?></span>
                    </div>
                    <div class="theAuthorCompany">
                        <?if($feedback->companyname):?>
                    	    <span><?=$feedback->position?>, <?=$feedback->companyname?></span>
                        <?else:?>
                    	    <span></span>
                        <?endif?>
                    </div>
                    <div class="theDate">
                        <span>
                            <?
                            $unix = strtotime($feedback->date);
                            echo date('F j, Y', $unix)." ".date('h:i:m a', $unix);?>
                        </span>
                    	<span class="flag flag-<?=strtolower($feedback->countrycode)?> flag-fix"></span>
                    </div>
                </div>
            </div>
            <div class="block">
            	<div class="theText">
                	<?=$feedback->text?>
                </div>
            </div>
            <div class="block" style="height:20px"></div>

            <div class="feedbackSocial"> 

                <?php
                    $maxchars = 74;							
                    $text = strip_tags($feedback->text);
                    if(strlen(trim($text)) <= $maxchars){
                        $text = $text;
                    }else{
                        $text = substr($text, 0, $maxchars)."...";
                    }							
                ?>
                <div style="float:left"> 
                    <a href="<?=URL::to('single/'.$feedback->id)?>" 
                       data-url="<?=URL::to('single/'.$feedback->id)?>" 
                       data-text="<?=$text?>"
                       class="twitter-share-button">Tweet</a>
                </div>
             
                <div style="float:left "> 
                    <fb:like href="<?=URL::to('single/'.$feedback->id)?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like> 
                </div>

            </div>
     
        </div>
 
        <div class="block" style="height:40px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
</div>

<?=HTML::script('js/modernizr.js')?> 
</body>
</html>
