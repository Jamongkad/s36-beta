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
        <script type="text/javascript">
            var widgetId = 'i1ghz';
            var host = (("https:" == document.location.protocol) ? "https://secure." : "http://");
            document.write(unescape("%3Cscript src='" + host + "feedback.36storiesapp.com/widget/js_output?widgetId="+widgetId+"' type='text/javascript'%3E%3C/script%3E"));
        </script>                     
    <?endif?>

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
