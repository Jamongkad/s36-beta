<div class="lightbox-form">
    <div class="modal-configure">  
        <h4>Configure Message</h4>
        <textarea class="regular-text" style="width: 692px; height: 140px" name="msg">
<?=($msg) ? $msg->text : Null ?>
        </textarea><br/>
        <input type="hidden" name="msgid" value="<?=($msg) ? $msg->id : Null?>" id="msgid" ng-model="data.msgid"/>
        <input type="hidden" name="msgtype" value="msg" id="msgtype"/>
        <!--
        <div class="add-msg-box-buttons">
            <input type="button" class="small-btn" value="Cancel" cancel-request-add/>
            <input type="submit" class="small-btn" value="" exec-item/>
        </div>
        -->
    </div>
</div>
