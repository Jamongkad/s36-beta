<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <div id="login-box" style="text-align:center">
                <h2>Feedback Published!</h2>
            </div>
            <br/>
            <div style="text-align:center; font-size:1.3em">
                <?=HTML::link('/'.strtolower($company_name->name).'/login', 'click to login')?>
            </div>
        </div>
    </div>
</div>
