<?=HTML::style('css/widget_master/hosted-form.css');?>

<?if($hosted):?>
    <?=HTML::style('themes/hosted/form/form-'.$hosted->theme_type.'.css');?>
<?endif?>

<?=$company_header?>
<?=$widget?>

<div class="block" style="height:40px;"></div>
        <div id="companyDetails" class="block">
        	<div class="companyLogo">
                <?if($company->logo):?>
                    <?=HTML::image('company_logos/'.$company->logo)?>
                <?else:?>
                    <?=HTML::image('img/company-logo-filler.jpg')?>
                <?endif?>
            </div>
            <div class="companyDetails">
            	<h2>Company Profile</h2>
                <p>
                    <?if($company->description):?>
                        <?=$company->description?> 
                    <?else:?>
                        Acme in specializes in creating widgets for everyday use. Thousands of 
                        customers worldwideuse Acme products and get better each and everyday. 
                        Visit Acme's website today for more information. 
                    <?endif?>
                </p>

				<br />
                <?if($company->website_link || $company->fb_link || $company->twit_link):?>
                    <div class="companyLinks">
                        <ul>
                            <?if($company->website_link):?>
                                <li><a href="<?=$company->website_link?>" class="website">Visit Our Website</a></li>
                            <?endif?>

                            <?if($company->fb_link):?>
                                <li><a href="<?=$company->fb_link?>" class="facebook">Join us on Facebook</a></li>
                            <?endif?>

                            <?if($company->twit_link):?>
                                <li><a href="<?=$company->twit_link?>" class="twitter">Follow us on Twitter</a></li>
                            <?endif?>
                        </ul>
                    </div>
                <?endif?>
            </div>
        </div>
        <div class="block" style="height:20px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
</div>
