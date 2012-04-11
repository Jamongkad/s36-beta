<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <h1 style="text-align: center; padding-bottom: 30px">
                Password has been successfully updated.
            </h1>
            <p style="text-align: center;">
            Please <?=HTML::link('/login', 'try logging in again.', array('class' => 'woops-a'))?>
            </p>
        </div>
    </div>
</div>
