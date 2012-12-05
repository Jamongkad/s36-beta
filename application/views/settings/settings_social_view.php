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
                <div class="g3of5"></div>
            </div>
            <br />
            -->
            <div class="grids">
                <?if($twitter_account):?>
                    <strong class="twitter-icon" style="font-size:17px">
                        connected to @<? $t = (object) Helpers::unwrap($twitter_account['socialAccountValue']);
                                        echo $t->accountName
                                     ?><a href="/settings/disconnect/twitter">disconnect?</a>
                    </strong>
                <?else:?>
                    <strong class="twitter-icon" style="font-size:17px"><a href="/settings/connect/twitter">Connect to Twitter</a></strong>
                <?endif?>
            </div>
            <!--
            <br />
            <div class="grids">
                <div class="g2of5"><strong class="website-icon">Website: </strong></div>
                <div class="g3of5"></div>
            </div> 
            -->
        </div>
        <div style="height:300px"></div>
    </div>
</div>
