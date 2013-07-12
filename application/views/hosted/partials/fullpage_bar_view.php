<div id="theBar">
    <div id="theBarInner" class="clear">
        <div id="barLeftContent">
            <div class="barLinks clear">
                <div id="barImageLogo"><a href="/"><img src="/fullpage/common/img/36stories-logo.png" /></a></div>
                <?php if( is_null(\S36Auth::user()) ): ?>
                    <ul class="left-links">                 
                        <li><a href="http://beta.36stories.com/">Create Your Own Feedback Page!</a></li>
                    </ul>
                <?php endif ?>
            </div>
        </div>
        <div id="barRightContent">
            <div class="barLinks">
                <ul>
                    <?php if( ! is_null(\S36Auth::user()) ): ?>
                        <li><a href="javascript:;">Signed in as <span><?=\S36Auth::user()->username?></a></li>
                        <? //<li><a href="#" id="admin_panel" initquick>Admin Panel</a></li> ?>
                        <li><a href="/dashboard">My Dashboard</a></li>
                        <li><a href="/admin">My Account</a>
                            <ul>
                                <li><a href="http://36stories.freshdesk.com/">Help</a></li>
                                <li> 
                                     <a href="/logout?forward_to=me">Log Out</a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li> 
                            <a href="/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div id="theBarTab" class="dropped"></div>
    </div>
</div>
<?= HTML::style('/fullpage/common/css/FullpageBar.css'); ?>
<script type="text/javascript">
    <? // if admin is logged in, show the bar by default. ?>
    <?php if( is_null(\S36Auth::user()) ): ?>
        $('#theBarTab').removeClass('dropped');
        $('#theBar').css('top', (-parseInt($('#theBar').css('top')) + (-40)) );
    <?php endif; ?>
    
    $('#theBarTab').click(function(){
        $(this).toggleClass('dropped');
        $('#theBar').animate( {'top': (-parseInt($('#theBar').css('top')) + (-40))}, 'fast' );
    });
</script>
