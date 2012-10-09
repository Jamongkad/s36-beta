<div id="mainbodywrapper">
    <div id="mainbodycontent">
        <div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
        <div id="login">
            <h2 style="text-align: center; padding-bottom: 30px">Forgot your password?</h2>
            <div id="login-box" style="text-align:center">
                <?=Form::open('resend_password')?>
                    <?=Form::hidden('company', $company)?>
                    <table width="100%" align="center">
                        <tr><td>Enter your email:</td>
                            <td>
                               <?=Form::text('email')?>
                               <?=($errors) ? "<p style='color:#7093b2; padding-left:10px'>".$errors->first('email')."</p>" : null?>
                               <?=($warning) ? "<p style='color:#7093b2; padding-left:10px'>".$warning."</p>" : null?>
                               <?=Form::submit('submit')?>
                            </td>
                        </tr>
                    </table>
                <?=Form::close()?>
            </div>
        </div>
    </div>
</div>
