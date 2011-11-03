
            <div class="block">
            	<p class="small">Total contacts:     <span class="count">2534</span>          Total requests sent:     <span class="count">3421</span>          Total responses:     <span class="count">896</span></p>
                
            </div>
            <!-- top blue bar with filter options -->
            <div class="admin-sorter-bar">
            	<div class="sorter-bar">
                    <div class="left">
                    	&nbsp;
                    </div>
                    <div class="right">
                    	<div class="g1of5">
                        	<label>SORT BY</label>
                            <select>
                            	<option>Date</option>
                            </select>
                        </div>
                        <div class="g1of5">
                        	&nbsp;
                        </div>
                        <div class="g1of5">
                        	&nbsp;
                        </div>
                        <!--
                        <div class="g2of5 right-align">
                        	<label>Display</label>
                            <select>
                            	<option>50</option>
                            </select>
                        </div>
                        -->
                    </div>
                    <div class="c"></div>
                </div>
            </div>
            <!-- end of top blue bar with filter options -->
            
            <!-- the feedback list -->
			<div class="contact-table">
            	<table width="100%" cellpadding="0" cellspacing="0">
                	<thead>
                		<tr>
                        	<td class="checkbox"><input type="checkbox" /></td>
                            <td>NAME</td>
                        	<td>EMAIL ADDRESS</td>
                            <!--
                            <td>LAST SENT DATE</td>
                            <td>REQUESTS</td>
                            <td>STATUS</td>
                            -->
                            <td>OPTION</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach($contacts->result as $contact):?>
                            <tr> 
                        	    <td class="checkbox"><input type="checkbox" /></td>
                                <td class="name"><?=$contact->firstname?> <?=$contact->lastname?></td>
                                <td><?=$contact->email?></td>
                                <td><input type="button" class="edit" /><input type="button" class="delete" /></td>
                            </tr>
                        <?endforeach?>
                        
                    </tbody>
                </table>
            </div>
            <!-- end of feedback list -->
            <div class="admin-sorter-bar">
            	<div class="sorter-bar">
                    <div class="left">
                    	&nbsp;
                    </div>
                    <div class="right">
                    	<div class="g1of3">
                        	<label>WITH SELECTED</label>
                            <select>
                            	<option>Delete</option>
                            </select>
                        </div>
                        <div class="g1of3">
                            <?=$pagination?>
                        </div>
                    </div>
                    <div class="c"></div>
                </div>
            </div>

            <div class="block noborder">
            	<p></p>
            	<a href="#" class="gray-btn rounder" style="font-size:14px;font-weight:bold;color:#565656;padding:6px 8px;margin-right:5px;text-shadow:#d5d8da 0px 1px;">Export Contacts</a><span>Contacts will be exported as a comma delimited file (CSV format). </span>
                <p></p>
            </div>
            <!-- spacer -->
            <div class="block noborder" style="height:100px;">
            </div>
            <!-- spacer -->
        </div>
        
        <!-- end of the main panel -->
        
        <!-- div need to clear floated divs -->
        <div class="c"></div>
    </div>
