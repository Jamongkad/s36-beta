<div class="block">
    <p class="small">
        Total contacts:<span class="count"><?=$contacts->total_rows?></span>          
        Total requests sent:<span class="count">0</span>          
        Total responses:     <span class="count">0</span>
    </p> 
</div>
            <!-- top blue bar with filter options -->
            <div class="admin-sorter-bar">
            	<div class="sorter-bar">
                    <div class="left">
                    	&nbsp;
                    </div>
                    <div class="right">
                    	<div class="g4of5">
                            <!--
                        	<label>SORT BY</label>
                            <select>
                            	<option>Date</option>
                            </select>
                            -->
                        	<label>Search Name</label>
                            <input type="text" class="small-text" />
                        	&nbsp;
                        </div>
                        <div class="g1of5">
                        	&nbsp;
                        </div>
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
                        	<td class="avatar"></td>
                            <td>NAME</td>
                        	<td>EMAIL ADDRESS</td> 
                            <td>FEEDBACK</td>   
                            <td>OPTION</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach($contacts->result as $contact):?>
                            <tr> 
                        	    <td class="avatar"> 
                                    <?if($contact->avatar):?> 
                                        <?=HTML::image('uploaded_cropped/48x48/'.$contact->avatar)?>
                                    <?else:?>
                                        <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                                    <?endif?>
                                </td>
                                <td class="name"><?=$contact->firstname?> <?=$contact->lastname?></td>
                                <td><?=$contact->email?></td>
                                <td><?=HTML::link('/', count(explode("|", $contact->feedbackids)))?></td>
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
