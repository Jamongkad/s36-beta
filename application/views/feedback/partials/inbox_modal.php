<div class="checky-box-container" ng-controller="CheckyBox" style="display:none">
    <div class="j-j5-ji">
        <div class="checky-bar">
            <span ng-switch on="status_selection"> 
                <span ng-switch-when="flag">
                    Feedback has been flagged.
                    <a close class="close-checky" href="#" ng-click="hide()">hide</a>
                </span> 
                <span ng-switch-when="unflag">
                    Feedback has been unflagged.
                    <a close class="close-checky" href="#" ng-click="hide()">hide</a>
                </span> 
                <span ng-switch-when="feature">
                    Feedback has been featured on your page. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="publish">
                    Feedback has been published on your page. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="fileas">
                    Feedback has been filed.
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="delete">
                    Feedback has been deleted. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="restore">
                    Feedback has been restored. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="remove">
                    Feedback has been permanently removed. 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="inbox">
                    Feedback has been returned to the inbox.
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
            </span>
        </div>
    </div>
</div>
