<!-- top navigation bar -->
<div class="admin-nav-bar">
    <ul>
        <li><?=HTML::link('admin/add_admin', 'ADD NEW ADMIN')?></li> 
    </ul>
</div>

<div class="block">
    <div class="grids">
        <div class="g2of3">
            <?foreach($admins as $admin):?>
                <div class="admin-box">
                    <div class="grids">
                        <div class="g1of3">
                            <img src="images/avatar-henry.png" />
                            <small class="edit"><?=HTML::link('admin/edit_admin/'.$admin->userid, 'edit')?></small>
                        </div>
                        <div class="g2of3">
                            <div class="admin-info"> 
                                <h3><?=$admin->fullname?></h3>
                                <p><?=$admin->title?></p>
                                <br />
                                <p><strong>Email: </strong></p>
                                <p><?=$admin->email?></p>
                                <br />
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
                <a href="add-new-admin.php" class="blue-btn">ADD NEW ADMIN 	</a>
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
