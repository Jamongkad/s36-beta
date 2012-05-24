<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>

        <?=HTML::script('js/head.min.js')?>
        <?=HTML::style('css/widget_master/flags_widget.css')?>
        <?=HTML::style('css/widget_master/grids.css')?> 
        <?=HTML::style('css/widget_master/hosted-single.css');?>

        <meta property="og:title" content="<?=$feedback->text?>"/> 
        <meta property="og:description" content="<?=$feedback->text?>"/> 
        <meta property="og:type" content="article"/> 
        <?if($feedback->avatar):?>
            <meta property="og:image" content='<?=URL::to('uploaded_cropped/150x150/'.$feedback->avatar)?>'/> 
        <?else:?>
            <meta property="og:image" content='<?=URL::to('img/36logo2.png')?>'/> 
        <?endif?>

        <meta property="og:url" content="<?=URL::to('hosted/single/'.$feedback->id)?>"/> 
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
            <span><?=HTML::link('/', 'View all feedback')?></span>
            
            <?if($feedback->sitedomain):?>
                <span class="right padfix">
                    <a href="http://<?=$feedback->sitedomain?>" target="_blank"><?="Visit $company_name's Website"?></a>
                </span>
            <?endif?>
        </div>
    </div>
</div>
<div id="bodyWrapper">
	<div id="bodyContent">
    	<div id="feedbackBox">
        	<div class="block">
            	<div class="theAvatar">
                    <?if($feedback->avatar):?>
                        <?=HTML::image('uploaded_cropped/150x150/'.$feedback->avatar)?>
                    <?else:?>
                        <?=HTML::image('img/blank-avatar.jpg')?>
                    <?endif?>

                </div>
                <div class="theAuthor">
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
                            $date = $feedback->date;
                            $unix = strtotime($date);
                            echo date('F j, Y', $unix)." ".date('h:i:m a', $unix);?>
                        </span>
                    	<span class="flag flag-<?=strtolower($feedback->countrycode)?> flag-fix"></span>
                    </div>
                </div>
            </div>
            <div class="block" style="height:20px"></div>
            <div class="block">
            	<div class="theText">
                	<p>"<?=$feedback->text?>"</p>
                </div>
            </div>
            <div class="block" style="height:20px"></div>
        </div>
 
        <div class="block" style="height:40px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
</div>

<?=HTML::script('js/modernizr.js')?> 
</body>
</html>
