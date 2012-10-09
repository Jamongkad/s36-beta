<div class="block">
    <div class="grids">
        <div class="g2of3">
            <?foreach($admins as $admin):?>
                <div class="admin-box">
                    <div class="grids">
                        <?=(!$admin->confirmed) ? "<span style='padding: 2px; background-color: #E9EFF4; font-size:10px;font-weight:bold'>Invited</span>" : null?>
                        <div class="g1of3">
                            <?if($admin->avatar):?> 
                                <?=HTML::image('uploaded_cropped/48x48/'.$admin->avatar)?>
                            <?else:?>
                                <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                            <?endif?>
                            <?if($user_id == $admin->userid && $role != 'Admin'):?>
                                <small class="edit"><?=HTML::link('admin/edit_admin/'.$admin->userid, 'edit')?></small>
                            <?endif?>

                            <?if($role == 'Admin'):?>
                                <small class="edit"><?=HTML::link('admin/edit_admin/'.$admin->userid, 'edit')?></small>
                                <?if($user_id != $admin->userid):?>
                                    <small class="edit">
                                        <?=HTML::link('admin/delete_admin/'.$admin->userid, 'delete', Array('class' => 'admin-delete'))?>
                                    </small>
                                <?endif?>
                            <?endif?>
                        </div>
                        <div class="g2of3">
                            <div class="admin-info"> 
                                <h3><?=$admin->username?></h3>
                                <p><?=$admin->title?></p>
                                <p><strong>Email: </strong></p>
                                <p><?=$admin->email?></p>
                                <p><small><?=$admin->itemname?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?endforeach?> 
        </div>
        <div class="g1of3">
            <div class="admin-sidebar">
                <h3>Admins can help you on your behalf to review, feature and file feedback as it comes in. You can add up to 5 admins according to your current plan. </h3>

                <br />
                <?=HTML::link('admin/add_admin', 'ADD NEW ADMIN', array('class' => 'blue-btn'))?>
                <br />
                <h3>Administrators can: </h3>
                <ul>
                    <li>Manage feedback (approve, sticky and delete) </li>
                    <li>Request for feedback </li>
                    <li>Sort and edit feedback </li>
                    <li>Manage feedback widgets</li>
                </ul>
                <h3>Only the account holder can: </h3>
                <ul>
                    <li>Cancel the account </li>
                    <li>Upgrade or downgrade the account </li>
                    <li>View or change billing details</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
