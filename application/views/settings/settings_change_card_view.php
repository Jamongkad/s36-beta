			<script type="text/javascript">
				$(document).ready(function(){
						$('#change_card_submit').click(function(){
								$('#progress_box').css('display','block');
								$('#success_box').css('display','none');
								$('#error_box').css('display','none');	
								$.ajax({
									type: "POST",
									url:	"/settings/change_card/?action=confirm",
									data: "card_number="+$('#card_number').val()+"&card_cvv="+$('#card_cvv').val()+"&expire_month="+$('#expire_month').val()+"&expire_year="+$('#expire_year').val()+"&billing_zip="+$('#billing_zip').val(),
									success: function(q){
										var result = $.parseJSON(q);
										var messages = result['messages'];
										if(result['error']){
										$('#success_box').css('display','none');
										$('#error_box').css('display','block');										
											var err = '<ul>';
											if($.isArray(messages) || $.isPlainObject(messages)){
												$.each(messages, function(key, value) { 
												 	err += '<li>'+ value + '</li>';
												});
											}
											else{
													err += '<li>'+messages+'</li>';
											}
												err += '</ul>';
											$('#error_box').html(''+err);
										}
										else{
											$('#success_box').css('display','block');
											$('#success_box').html(messages);
											$('#error_box').css('display','none');
											$('#card_number').val('');
											$('#card_cvv').val('');
											$('#billing_zip').val('');
										}
										$('#progress_box').css('display','none');
									}
								});
								return false;
						});
				});			
			</script>
			<?php $cardInfo = $accountInfo->companyCreditCardInfo;?>
			<div class="block noborder">
			<h3>Your current credit card</h3>
				<div style="background:#f4f4f4" class="block noborder">
					<p><label class="regular-label">Card Type:&nbsp;</label><?=$cardInfo->card_type?></p>
            	<p><label class="regular-label">Card Number:&nbsp;</label><?=$cardInfo->masked_number?></p>
					<p><label class="regular-label">Expires on:&nbsp;</label><?=$cardInfo->expiration_month?>/<?=$cardInfo->expiration_year?></p>
				</div>
         </div>	
			<div class="block noborder">
            	<h3>Update your credit card</h3>
                <div style="background:#f4f4f4" class="block noborder">
					 <div id="progress_box" class="alert" style="display:none">Processing...</div>
                <div id="error_box" class="alert alert-error" style="display:none"></div>
                <div id="success_box" class="alert alert-success" style="display:none"></div>
                	<h4>Credit card details (this information is secure)</h4>
                		<form id="change_card" autocomplete="off" action="" method="post">
                    <table cellspacing="0" cellpadding="0">
                    	<tbody>
								<tr>
									<td><label class="regular-label">Card Number</label></td>
                    			<td>
                    				<input id="card_number" name="card_number" type="text" class="regular-text" maxlength="16">
                    			</td>
                    			<td><label class="regular-label">CVV:</label></td>
                    			<td><input id="card_cvv" name="card_cvv" type="text" class="regular-text" maxlength="4" size="4"></td>
                    		</tr>
                        <tr>
                        	<td><label class="regular-label">Expires On </label> </td>
                        	<td>
                        		<select id="expire_month" class="regular-select">
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
                        		<select id="expire_year" class="regular-select">
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
                        	<td></td>
                        	<td></td>
                        </tr>
                        <tr>
                        	<td><label class="regular-label">Billing Zip</label> </td>
                        	<td>
                        		<input id="billing_zip" type="text" class="regular-text small-text">
                        	</td>
                        	<td><span id="billing_zip_error" style="color:red;"></span></td>
                        </tr>
                        <tr>
                        	<td colspan="4">
										<strong>
                						<a class="gray-btn" id="change_card_submit" href="">Change my Credit Card</a> 
                					</strong>                        	
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