<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <div id="login-box" style="text-align:center">
                <h2>Sweet! You have just published <?=$contact_name?>'s feedback onto your website!</h2>
            </div>
            <br/>
            <div style="text-align:center; font-size:1.3em">
                To view more feedback, <?=HTML::link('/'.strtolower($company_name->name).'/login', 'sign in now!')?>
            </div>
        </div>
    </div>
</div>
