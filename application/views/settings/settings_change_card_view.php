			<script type="text/javascript">
				$(document).ready(function(){
						$('#change_card_submit').click(function(){
								$('.alert').css('display','none');
								$('#progress_box_card').css('display','block');
								$('#success_box').css('display','none');
								$('#error_box').css('display','none');	
								$.ajax({
									type: "POST",
									url:	"/settings/change_card/?action=confirm",
									data: "billing_card_number="+$('#billing_card_number').val()+"&billing_card_cvv="+$('#billing_card_cvv').val()+"&billing_expire_month="+$('#billing_expire_month').val()+"&billing_expire_year="+$('#billing_expire_year').val(),
									success: function(q){
										var result = $.parseJSON(q);
										var messages = result['messages'];
										if(result['error']){
										$('#success_box').css('display','none');
										$('#error_box').css('display','block');										
											var err = '<ul>';
											if($.isArray(messages) || $.isPlainObject(messages)){
												
												$.each(messages, function(key, value) {
													value = (value+'').replace(/\./g,'<br>');
													value = (value+'').replace(/\,/g,'');
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
										$('#progress_box_card').css('display','none');
									}
								});
								return false;
						});
				});			
			</script>
			<?php $cardInfo = $accountInfo->companyCreditCardInfo;?>
			<div id="credit_card" class="block noborder">
			<h3>Your current credit card</h3>
				<div style="background:#f4f4f4" class="block noborder">
					<p><label class="regular-label">Card Type:&nbsp;</label><?=$cardInfo->card_type?></p>
            	<p><label class="regular-label">Card Number:&nbsp;</label><?=$cardInfo->masked_number?></p>
					<p><label class="regular-label">Expires on:&nbsp;</label><?=$cardInfo->expiration_month?>/<?=$cardInfo->expiration_year?></p>
				</div>
         </div>	
			<div class="block noborder">
            	<h3>Change your credit card</h3>
                <div style="background:#f4f4f4" class="block noborder">
					 <div id="progress_box_card" class="alert" style="display:none">Updating credit card details...</div>
                <div id="error_box" class="alert alert-error" style="display:none"></div>
                <div id="success_box" class="alert alert-success" style="display:none"></div>
                	<h4>Credit card details (this information is secure)</h4>
                		<form id="change_card" autocomplete="off" action="" method="post">
                    <table>
                    	<tbody>
								<tr style="vertical-align:top;height:1px;">
                        	<td class="regular-label">Card Number : </td>
                        	<td>
                           <input type="text" id="billing_card_number" name="billing_card_number" class="regular-text " maxlength="16">
                            </td>
                            <td>
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
                        <tr>
                        	<td></td>
                        	<td colspan="3">
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