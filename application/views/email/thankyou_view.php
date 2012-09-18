<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <div id="login-box" style="text-align:center">
            <?if(is_object($activity_check)):?>
                <h2>This feedback has already been published by <?=ucfirst($activity_check->username)?>.</h2>
            <?else:?>
                <h2>Sweet! You have just published <?=$contact_name?>'s feedback!</h2>
            <?endif?>
            </div>
            <br/>
            <div style="text-align:center; font-size:1.3em">
                To view more feedback, <a href="https://<?=strtolower($company->name).".".$hostname?>.com/login">sign in now!</a>
            </div>
        </div>
    </div>
</div>
