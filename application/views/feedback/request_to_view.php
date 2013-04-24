<?=Form::open('feedback/requestfeedback', 'POST', array('id' => 'request-form'))?>
<div id="request-feedback" class="lightbox"> 
    <div class="lightbox-styles" ng-controller="MainRequestCtrl">
    <div class="lightbox-close" my-request-close value="Cancel" ></div>
        <h2>Request Feedback</h2>
        <div class="lightbox-content">
            <div ng-include src="template.url"></div>
        </div>
        <div class="lightbox-padding"></div> 
        <div class="lightbox-footer">
            <div class="lightbox-buttons">
                <input type="button" id="cancel_button" class="large-btn" value="Cancel" my-request-close/>
                <input type="submit" id="send_button" class="large-btn" value="Send" my-request-send/>
            </div>
        </div>
    </div>
</div>
<?=Form::close()?>
