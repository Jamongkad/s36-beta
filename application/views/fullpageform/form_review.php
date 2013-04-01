<div class="formTitle">
    <h2>Review Page</h2>
</div>
<div ng-controller="ReviewCtrl">
    <h3>What you wrote so far...</h3>
    <p>{{data.firstname}}</p>
    <p>{{data.lastname}}</p>
    <p>{{data.title}}</p>
    <p>{{data.feedbacktext}}</p>
</div>
<div id="s36_footer">
    <div class="s36_footerbtn left">
        <a href="#/profile" id="prev" class="s36_btn">Back</a>
    </div>
    
    <div class="s36_footerbtn right">
        <a href="#/submission_send" id="next" class="s36_btn">Send Now</a>
    </div>
</div>
