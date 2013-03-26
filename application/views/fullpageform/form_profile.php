<div class="formTitle">
    <h2>Please check your details below</h2>
</div>
<div ng-controller="ProfileCtrl">
    <div class="step-contents">
        <div id="hostform_info" style="width:50%;float:left;">
            <table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                <tr><td colspan="2"><strong>Required Fields</strong></td></tr>
                <tr><td><input type="text" ng-model="data.firstname" id="your_fname" class="regular-text required" title="First Name" value="" /></td>
                <td><input type="text" id="your_lname" ng-model="data.lastname" class="regular-text required" title="Last Name" value="" /></td></tr>
                <tr><td colspan="2"><input type="text" id="your_email" class="regular-text required long" title="Email Address" value="" /></td></tr>
            </table>
            <table id="form_complete" class="form_complete" width="100%" border="0" cellpadding="4" cellspacing="4">
                <tr><td><input type="text" id="your_city" class="regular-text required" title="City" value="" /></td><td>
                <select id="your_country" class="regular-select required" title="Country">
                    <option>Country</option>
                </select>
                    </td></tr>
                    <tr><td colspan="2"><strong>Optional info - but great to include!</strong></td></tr>
                    <tr><td><input type="text" id="your_company" value="" class="regular-text" title="Company Name" /></td><td><input type="text" value="" id="your_occupation" title="Occupation" class="regular-text required" /></td></tr>
                    <tr><td colspan="2"><input type="text" id="your_website" class="regular-text long" value="" title="Website Address" /></td></tr>
            </table>
        </div>
    </div>
</div>
<div id="s36_footer">
    <div class="s36_footerbtn left">
        <a href="#/" id="prev" class="s36_btn">Back</a>
    </div>
    
    <div class="s36_footerbtn right">
        <a href="#/review" id="next" class="s36_btn">Next Step</a>
    </div>
</div>
