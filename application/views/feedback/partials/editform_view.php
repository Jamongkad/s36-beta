<div class="lightbox-form">
    <div class="modal-configure">  
        <h4>Configure Message</h4>
        <textarea class="regular-text" style="width: 692px; height: 140px" ng-model="tmplvar.text">
<?//=($msg) ? $msg->text : Null ?>
        </textarea><br/>
        <!--<input type="hidden" ng-model="messages.msgid" ng-init="messages.msgid='<?//=($msg) ? $msg->id : Null?>'"/>-->
        <input type="hidden" ng-model="tmplvar.msgid"/>
        <input type="hidden" name="msgtype" value="msg" id="msgtype"/>
        <!--
        <div class="add-msg-box-buttons">
            <input type="button" class="small-btn" value="Cancel" cancel-request-add/>
            <input type="submit" class="small-btn" value="" exec-item/>
        </div>
        -->
    </div>
</div>
