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

						$('#save_all').click(function(){
								$('.alert').css('display','none');
								$('#progress_box_address').css('display','block');
								$('#success_address_update').css('display','none');
								$.ajax({
									type: "POST",
									url:	"/settings/change_billing_info",
									data: "billing_first_name="+$('#billing_first_name').val()+"&billing_last_name="+$('#billing_last_name').val()+"&billing_address="+$('#billing_address').val()+"&billing_city="+$('#billing_city').val()+"&billing_state="+$('#billing_state').val()+"&billing_country="+$('#billing_country').val()+"&billing_zip="+$('#billing_zip').val()+"&billing_card_number="+$('#billing_card_number').val()+"&billing_card_cvv="+$('#billing_card_cvv').val()+"&billing_expire_month="+$('#billing_expire_month').val()+"&billing_expire_year="+$('#billing_expire_year').val(),
									success: function(q){
										var result = $.parseJSON(q);
										var messages = result['messages'];
										//validation errors occured
										if(result['error']){
											if($.isArray(messages) || $.isPlainObject(messages)){
												$.each(messages, function(key, value) {
													err = (value+'').replace(/\.,/g,'.<br>');
													show_error(key,err);							 	
												});
											}
										}
										else{
											$('.alert').css('display','none');
											$('#success_address_update').focus();
											show('success_address_update');
										}								
										$('#progress_box_address').css('display','none');
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
								var str = '<select name="billing_state" id="billing_state" class="regular-select">';
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
<div style="margin-top:10px;border-top:1px solid #dedede;" class="block graybg">
    <h3>COMPANY BILLING AND PAYMENT INFORMATION</h3>
</div>
<div id="success_address_update" class="alert alert-success" style="display:none">Your billing and payment information has been updated.</div>
<div id="progress_box_address" class="alert" style="display:none">Updating billing and payment information...</div>
			<div id="billing_address_box" class="block" style="border-bottom:0px;">
				<h3>Billing Information</h3>
                <div style="background:#f4f4f4" class="block noborder">
                <form id="change_billing_info" action="" method="post">
                   <table>
                    <tbody>
                    	<tr>
                    		<td class="regular-label">First Name : </td>
                        	<td>
                    	       <input value="<?=ucfirst(strtolower($companyBillingInfo->firstName))?>" type="text" id="billing_first_name" name="billing_first_name" class="regular-text">
                           </td>
                           <td width="215px"><span id="error_billing_first_name" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="regular-label">Last Name : </td>
                        	<td>
                        	   <input value="<?=ucfirst(strtolower($companyBillingInfo->lastName))?>" type="text" id="billing_last_name" name="billing_last_name" class="regular-text ">
                           </td>
                           <td><span id="error_billing_last_name" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="regular-label">Billing Address : </td>
                        	<td>
                           		<input value="<?=$companyBillingInfo->streetAddress?>" type="text" id="billing_address" name="billing_address" class="regular-text ">
                           	</td>
                           	<td><span id="error_billing_address" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="regular-label">Billing City : </td>
                        	<td>
                           		<input value="<?=ucfirst(strtolower($companyBillingInfo->locality))?>" type="text" id="billing_city" name="billing_city" class="regular-text ">
                           	</td>
							<td><span id="error_billing_city" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="regular-label">Billing State : </td>
                        	<td>
                        		<div id="billing_state_div">
                            	<input value="<?=$companyBillingInfo->region?>" type="text" id="billing_state" name="billing_state" class="regular-text ">
	                           </div>
                           	</td>
                           	<td><span id="error_billing_state" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="regular-label">Billing Country : </td>
                        	<td>
                        		 <div id="billing_country_div">
                            	   <select id="billing_country" name="billing_country" class="regular-select">
										<option value="">select country</option>
                        				<?php foreach($countries as $country): ?>
												<option value="<?=$country->code?>" <?=($companyBillingInfo->countryCodeAlpha2==$country->code) ? 'selected':''?>><?=$country->name?></option>
										<?php endforeach; ?>
                        			</select>
                        		</div>
						    </td>
						    <td><span id="error_billing_country" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="regular-label">Billing ZIP : </td>
                        	<td>
                           		<input value="<?=$companyBillingInfo->postalCode?>" type="text" id="billing_zip" name="billing_zip" class="regular-text" maxlength="9">
                           	</td>
							<td><span id="error_billing_zip" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                    </tbody>
                    </table>
                    </form>
                </div>
            </div>
            	
            <!---Credit Card-->
            <?php $cardInfo = $accountInfo->companyCreditCardInfo;?>
			<div id="credit_card" class="block border-bottom">
			<h3>Payment Information</h3>
			<div style="background:#f4f4f4" class="block noborder">

				<h4>Your current credit card</h4>
				<p><label class="regular-label">Card Type:&nbsp;</label><?=$cardInfo->card_type?></p>
            	<p><label class="regular-label">Card Number:&nbsp;</label><?=$cardInfo->masked_number?></p>
				<p><label class="regular-label">Expires on:&nbsp;</label><?=$cardInfo->expiration_month?>/<?=$cardInfo->expiration_year?></p>
				
        
            	<h4>Change your credit card</h4>
				<div id="progress_box_card" class="alert" style="display:none">Updating credit card details...</div>
                <div id="error_box" class="alert alert-error" style="display:none"></div>
                <div id="success_box" class="alert alert-success" style="display:none"></div>
                    <table>
                    	<tbody>
							<tr style="vertical-align:top;height:1px;">
                        	<td class="regular-label">Card Number : </td>
                        	<td>
                           <input type="text" id="billing_card_number" name="billing_card_number" class="regular-text " maxlength="16">
                            </td>
                            <td width="300px">
                            <span id="error_billing_card_number" class="alert alert-error" style="margin:0;padding:4px;display:none"></span>
                            </td>
                        </tr>
                        <tr>
                        	<td class="regular-label">CVV : </td>
                        	<td style="vertical-align:top;">
                           <input type="text" id="billing_card_cvv" name="billing_card_cvv" class="regular-text " maxlength="4">
                           </td>
                           <td><span id="error_billing_card_cvv" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                            <td class="regular-label">Expiry Date : </td>
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
                    </tbody>
                    </table>
                    </form>
                </div>
            </div>
            <div class="block grids" style="text-align:center;border-bottom:0px;">
        			<div class="g3of4">
            		<div class="grids">
                	<p><input id="save_all" type="submit" class="large-btn" value="Save all changes"></p>
            		</div>
        			</div>
    		</div>
			<div style="height:300px;" class="block noborder"></div>
				
				