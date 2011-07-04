<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>36Stories - Get amazing feedback for your brand and business.</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <?=HTML::style('css/grid.css')?>
    <?=HTML::style('css/gridless.css')?>

    <script type="text/javascript">
     function xss_ajax(url) {
            var script_id = null;
            var script = document.createElement('script');
            script.setAttribute('type', 'text/javascript');
            script.setAttribute('src', url);
            script.setAttribute('id', 'script_id');

            script_id = document.getElementById('script_id');
            if(script_id){
                document.getElementsByTagName('head')[0].removeChild(script_id);
            }
            // Insert <script> into DOM
            document.getElementsByTagName('head')[0].appendChild(script);
        }

        function callback(data) {
            /*
            var txt = '';
            for(var key in data) {
                txt += key + " = " + data[key];
                txt += "\n";
            }
            console.log(txt);
            */
            console.log(data);
        }

        jQuery(function($) {
            $("button").click(function(e) {
                xss_ajax("http://www.gearfish.com/s36-beta/public/index.php/test_json_request?name=Ryan&lastname=Chua");
            });
        });
    </script>
</head> 

<body>
    <button>Get Data</button>
</body>

<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";  
  feedback_widget_options.company = "ygiraffe";
  feedback_widget_options.placement = "left";
  feedback_widget_options.color = "#222";
  feedback_widget_options.style = "idea";
  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script> 
</html>
