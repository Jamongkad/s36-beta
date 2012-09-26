<script type="text/javascript">
	function show_error(id,err){
		$('#error_'+id).css('display','block');
		$('#error_'+id).html(err);
	}
	function show(id){
		$('#'+id).css('display','block');
	}
	function hide_error(id){
		$('#error_'+id).css('display','none');
		$('#error_'+id).html('');
	}
				$(document).ready(function(){


						$('.plan-image').click(function(){
							$('.plan-image').removeClass('plan-active');
							$('#'+this.id).addClass('plan-active');
							$('#plan_selected').val(this.id);
							$('#plan_selected_name').html(this.id.toUpperCase());
							$('#info_select_plan').css('display','none');
							show('success_plan_selected');
							hide_error('plan_selected');
						});					
						
						
						$('#proceed_btn').click(function(){
								$('.alert-error').css('display','none');
								$('#progress_box').css('display','block');
								$('#success_box').css('display','none');
								$('#info_select_plan').css('display','none');
								$.ajax({
									type: "POST",
									url:	"/settings/add_billing_info",
									data: "plan_selected="+$('#plan_selected').val()+"&billing_first_name="+$('#billing_first_name').val()+"&billing_last_name="+$('#billing_last_name').val()+"&billing_address="+$('#billing_address').val()+"&billing_city="+$('#billing_city').val()+"&billing_state="+$('#billing_state').val()+"&billing_country="+$('#billing_country').val()+"&billing_zip="+$('#billing_zip').val()+"&billing_card_number="+$('#billing_card_number').val()+"&billing_expire_month="+$('#billing_expire_month').val()+"&billing_expire_year="+$('#billing_expire_year').val()+"&billing_card_cvv="+$('#billing_card_cvv').val(),
									success: function(q){
										var result = $.parseJSON(q);
										var messages = result['messages'];
										//validation errors occured
										if(result['error']){
											if($.isArray(messages) || $.isPlainObject(messages)){
												$.each(messages, function(key, value) {
													value = (value+'').replace(/\./g,'<br>');
													err = (value+'').replace(/\,/g,'');
													show_error(key,err);
													if(key=='plan_selected'){
														$('#success_plan_selected').css('display','none');
														$('#info_select_plan').removeClass('alert-info');
														$('#info_select_plan').addClass('alert-error');
														show('info_select_plan');											
													}								 	
												});
											}
										}
										else{
											$('.alert').css('display','none');
											$('#success_account_update').focus();
											show('success_account_update');
											window.location = '/settings/upgrade';
										}								
										$('#progress_box').css('display','none');
									}
								});
								return false;
						});
						
						
						/*The country onchange starts here*/
						var orig_html;
						var orig_value;
						var state_value;
				
						var us_states = {AL: 'Alabama', AK: 'Alaska', AZ: 'Arizona', AR: 'Arkansas', CA: 'California', CO: 'Colorado', CT: 'Connecticut', DE: 'Delaware', DC: 'District of Columbia', FL: 'Florida', GA: 'Georgia', HI: 'Hawaii', ID: 'Idaho', IL: 'Illinois', IN: 'Indiana', IA: 'Iowa', KS: 'Kansas', KY: 'Kentucky', LA: 'Louisiana', ME: 'Maine', MD: 'Maryland', MA: 'Massachusetts', MI: 'Michigan', MN: 'Minnesota', MS: 'Mississippi', MO: 'Missouri', MT: 'Montana', NE: 'Nebraska', NV: 'Nevada', NH: 'New Hampshire', NJ: 'New Jersey', NM: 'New Mexico', NY: 'New York', NC: 'North Carolina', ND: 'North Dakota', OH: 'Ohio', OK: 'Oklahoma', OR: 'Oregon', PA: 'Pennsylvania', RI: 'Rhode Island', SC: 'South Carolina', SD: 'South Dakota', TN: 'Tennessee', TX: 'Texas', UT: 'Utah', VT: 'Vermont', VA: 'Virginia', WA: 'Washington', WV: 'West Virginia', WI: 'Wisconsin', WY: 'Wyoming'};
						var $el = $("#billing_country");
						$el.data('oldval', $el.val());
						$el.change(function(){
							var $this = $(this);
							if(this.value=="US" && $this.data('oldval')!="US"){
								var str = '<select id="billing_state" name="billing_state" class="regular-select">';
								orig_html = $("#billing_state_div").html();
								orig_value = $("#billing_state").val();
								for(var st in us_states){
									if(st == state_value)
										str += '<option value="'+st+'" selected="selected">'+us_states[st]+'</option>';
									else
										str += '<option value="'+st+'">'+us_states[st]+'</option>';
								}
								str += "</select>";
								$("#billing_state_div").html(str);
								$this.data('oldval', $this.val());
							}
							else if($this.data('oldval')=="US" && $this.val()!="US"){
								state_value = $("#billing_state").val();
								$("#billing_state_div").html(orig_html);
								$("#billing_state").val(orig_value);
								$this.data('oldval', $this.val());
							}
						});
				});			
			</script>




<div class="block noborder">
<div id="success_account_update" class="alert alert-success" style="display:none">
	<strong>Congratulations! Your account has been updated.</strong><br>
	Loading Account Details..
</div>

<div class="alert">
	You are trying to upgrade your subscription plan.<br>
	In order to complete this transaction, please add your billing information by submitting the form below.
</div>
<div id="pring_plans">
	<div class="plan-box"><img id="basic" class="plan-image <?=(strtolower($planInfo->name)=='basic') ? 'plan-active' : '' ?>" src="/img/plan_basic.png"/></div>
	<div class="plan-box"><img id="enhanced" class="plan-image <?=(strtolower($planInfo->name)=='enhanced') ? 'plan-active' : '' ?>" src="/img/plan_enhanced.png"/></div>
	<div class="plan-box"><img id="premium" class="plan-image <?=(strtolower($planInfo->name)=='premium') ? 'plan-active' : '' ?>" src="/img/plan_premium.png"/></div>
</div>

<div id="success_plan_selected" class="alert alert-info" style="display:<?=(isset($planInfo->name)) ? 'block' : 'none'?>">
	<strong><span id="plan_selected_name"><?=(isset($planInfo)) ? strtoupper($planInfo->name) :'' ?></span> PLAN</strong> has been selected.
	<br>*You can also change the plan you want to obtain by clicking the images above.<br>
</div>

	<div id="info_select_plan" class="alert alert-info" style="display:<?=(isset($planInfo->name)) ? 'none' : 'block'?>">
	*please select the plan you want to obtain by clicking the plan options above.
</div>

<div id="progress_box" class="alert" style="display:none">Processing...</div>


            	<h3>Please input your Billing Information below to complete the transaction</h3>
                <div style="background:#f4f4f4" class="block noborder">
                	<h4>Credit card and billing address information</h4>
                	<form id="add_billing_info" autocomplete="off" action="" method="post">
                	<input type="hidden" id="plan_selected" name="plan_selected" value="<?=(isset($planInfo->name)) ? strtolower($planInfo->name) :'' ?>">
                   <table>
                    	<tbody>
                    	   <tr style="vertical-align:top;height:1px;">
                        	<td class="label">Card Number : </td>
                        	<td>
                           <input type="text" id="billing_card_number" name="billing_card_number" class="regular-text " maxlength="16">
                            </td>
                            <td>
                            <span id="error_billing_card" class="alert alert-error" style="margin:0;padding:4px;display:none"></span>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label">CVV : </td>
                        	<td style="vertical-align:top;">
                           <input type="text" id="billing_card_cvv" name="billing_card_cvv" class="regular-text " maxlength="4">
                           </td>
                           <td><span id="error_billing_card_cvv" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                            <td class="label">Expiry Date : </td>
                            <td style="vertical-align:top;height:1px;">
                              <select id="billing_expire_month" name="billing_expire_month" class="regular-select">
											<option value="">select month</option>
                        			<option value="01">01 January</option>
                        			<option value="02">02 February</option>
                        			<option value="03">03 March</option>
                        			<option value="04">04 April</option>
											<option value="05">05 May</option>
											<option value="06">06 June</option>
                        			<option value="07">07 July</option>
                        			<option value="08">08 August</option>
                        			<option value="09">09 September</option>
                        			<option value="10">10 October</option>
											<option value="11">11 November</option>
											<option value="12">12 December</option>
                        		</select>
										<select id="billing_expire_year" name="billing_expire_year"class="regular-select">
											<option value="">select year</option>
                        			<?php 
											$current_year = date('Y');
											echo "<option value='$current_year'>$current_year</option>";                        			           			                        			
                        			for($i=1;$i<10;$i++){
												$year=$current_year+$i;
												echo "<option value='$year'>$year</option>";          			
                        			}
                        			?>
                        		</select>
                             </td>
									<td><span id="error_billing_expire_date" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                    		<tr>
                    			<td class="label">First Name : </td>
                        	<td>
                           <input type="text" id="billing_first_name" name="billing_first_name" class="regular-text">
                           </td>
                           <td width="215px"><span id="error_billing_first_name" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Last Name : </td>
                        	<td>
                           <input type="text" id="billing_last_name" name="billing_last_name" class="regular-text ">
                           </td>
                           <td><span id="error_billing_last_name" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing Address : </td>
                        	<td>
                           <input type="text" id="billing_address" name="billing_address" class="regular-text ">
                           </td>
                           <td><span id="error_billing_address" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing City : </td>
                        	<td>
                           <input type="text" id="billing_city" name="billing_city" class="regular-text ">
                           </td>
									<td><span id="error_billing_city" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing State : </td>
                        	<td>
                            <div id="billing_state_div">
                            	<input type="text" id="billing_state" name="billing_state" class="regular-text ">
	                           </div>
                           </td>
                           <td><span id="error_billing_state" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing ZIP : </td>
                        	<td>
                           <input type="text" id="billing_zip" name="billing_zip" class="regular-text ">
                           </td>
									<td><span id="error_billing_zip" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing Country : </td>
                        	<td>
                               <div id="billing_country_div">
                               <select id="billing_country" name="billing_country" class="regular-select">
											<option value="">select country</option>
                        			<?php foreach($countries as $country): ?>
												<option value="<?=$country->code?>"><?=$country->name?></option>
											<?php endforeach; ?>
                        		</select>
                        		</div>
						    		</td>
						    		<td><span id="error_billing_country" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        

                        
								<tr>
									<td></td>
                        	<td colspan="4">
										<strong><a class="gray-btn" id="proceed_btn" href="">Save all changes</a></strong>                					                        	
                        	</td>
                        </tr>
                    </tbody>
                    </table>
                    </form>
                </div>
                <!--
                <h4>Any questions? Just <a href="#">contact us</a>, we'll help. <a href="#">36Stories support</a></h4>
                -->
            </div>
				<div style="height:300px;" class="block noborder"></div>