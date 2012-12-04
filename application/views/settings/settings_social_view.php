<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>SOCIAL CONNECTION SETTINGS</h3>
</div>

<div class="block">    
    <p class="small"><strong>Connect to your social accounts.</strong></p>

    <div class="grids">
        <div class="g4of5">
            <!--
            <div class="grids">
                <div class="g2of5"><strong class="facebook-icon">Connect to Facebook: </strong></div>
                <div class="g3of5"><?=$company->facebook_username?></div>
            </div>
            <br />
            -->
            <div class="grids">
                <?if($company->twitter_username):?>
                    <strong class="twitter-icon">@<?=$company->twitter_username?> <a href="">Disconnect?</a></strong> 
                <?else:?>
                    <strong class="twitter-icon"><a href="">Connect to Twitter</a></strong>
                <?endif?>
            </div>
            <!--
            <br />
            <div class="grids">
                <div class="g2of5"><strong class="website-icon">Website: </strong></div>
                <div class="g3of5"><?=$company->website_link?></div>
            </div> 
            -->
        </div>
    </div>
</div>
