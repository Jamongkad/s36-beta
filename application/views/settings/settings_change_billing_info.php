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

						$('#proceed_btn').click(function(){
								$('.alert-error').css('display','none');
								$('#progress_box').css('display','block');
								$('#success_box').css('display','none');
								$.ajax({
									type: "POST",
									url:	"/settings/change_billing_info",
									data: "billing_first_name="+$('#billing_first_name').val()+"&billing_last_name="+$('#billing_last_name').val()+"&billing_address="+$('#billing_address').val()+"&billing_city="+$('#billing_city').val()+"&billing_state="+$('#billing_state').val()+"&billing_country="+$('#billing_country').val()+"&billing_zip="+$('#billing_zip').val(),
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
												});
											}
										}
										else{
											$('.alert').css('display','none');
											show('success_account_update');
										}								
										$('#progress_box').css('display','none');
									}
								});
								return false;
						});
				});			
			</script>




<div class="block noborder">

            	<h3>Update Billing Informations</h3>
                <div style="background:#f4f4f4" class="block noborder">
					<div id="success_account_update" class="alert alert-success" style="display:none">
						Your Billing Informations has been updated.
					</div>
					<div id="progress_box" class="alert" style="display:none">Updating records...</div>
                	<form id="change_billing_info" autocomplete="off" action="" method="post">
                   <table>
                    	<tbody>
                    		<tr>
                    			<td class="label">First Name : </td>
                        	<td>
                           <input value="<?=$companyBillingInfo->firstName?>" type="text" id="billing_first_name" name="billing_first_name" class="regular-text">
                           </td>
                           <td width="215px"><span id="error_billing_first_name" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Last Name : </td>
                        	<td>
                           <input value="<?=$companyBillingInfo->lastName?>" type="text" id="billing_last_name" name="billing_last_name" class="regular-text ">
                           </td>
                           <td><span id="error_billing_last_name" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing Address : </td>
                        	<td>
                           <input value="<?=$companyBillingInfo->streetAddress?>" type="text" id="billing_address" name="billing_address" class="regular-text ">
                           </td>
                           <td><span id="error_billing_address" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing City : </td>
                        	<td>
                           <input value="<?=$companyBillingInfo->locality?>" type="text" id="billing_city" name="billing_city" class="regular-text ">
                           </td>
									<td><span id="error_billing_city" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing State : </td>
                        	<td>
                            <input value="<?=$companyBillingInfo->region?>" type="text" id="billing_state" name="billing_state" class="regular-text ">
                           </td>
                           <td><span id="error_billing_state" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing Country : </td>
                        	<td>
                               <select id="billing_country" name="billing_country" class="regular-select">
											<option value="">select country</option>
                        			<?php 
											foreach($countries as $country):
												echo ($companyBillingInfo->countryName == $country->name) ? "<option value='$country->name' selected>$country->name</option>"  : "<option value='$country->name'>$country->name</option>";       			
                        			endforeach;
                        			?>
                        		</select>
						    		</td>
						    		<td><span id="error_billing_country" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
                        </tr>
                        <tr>
                        	<td class="label">Billing ZIP : </td>
                        	<td>
                           <input value="<?=$companyBillingInfo->postalCode?>" type="text" id="billing_zip" name="billing_zip" class="regular-text ">
                           </td>
									<td><span id="error_billing_zip" class="alert alert-error" style="margin:0;padding:4px;display:none"></span></td>
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