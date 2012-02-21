<?php header("Content-type: application/x-javascript; charset=UTF-8"); ?>

<?if($widgettype == 'display'):?>
function WidgetLoader() {
    this.generateFrameMarkup = function() {
        var frameUrl = '<?=$deploy_url?>/widget/widget_loader/<?=$widgetkey?>';
        var src = '<span style="z-index:100001"><iframe id="s36Widget" allowTransparency="true" height="<?=$height?>" width="<?=$width?>"frameborder="0" scrolling="no" style="width:100%;border:none;overflow:visible;" src="'+frameUrl+'">Insomnia wooohooooh</iframe></span>';
        return src;    
    },

    this.display = function() {  
        document.write(this.generateFrameMarkup());
    }
}
<?endif?>

<?if($widgettype == 'submit'):?>
function s36Tab(){
	this.type = '<?=$tab_type?>', //br,tr,tl,tr,r,l
	this.position = '<?=$tab_pos?>', // sidetab or cornertab	
	this.generateTab= function(){
        var src = '<link type="text/css" href="<?=$deploy_url?>/css/widget_master/tab-positions.css" rel="stylesheet" />'+
				  '<div id="s36LeaveFeedback" onclick="s36_openForm(\'<?=$deploy_url?>/widget/widget_loader/<?=$widgetkey?>\')" class="tab-'+this.position+'tab '+this.type+'"></div>';				
        return src;
	},
	this.display = function () {
        document.write(this.generateTab());
    }	
}
<?endif?>
