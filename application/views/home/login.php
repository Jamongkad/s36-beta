<div id="mainbodywrapper">
	<div id="mainbodycontent">
    	<div id="login-logo">
            <?=HTML::image('img/36logo2.png')?>
        </div>
		<div id="login">
        	<div id="login-box">
                <?=Form::open('login', 'POST')?>
                    <table width="100%" align="center">
                        <input type="hidden" value="<?=Input::get('forward_to')?>" name="forward_to" />
                        <tr><td>Username/email:</td><td><?=Form::text('username')?></td></tr>
                        <tr><td>Password:</td>
                            <td><?=Form::password('password')?><br/>
                                <?=HTML::link('resend_password', 'forgot password?')?>
                            </td>
                        </tr>
                        <tr><td><?=Form::submit('login', array('class' => 'login-btn'))?></td></tr>
                    </table>
                <?=Form::close()?>
            </div>
        </div>
    </div>
</div>
