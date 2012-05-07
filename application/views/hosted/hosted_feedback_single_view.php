<meta property="og:title" content="<?=$feedback->text?>"/> 
<meta property="og:description" content="<?=$feedback->text?>"/> 
<meta property="og:type" content="article"/> 
<meta property="og:image" content='<?=HTML::image('uploaded_cropped/150x150/'.$feedback->avatar)?>'/> 
<meta property="og:url" content="<?=URL::to('hosted/single/'.$feedback->id)?>"/> 
<meta property="og:site_name" content="36Stories: Feedback made easy."/> 
<meta property="fb:app_id" content="<?=$fb_id?>"/>

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
        <!--
        <div id="companyDetails" class="block">
        	<div class="companyLogo">
                <?if($feedback->company_logo):?>
                    <?=HTML::image('img/company_logos/'.$feedback->company_logo)?>
                <?else:?>
                    <?=HTML::image('img/company-logo-filler.jpg')?>
                <?endif?>
            </div>
            <div class="companyDetails">
            	<h2>Company Profile</h2>
                <p>
                    <?if($feedback->company_description):?>
                        <?=$feedback->company_description?> 
                    <?else:?>
                        Acme in specializes in creating widgets for everyday use. Thousands of 
                        customers worldwideuse Acme products and get better each and everyday. 
                        Visit Acme's website today for more information. 
                    <?endif?>
                </p>

				<br />
                <div class="companyLinks">
                    <?if($feedback->company_social_links):?> 
                        <ul>
                            <li><a href="#" class="website">Visit Our Website</a></li>
                            <li><a href="#" class="facebook">Join us on Facebook</a></li>
                            <li><a href="#" class="twitter">Follow us on Twitter</a></li>
                        </ul>
                    <?else:?>
                        <ul>
                            <li><a href="#" class="website">Visit Our Website</a></li>
                            <li><a href="#" class="facebook">Join us on Facebook</a></li>
                            <li><a href="#" class="twitter">Follow us on Twitter</a></li>
                        </ul>
                    <?endif?>
                </div>
            </div>
        </div>
        <div class="block" style="height:20px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
    -->
</div>
