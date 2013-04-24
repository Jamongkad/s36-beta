<!-- start of lightbox request feedback -->
<div id="request-feedback" class="lightbox">
    <div class="lightbox-close" my-request-close></div>
    <div class="lightbox-styles" ng-controller="MainRequestCtrl">
        <h2>Request Feedback</h2>
        <div class="lightbox-content">
            <div ng-include src="template.url"></div>
        </div>
        <div class="lightbox-padding"></div> 
        <div class="lightbox-footer">
            <div class="lightbox-buttons">
                <input type="button" class="large-btn" value="Cancel" my-request-close/>
                <input type="submit" class="large-btn" value="Send" my-request-send/>
            </div>
        </div>
    </div>
</div>
