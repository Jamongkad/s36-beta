
<?//=HTML::script('js/jquery.cycle.all.min.js')?>
<?//=HTML::script('js/jquery.mousewheel.js')?>
<?//=HTML::script('js/jquery.scroll.js')?> 

<script text="text/javascript">
<?

    $js_scripts = Array(
         '/js/jquery.jcrop.js' 
       , '/js/jquery.ajaxfileupload.js'
       , '/js/s36FormModule.js'
       , '/js/cycle.function.js'
       , '/js/widget/form.js'
       , '/js/jquery.cycle.all.min.js'
       , '/js/jquery.mousewheel.js'
       , '/js/jquery.scroll.js'
    );

    $string = '"' . implode('","', $js_scripts) . '"';

?>

head.js(<?=$string?>);
</script>
</body>
</html>
