<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <h2 style="text-align: center; padding-bottom: 30px">Congrats your account has been successfully created!</h2>
            <div id="login-box" style="text-align:center">
                <?=Form::open('/login')?>
                    <table width="100%" align="center">
                    <tr><td>Username/email:</td><td><?=Form::text('username')?></td></tr>
                    <tr><td>Password:</td><td><?=Form::password('password')?></td></tr>
                    <tr><td><?=Form::submit('login', array('class' => 'login-btn'))?></td></tr>
                    </table>
                <?=Form::close()?>
            </div>
        </div>
    </div>
</div>
