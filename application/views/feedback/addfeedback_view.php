<script type="text/javascript">
$(document).ready(function(){
		start_slider();
		$('.error-message').hide();
		$('#add_feedback').click(function(){
			add_feedback();
		});
	});

function start_slider(){
	$('#rate_e').click(function(){ slide_track_to('-3px'  ,'5'); });
	$('#rate_g').click(function(){ slide_track_to('+119px','4'); });
	$('#rate_a').click(function(){ slide_track_to('+244px','3'); });
	$('#rate_p').click(function(){ slide_track_to('+369px','2'); });
	$('#rate_b').click(function(){ slide_track_to('+492px','1'); });
}
function slide_track_to(y,rating){
	$('#track_ball').animate({'left':y});
	$('#rating').val(rating);
}

function add_feedback(){
	var feedback = $('#feedback').val();
	var permission = $('[name="permission"]:checked').val();
	var firstname = $('#firstname').val();
	var lastname = $('#lastname').val();
	var email = $('#email').val();
	var country = $('#country').val();
	
	if(feedback.length <= 0){
		add_error('Please Add A Feedback Message');
		return false;
	}else if(firstname.length <= 0){
		add_error('Please Enter First Name');
		return false;
	}else if(lastname.length <= 0){
		add_error('Please Enter Last Name');
		return false;
	}else if(email.length <= 0){
		add_error('Please Enter Email Address');
		return false;
	}else if(!validate_email(email)){
		add_error('Please Enter A Valid Email Address');	
		return false;
	}else if(country.length <= 0){
		add_error('Please Select a Country');
		return false;
	}else{
		hide_error();
		alert('Feedback Added!');
		return true;
	}
}
function add_error(msg){
		var e = $('.error-message');
		e.fadeOut(function(){
			e.html(msg).fadeIn();
		});
	}
function hide_error(){
	var e = $('.error-message');
	e.fadeOut();
}

function validate_email(email) {
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
		return true;
		}else{
		return false;
		}
	}
</script>

<style type="text/css">
    #add-feedback-setup-block{
        background:#f4f4f4;	
        margin-left:-10px;
    }
        .add-feedback-setup-border{display:block;height:2px;background:url(images/false-border.png);}
        .add-feedback-options{
            padding-bottom:10px;
        }
        .add-feedback-options h2{
            background:#6b7984;
            color:#dedede;
            font-size:14px;
            display:block;
            padding:4px 8px;
            border:1px solid #626f79;
        }
            .add-feedback-types{
                padding:10px 20px 0px;
            }
            .add-feedback-types h3{
                cursor:pointer !important;
                font-size:14px !important;
                color:#778086 !important; 
                display:block;
                padding-bottom:10px;
                margin:0px !important;
                background:url(images/false-border.png) repeat-x bottom;
            }
            .add-feedback-types h3 label{cursor:pointer;}
            .add-feedback-opts{
                padding:5px 10px;
            }
            .add-feedback-form{
                padding:5px 10px;
            }
            .templates ul{list-style:none}
            .templates ul li{width:84px;}
            .add-feedback-opts a.button{
                background:#d1e2f1 url(images/button-highlight.png) top repeat-x;
                color:#6b8194;
                padding:4px 11px;
                -webkit-border-radius:12px;
                -moz-border-radius:12px;
                border-radius:12px;
                border:1px solid #9ebdd8;
                font-weight:bold;
            }
            .add-feedback-opts a.button:hover{background:#dce9f5;}
            
            .add-feedback-opts a.button-gray{
                background:#eceff1 url(images/button-highlight.png) top repeat-x;
                color:#6b8194;
                padding:4px 11px;

                -webkit-border-radius:12px;
                -moz-border-radius:12px;
                border-radius:12px;
                border:1px solid #c1c8d0;
                font-weight:bold;
            }
            .add-feedback-opts a.button-gray:hover{background:#dce9f5;}
            #add-feedback-preview{
                width:360px;
                margin-left:19px;
                float:left;
                position:absolute;
                top:20px;
                left:200px;
                }
                .add-feedback-block{
                    border:1px solid #c8ced2;
                    -webkit-border-radius:4px;
                    -moz-border-radius:4px;
                    border-radius:4px;
                    margin-bottom:15px;
                    overflow:hidden;
                }
                .add-feedback-block h2{
                    display:block;
                    border-top:1px solid #ffffff;
                    border-bottom:1px solid #c8ced2;
                    color:#8a9196;
                    text-shadow:#fafafa 0px 1px;
                    font-size:14px;font-weight:bold;
                    padding:8px 12px;
                    background:#eceff1;
                }
                .add-feedback-block .html-code textarea{display:block;width:338px;height:133px;border:none;padding:10px;font-size:11px;}
                
                
                
                .add-feedback-form{
                    padding:5px 10px;
                }
                .add-feedback-form label{padding-left:6px;}
                .add-feedback-form .custom-message{float:left;list-style:none;padding-left:10px;}
                .add-feedback-form .custom-message li{margin:0px;padding:0px;font-size:11px;}
                .add-feedback-opts span.gray{color:#707d87;font-size:10px;}
                .error-message{background:url(images/yellow-error.png) repeat;padding:10px 30px;color:#565758;margin:0px -20px;font-weight:bold;}
                .float-right{float:right;}
                
                /* rating page */
                .rate-slider{width:517px;height:33px;background:url(/img/rate-slider-blue.png);margin-top:8px;position:relative;}
                .rate-slider #rate_e,.rate-slider #rate_g,.rate-slider #rate_a,.rate-slider #rate_p,.rate-slider #rate_b{float:left;height:33px;position:relative;cursor:pointer;}
                .rate-slider #track_ball{width:30px;height:33px;position:absolute;background:url(/img/trackball.png) no-repeat;left:-4px;}
                .rate-slider #rate_e,.rate-slider #rate_b{width:65px;}
                .rate-slider #rate_g,.rate-slider #rate_a,.rate-slider #rate_p{width:129px;}
                
                .ratings{color:#adafb0;font-size:12px;font-weight:bold;}
                .ratings ul{margin:0px;padding:0px;position:relative;height:30px;}
                .ratings ul li	   	  {list-style:none;display:inline;margin:0px;padding:0px;position:absolute;top:0px;background:none !important;text-shadow:none !important;}
                .ratings ul li.good	  {left:117px;}
                .ratings ul li.average{left:234px;}
                .ratings ul li.poor	  {left:370px;}
                .ratings ul li.bad	  {left:490px;}
                .rate{float:right;width:517px;}
                .rate-text{float:left;padding-top:16px;}
</style>
<div class="block">
    <div id="add-feedback-setup-block">
        <div class="add-feedback-options">
            <h2>Add Feedback</h2>
            <div class="add-feedback-types">
                <h3><label for="full_page_type">Recepient Details</label></h3>
                <div class="add-feedback-form" id="full_page_add-feedback">
                    
                    <div class="grids">
                        <div class="rate-text"><label><strong>Rating :</strong></label> </div>
                        <div class="rate">
                            <div class="rate-slider" id="smart-slider">
                                <input type="hidden" id="rating" name="rating" value="5" >
                                <div id="track_ball"></div>
                                <div id="rate_e"></div>
                                <div id="rate_g"></div>
                                <div id="rate_a"></div>
                                <div id="rate_p"></div>
                                <div id="rate_b"></div>
                            </div>
                            <div class="ratings">
                                <ul>
                                    <li class="excellent">EXCELLENT</li>
                                    <li class="good">GOOD</li>
                                    <li class="average">AVERAGE</li> 
                                    <li class="poor">POOR</li>
                                    <li class="bad">BAD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="grids">
                        <label><strong>Feedback : </strong></label><br />
                        <textarea class="regular-text" id="feedback" name="feedback" style="width:400px;float:left" rows="7"></textarea>
                    </div>
                    <br />
                    <div class="grids">
                        <label><strong>Display Options :</strong></label> 
                        <input type="radio" checked="checked" name="permission" id="permission1"/> <label for="permission1" >Make Feedback Public</label> 
                        <input type="radio" name="permission" id="permission2" /> <label for="permission2" >Sticky Feedback </label>
                        <input type="radio" name="permission" id="permission3" /> <label for="permission3" >Private Feedback </label>
                    </div>
                    <br />
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>First Name</strong></label><br />
                            <input type="text" name="firstname" class="regular-text" id="firstname" />
                        </div>
                        <div class="g1of3">
                            <label><strong>Last Name</strong></label><br />
                            <input type="text" name="lastname" class="regular-text" id="lastname" />
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>Email Address</strong></label><br />
                            <input type="text" name="email" class="regular-text" id="email" />
                        </div>
                        <div class="g1of3">
                            <label><strong>Position</strong></label><br />
                            <input type="text" name="position" class="regular-text" id="position" />
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>City</strong></label><br />
                            <input type="text" name="city" class="regular-text" id="city" />
                        </div>
                        <div class="g1of3">
                            <label><strong>Country</strong></label><br />
                            <select class="regular-select" name="country" id="country">
                                <?php
                                /*
                                $user = "root";
                                $pass = "brx4*svv";
                                $host = "localhost";
                                $db = "s36";
                                $connect = mysql_connect($host,$user,$pass) or die(mysql_error());
                                           mysql_select_db($db) or die(mysql_error());
                                if($connect){
                                    $q_country = mysql_query("SELECT * FROM Country") or die(mysql_error());
                                    if(mysql_num_rows($q_country) > 0){
                                        while($c = mysql_fetch_array($q_country)){
                                            if($country == $c['name']){
                                                echo '<option value="'.$c['code'].'" selected>'.$c['name'].'</option>';
                                            }else{
                                                echo '<option value="'.$c['code'].'">'.$c['name'].'</option>';
                                            }
                                        }
                                    }
                                }
                                */
                                ?>
                                <?foreach($countries as $country):?>
                                    <option value="<?=$country->code?>"><?=$country->name?></option>
                                <?endforeach?>
                            </select>
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>Add Photo :</strong> </label> <br />
                            <input type="file" class="regular-text" name="photo" />
                        </div>
                        <div class="g1of3">&nbsp;</div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                </div>
                <h3>&nbsp;</h3>
                <div class="add-feedback-opts">
                    <span class="gray">Add a user feedback or testimonial manually, then decide how you want this feedback to be displayed - <br />feature it, hide it, it's up to you.</span>
                </div>
                <div class="error-message">
                    
                </div>
            </div>
            
            
        </div>
        
        <div class="add-feedback-setup-border"></div>
        
        <div>
            <br />
            <input type="submit" value="add feedback" />
            <br /><br />
        </div>
    </div>
</div>

<!-- spacer -->
<div class="block noborder" style="height:300px;">
</div>
<!-- spacer -->
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
