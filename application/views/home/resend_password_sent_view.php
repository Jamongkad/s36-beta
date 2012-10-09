<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <h1 style="text-align: center; padding-bottom: 30px">
                We've sent password reset instructions to your email address.
            </h1>
            <p style="text-align: center;">
            If you don't receive instructions within a minute or two, check your email's spam and junk filters, or 
            <?=HTML::link('/resend_password', 'try resending your request.')?>
            </p>
        </div>
    </div>
</div>
