<?if(S36Auth::check()):?> 
    <?=View::make('partials/admin_sorter_bar')?>
        </div> 
        <div class="c"></div>
    </div>
    <div id="footer">
        <h4>Feedback & Customer Satisfaction Simplified.</h4>
        <h4>36Stories © 2011. </h4>
        <p>Keep in touch by following us on <a href="#">Facebook</a>, <a href="#">Twitter</a>, subscribing to our <a href="#">blog's feed</a> and joining our <a href="#">email newsletter</a>.</p>
    </div>
    <?if(Config::get('application.env_name') == 'prod'):?>
        <!--Live Leader Chat app-->
        <script type="text/javascript" src="http://www.liveleader.com/a/Hello?cid=69d46946-034a-498a-911b-e4508d14a78c;v=2"></script>
        <a class="ChatPoweredLink" href="http://www.liveleader.com">Live chat, live help, live support</a>
        <!--Live Leader Chat app-->
    <?else?>

<?endif?>

</div>

<div id="notification">
	<div id="notification-design">
    	<div id="notification-message" style="display:none">
        	Loading... Please Wait...
        </div>
    </div>
</div>
</body>
</html>
