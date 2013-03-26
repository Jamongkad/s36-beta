<div class="formTitle">
    <h2>Share Your Feedback</h2>
</div>
<div ng-controller="FormCtrl">
    <div class="feedback">
        <div class="step-contents">
            <div id="hostform_info" style="width:50%;float:left;">
                <table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                    <tr><td colspan="2">
                    <input type="text" class="regular-text reg-text-active" ng-model="data.title"/>
                    </td></tr>
                </table>
                <table id="form_complete" class="form_complete" width="100%" border="0" cellpadding="4" cellspacing="4">
                    <tr><td>
                    <textarea class="regular-textarea reg-text-active" ng-model="data.feedbacktext"></textarea>
                    </td><td>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="s36_footer"> 
    <div class="s36_footerbtn right">
        <a href="#/profile" id="next" class="s36_btn">Next</a>
    </div>
</div>
