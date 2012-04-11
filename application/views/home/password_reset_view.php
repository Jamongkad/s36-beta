<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <h2 style="text-align: center; padding-bottom: 30px">Choose your new password</h2>
            <div id="login-box" style="text-align:center">
                <?=Form::open('/resend_password')?>
                    <?=Form::hidden('company', $subdomain)?>
                    <?=Form::hidden('email', $email)?>
                    <table width="100%" align="center">
                        <tr><td>New password</td>
                            <td>
                               <?=Form::password('password')?>
                            </td>
                        </tr>
                        <tr><td>Verify password</td>
                            <td>
                               <?=Form::password('password_confirm')?>
                            </td>
                        </tr>
                        <tr>
                            <td><?=Form::submit('submit')?></td>
                        </tr>
                    </table>
                <?=Form::close()?>
            </div>
        </div>
    </div>
</div>
