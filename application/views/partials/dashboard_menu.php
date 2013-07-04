<div id="theDashboardMenu">
    <? $regex = Helpers::nav_regex(); ?>
    <ul>
        <li><a href="/">Home</a></li>
        <li<?=($regex->inbox ? ' class="active-menu"' : null)?>><a href="/inbox/all" inboxclick>Inbox</a> <span feedbackcount></span></li>
        <li<?=($regex->published ? ' class="active-menu"' : null)?>><a href="/inbox/published/all">Published</a></li>
        <li<?=($regex->filed ? ' class="active-menu"' : null)?>><a href="/inbox/filed/all">Filed Feedback</a></li>
        <li<?=($regex->deleted ? ' class="active-menu"' : null)?>><a href="/inbox/deleted/all">Deleted</a></li>
        <li<?=($regex->feedsetup ? ' class="active-menu"' : null)?>><a href="/feedsetup">Feedback Setup</a></li>
        <li<?=($regex->dashboard ? ' class="active-menu"' : null)?>><a href="/dashboard">Reports</a></li>
        <li<?=($regex->settings ? ' class="active-menu"' : null)?>><a href="/settings/display">Display Setup</a></li>
        <li><a href="javascript:;">Settings</a></li>
    </ul>
</div>
