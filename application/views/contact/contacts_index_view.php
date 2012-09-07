<?=$metrics?>
            <!-- top blue bar with filter options -->
            <div class="admin-sorter-bar">
            	<div class="sorter-bar">
                    <div class="left">
                    	&nbsp;
                    </div>
                    <div class="right">
                        <?=Form::open('contacts/search')?>
                            <label>Search</label>
                            <input type="text" class="small-text" name="search_contact" value="<?=Input::get('search_contact')?>" style="width: 200px" /> 
                        <?=Form::close()?>
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
                                <td><?=HTML::link('contacts/view_contact?name='.$contact->firstname."&email=".$contact->email.'&offset=0&limit=5'.$page
                                                  , $contact->feedbackidcount
                                                  , Array('class' => 'contact-link'))?></td>
                                <td>
                                    <input type="button" class="contact-edit" hrefaction="<?=URL::to('contacts/edit_contact?email='.$contact->email.$page)?>"/>
                                    <input type="button" class="contact-delete" hrefaction="<?=URL::to('contacts/delete_contact?email='.$contact->email)?>"/>
                                </td>
                            </tr>
                        <?endforeach?> 
                    </tbody>
                </table>
            </div>
            <!-- end of feedback list -->
            <div class="admin-sorter-bar">
            	<div class="sorter-bar">
                    <?=$pagination?> 
                    <div class="c"></div>
                </div>
            </div>
            <!--
            <div class="block noborder">
            	<p></p>
            	<a href="#" class="gray-btn rounder" style="font-size:14px;font-weight:bold;color:#565656;padding:6px 8px;margin-right:5px;text-shadow:#d5d8da 0px 1px;">Export Contacts</a><span>Contacts will be exported as a comma delimited file (CSV format). </span>
                <p></p>
            </div>
            -->
            <!-- spacer -->
            <!-- spacer -->
        </div>
        
        <!-- end of the main panel -->
        
        <!-- div need to clear floated divs -->
        <div class="c"></div>
    </div>
