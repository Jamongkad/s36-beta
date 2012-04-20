<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($company->name);?>

        	<strong><?=$company_name?></strong>  
            <span><?=HTML::link('/', 'View all feedback')?></span>
            
            <?if($company->domain):?>
                <span class="right padfix">
                    <a href="http://<?=$company->domain?>" target="_blank"><?="Visit $company_name's Website"?></a>
                </span>
            <?endif?>
        </div>
    </div>
</div>
<?=$widget?>


<div class="block" style="height:40px;"></div>
        <div id="companyDetails" class="block">
        	<div class="companyLogo">
                <?=HTML::image('img/company-logo-filler.jpg')?>
            </div>
            <div class="companyDetails">
            	<h2>Company Profile</h2>
                <p>Acme in specializes in creating widgets for everyday use. Thousands of 
customers worldwideuse Acme products and get better each and everyday. 
Visit Acme's website today for more information. </p>
				<br />
                <div class="companyLinks">
                <!--decompress social_links object and iterate here
                	<ul>
                    	<li><a href="#" class="website">Visit Our Website</a></li>
                        <li><a href="#" class="facebook">Join us on Facebook</a></li>
                        <li><a href="#" class="twitter">Follow us on Twitter</a></li>
                    </ul>
                </div>
                -->
            </div>
        </div>
        <div class="block" style="height:20px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
</div>
