<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <div id="login-box" style="text-align:center">
            <?if(is_object($activity_check)):?>
                <?if($status == "publish"):?>
                    <h2>This feedback has already been published by <?=ucfirst($activity_check->username)?>.</h2>
                <?else:?>
                    <h2>This feedback has been previously unpublished by <?=ucfirst($activity_check->username)?>.</h2>
                <?endif?>
            <?else:?>
                <?if($status == "publish"):?>
                    <h2>Sweet! You have just published <?=$contact_name?>'s feedback onto your website!</h2>
                <?else:?>
                    <h2>You have just unpublished <?=$contact_name?>'s feedback. </h2>

                    <span style="font-size:12px;color:#333;">
                        Based on your auto-posting settings, we have automatically published this feedback. (<a href="<?=$settings_url?>">Change</a>)
                    </span>
                <?endif?>
            <?endif?>
            </div>
            <br/>
            <div style="text-align:center; font-size:1.3em">
                To view more feedback, <a href="http://<?=strtolower($company->name).".".$hostname?>.com/login">sign in now!</a>
            </div>
        </div>
    </div>
</div>
