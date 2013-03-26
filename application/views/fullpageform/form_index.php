<div class="formTitle">
    <h2>Share Your Feedback</h2>
</div>
<div ng-controller="FormCtrl">
    <div class="feedback">
        <div class="step-contents">
            <div id="hostform_info" style="width:50%;float:left;">
                <table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                    <tr><td>
                        <input type="hidden" ng-model="data.rating"/>
                        <div class="dynamic-stars">
                            <div class="star-ratings clear">
                                <div class="star-container clear">
                                    <div id="1" class="star full" stars></div>
                                    <div id="2" class="star full" stars></div>
                                    <div id="3" class="star full" stars></div>
                                    <div id="4" class="star full" stars></div>
                                    <div id="5" class="star full" stars></div>
                                </div>
                                <div class="star-text">
                                    <span class=""></span>
                                </div>
                            </div>
                        </div> 
                    </td></tr>
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
