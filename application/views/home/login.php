<h3>Login Page</h3>
<div class="grids">
    <div class="g1of2">
        <table>
            <?=Form::open('/login', 'POST')?>
                <tr><td>Username/email:</td><td><?=Form::text('username')?></td></tr>
                <tr><td>Password:</td><td><?=Form::password('password')?></td></tr>
                <tr><td><?=Form::submit('login')?></td></tr>
            <?=Form::close()?>
        </table>
    </div>
    <div class="g1of2">
        Mathew
    </div>
</div>
