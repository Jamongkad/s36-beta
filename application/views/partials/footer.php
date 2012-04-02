
<?=HTML::script('js/jquery.switcharoo.js')?>
<?=HTML::script('js/jquery.fancytips.js')?>
<?=HTML::script('js/jquery.cycle.all.min.js')?>
<?=HTML::script('js/jquery.form.js')?>
<?=HTML::script('js/jquery.tmpl.js')?>
<?=HTML::script('js/jquery.jcrop.js')?>
<?=HTML::script('js/jquery.ajaxfileupload.js')?>
<?=HTML::script('js/jquery.zclip.js')?>
<?=HTML::script('js/jquery.flot.js')?>
<?=HTML::script('js/jquery.flot.pie.js')?>
<?=HTML::script('js/jquery.scrollTo-1.4.2-min.js')?>
<?=HTML::script('js/jquery.tinymce.js')?>
<?=HTML::script('js/jquery.pjax.js')?>
<?=HTML::script('js/jquery.timeago.js')?>
<?=View::make('partials/admin_sorter_bar')?>
<?
if(S36Auth::check()):
?> 
        </div> 
        <div class="c"></div>
    </div>
    <div id="footer">
        <h4>Feedback & Customer Satisfaction Simplified.</h4>
        <h4>36Stories © 2011. </h4>
        <p>Keep in touch by following us on <a href="#">Facebook</a>, <a href="#">Twitter</a>, subscribing to our <a href="#">blog's feed</a> and joining our <a href="#">email newsletter</a>.</p>
    </div>
<?endif?>

</div>

<div id="notification">
	<div id="notification-design">
    	<div id="notification-message">
        	Loading... Please Wait... you bits.
        </div>
    </div>
</div>
</body>
</html>
