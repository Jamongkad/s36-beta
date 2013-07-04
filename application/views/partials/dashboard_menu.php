<div id="theDashboardMenu">
    <? $regex = Helpers::nav_regex()
       print_r($regex); 
    ?>
    <ul>
        <li><a href="/">Home</a></li>
        <li class="active-menu"><a href="/inbox/all" inboxclick>Inbox</a> <span feedbackcount></span></li>
        <li><a href="/inbox/published/all">Published</a></li>
        <li><a href="/inbox/filed/all">Filed Feedback</a></li>
        <li><a href="/inbox/deleted/all">Deleted</a></li>
        <li><a href="/feedsetup">Feedback Setup</a></li>
        <li><a href="/dashboard">Reports</a></li>
        <li><a href="/settings/display">Display Setup</a></li>
        <li><a href="javascript:;">Settings</a></li>
    </ul>
</div>
