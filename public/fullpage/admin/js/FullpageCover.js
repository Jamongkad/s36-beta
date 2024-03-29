// requires JqueryFileUpload, Helpers.

var FullpageCover = function(){
    
    var self = this;
    this.cover_photo_action = '';
    this.logo_action = '';
    
    
    
    this.init = function(){
        
        //reposition the company name and title
        self.reposition_company_name_and_rating();
        
        // horizontally and vertically align the logo.
        self.centrally_align_logo();
        
        
        
        // doing these two hovers in css has bug.
        $('#coverPhotoContainer').hover(
            function(){
                if( $('#changeCoverButtonIcon').is('.hidden') ) return;
                $('#changeCoverButtonIcon').show();
            },
            function(){
                $('#changeCoverButtonIcon').hide();
            }
        );
        
        // i'm on the right track baby i was born this way.
        $('#avatarContainer').hover(
            function(){
                $('#avatarButtonIcon').show();
                $('#changeCoverButtonIcon').addClass('hidden');
                $('#changeCoverButtonIcon').hide();
            },
            function(){
                $('#avatarButtonIcon').hide();
                $('#changeCoverButtonIcon').removeClass('hidden');
                $('#changeCoverButtonIcon').show();
            }
        );
        
        
        
        /* ========================================
        || Apply the fileupload plugin for the cover photo
        ==========================================*/
        $('#cv_image').fileupload({
            dropZone: null,
            dataType: 'json',
            dropZone: null,
            add: function(e, data){
                var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
                if( image_types.indexOf( data.files[0].type ) == -1 ){
                    var error = ['Please select an image file'];
                    Helpers.display_error_mes(error);
                    return false;
                }
                if( data.files[0].size > 2000000 ){
                    var error = ['Please upload an image not greater than 2mb in filesize'];
                    Helpers.display_error_mes(error);
                    return false;
                }
                data.submit();
            },progress: function(e, data){
                Helpers.show_notification('Changing Cover Photo',0);
                $('#coverPhotoContainer .cp_loading_img').show();
                $('#coverPhoto img').css('opacity', '0.2');
            },done: function(e, data){
                self.change_cover_image(data.result[0]);
                self.turn_on_cp_edit_mode(true);
                self.make_cover_undraggable(false);
                self.cover_photo_action = 'change';
                Helpers.hide_notification();
                $('#coverPhotoContainer .cp_loading_img').hide();
                $('#coverPhoto img').animate({'opacity': '1'});
                
            }, error: function(jqXHR){
                Helpers.display_error_mes([jqXHR.responseText]);
                Helpers.hide_notification();
                $('#coverPhoto img').css('opacity', '1');
                self.turn_on_cp_edit_mode(false);
            }
        });
        
        
        /* ========================================
        || reposition cover photo.
        ==========================================*/
        $('#coverReposition').click(function(){
            self.turn_on_cp_edit_mode(true);
            self.make_cover_undraggable(false);
            self.cover_photo_action = 'reposition';
        });
        
        
        /* ========================================
        || remove cover photo.
        ==========================================*/
        $('#coverRemove').click(function(){
            $('#coverPhoto img').attr({
                'src': '/img/sample-cover.jpg',
                'style': 'opacity: 1; top: 0px; position: relative;'
            });
            
            self.turn_on_cp_edit_mode(true);
            self.cover_photo_action = 'remove';
        });
        
        
        /* ========================================
        || cancel any cover photo action.
        ==========================================*/
        $('#cancel_cover_photo').click(function(){
            $('#coverPhoto img').attr({
                'src': $('#hidden_cover_photo').attr('src'),
                'style': $('#hidden_cover_photo').attr('style')
            });
            
            self.cover_photo_action = '';
            self.make_cover_undraggable(true);
            self.turn_on_cp_edit_mode(false);
            $('#coverPhoto img').css('opacity', '1');
        });
        
        
        /* ========================================
        || execute the cover photo action.
        ==========================================*/
        $('#save_cover_photo').click(function(){
            $('#hidden_cover_photo').attr({
                'src': $('#coverPhoto img').attr('src'),
                'style': $('#coverPhoto img').attr('style')
            });
            
            self.upload_to_server( self.cover_photo_action );
            self.make_cover_undraggable(true);
            self.turn_on_cp_edit_mode(false);
            $('#coverPhoto img').css('opacity', '1');
            
            if( self.cover_photo_action == 'change' ){
                $('#coverReposition, #coverRemove').show();
            }else if( self.cover_photo_action == 'remove' ){
                $('#coverReposition, #coverRemove').hide();
            }
        });
        
        
        
        /* ========================================
        || Apply the fileupload plugin for the company logo.
        ==========================================*/
        $('#company_logo').fileupload({
            dropZone: null,
            dataType: 'json',
            dropZone: null,
            add: function(e, data){
                var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
                if( image_types.indexOf( data.files[0].type ) == -1 ){
                    var error = ['Please select an image file'];
                    Helpers.display_error_mes(error);
                    return false;
                }
                if( data.files[0].size > 2000000 ){
                    var error = ['Please upload an image not greater than 2mb in filesize'];
                    Helpers.display_error_mes(error);
                    return false;
                }
                data.submit();
            },progress: function(e, data){
                Helpers.show_notification('Changing Profile Picture', 0);
                $('#avatarContainer #logo').css('opacity', '0.2');
                $('#avatarContainer .loading_img').show();
            },done: function(e, data){
                // set the new src for the image. the additional ? or any get param at the end of the src
                // refereshes the displayed image. this is it dan, you bits!
                // we also need the ext from result because they differ from server side.
                var ext = data.result[0].name.split('.').pop();
                var rand_str = '?' + Helpers.get_random_str(5);
                var basename = 'logo_' + $('#company_id').val() + '.' + ext;
                var new_src = '/uploaded_images/uploaded_tmp/main/' + basename + rand_str;
                $('#avatarContainer #logo').attr({
                    'src': new_src,
                    'basename': basename
                }).animate({'opacity': '1'});
                Helpers.hide_notification();
                self.turn_on_logo_edit_mode(true);
                self.logo_action = 'change';
                self.centrally_align_logo();
                $('#avatarContainer .loading_img').hide();
                
            }, error: function(jqXHR){
                Helpers.display_error_mes([jqXHR.responseText]);
                Helpers.hide_notification();
                $('#avatarContainer #logo').css('opacity', '1');
                self.turn_on_logo_edit_mode(false);
            }
        });
        
        /* ========================================
        || remove company logo.
        ==========================================*/
        $('#remove_logo').click(function(){
            $('#avatarContainer #logo').attr('src', '/img/public-profile-pic.jpg');
            self.logo_action = 'remove';
            self.turn_on_logo_edit_mode(true);
        });
        
        
        /* ========================================
        || cancel any company logo action.
        ==========================================*/
        $('#cancel_company_logo').click(function(){
            $('#avatarContainer #logo').attr('src', $('#hidden_company_logo').attr('src'));
            
            self.logo_action = '';
            self.turn_on_logo_edit_mode(false);
        });
        
        
        /* ========================================
        || execute the company logo action.
        ==========================================*/
        $('#save_company_logo').click(function(){
            
            $.ajax({
                async: false,
                url: '/imageprocessing/save_company_logo',
                type: 'post',
                data: {
                    'action' : self.logo_action,
                    'basename': $('#avatarContainer #logo').attr('basename')
                },
                success: function(result){
                    error = result;
                }
            });
            
            if( $.trim(error) != '' ){
                self.turn_on_logo_edit_mode(false);
                Helpers.display_error_mes([error]);
                return false;
            }
            
            $('#hidden_company_logo').attr('src', $('#avatarContainer #logo').attr('src'));
            self.turn_on_logo_edit_mode(false);
            
            if( self.logo_action == 'change' ){
                $('#remove_logo').show();
            }else if( self.logo_action == 'remove' ){
                $('#remove_logo').hide();
            }
            
        });
        
    }
    
    
    
    /* ========================================
    || Cover Image changer
    ==========================================*/
    this.change_cover_image = function(data){
        $('<img />')
            .attr({'basename':data.name,'src':data.url})
            .load(function(e){
                $('#coverPhoto img').attr({'basename':data.name,'src':data.url,width:'100%'}).css('top', '0px');
        }); 
    }
    
    
    
    /* ========================================
    || cover photo edit mode.
    ==========================================*/
    this.turn_on_cp_edit_mode = function(edit_mode){
        if( edit_mode == true ){
            $('#changeCoverButtonIcon').hide();
            $('#coverActionButtons').show();
            // $('.company-rating').hide();
            // $('.cover-shadow').hide();
        }else if( edit_mode == false ){
            $('#changeCoverButtonIcon').show();
            $('#coverActionButtons').hide();
            // $('.company-rating').show();
            // $('.cover-shadow').show();
        }
    }
    
    
    
    /* ========================================
    || Make the cover undraggable by passing a true paramater
    ==========================================*/
    this.make_cover_undraggable = function(opt){
        if(opt == false){
            // we put a short delay here so we can get the actual size of the newly set image.
            // what happens before is when you uploaded a new image, the size of the previous image
            // is what being retrieved that causes problem in length of drag area.
            // and also the load() doesn't work in repostion.
            setTimeout( function(){
                $('#dragPhoto').fadeIn('fast');
                var offset = $("#coverPhoto img").parent().offset();
                var offsetX = offset.left;
                $("#coverPhoto img").each(function(){
                    var imgW = $(this).width();
                    var imgH = $(this).height();
                    var parW = $(this).parent().width();  
                    var parH = $(this).parent().height();
                    var ipW = imgW-parW-offsetX;
                    var ipH = imgH-parH;
                    var y1 = offset.top - (imgH - parH);
                    var y2 = offset.top;
                    //$(this).draggable({ containment: [-ipW, -ipH, offsetX, 0], scroll: false, disabled: opt});
                    $(this).draggable({ containment: [-ipW, y1, offsetX, y2], scroll: false, disabled: opt});
                });
            }, 800);
            
        }else{
            $('#dragPhoto').fadeOut();
            $("#coverPhoto img").draggable({disabled: true});
        }
    }
    
    
    
    /* ========================================
    || Upload to server function you do this shit roberto
    ==========================================*/
    this.upload_to_server = function(action){
        /* pass the variables from here to the database then initialize the codes below if upload to db is successful */
        var error;
        $.ajax({
            async: false,
            url: '/imageprocessing/savecoverphoto',
            type: 'post',
            data: {
                'name': $('#coverPhoto img').attr('basename'), 
                'top': $('#coverPhoto img').css('top'),
                'action': action
            },
            success: function(result){
                error = result;
            }
        });
        
        if( $.trim(error) != '' ){
            Helpers.display_error_mes([error]);
            return false;
        }
    }
    
    
    
    /* ========================================
    || logo edit mode.
    ==========================================*/
    this.turn_on_logo_edit_mode = function(edit_mode){
        if( edit_mode == true ){
            $('#avatarButtonIcon').hide();
            $('#logoActionButtons').show();
        }else if( edit_mode == false ){
            $('#avatarButtonIcon').show();
            $('#logoActionButtons').hide();
        }
    }
    
    
    
    /* ========================================
    || This function will adjust the company name according to the width of the avatar
    ==========================================*/
    this.reposition_company_name_and_rating = function(){
        $('#avatarContainer').find('img').load(function(){
            var $wd = $(this).width() + 40;
            $('#coverPhotoContainer').find('.company-rating').css('left',$wd+'px');
        });
    }
    
    
    
    this.centrally_align_logo = function(){
        $('#avatarContainer #logo').load(function(){
                    
            var img_w = $(this).width();
            var img_h = $(this).height();
            $(this).removeAttr('width').removeAttr('height').removeAttr('style');
            
            if( img_w > img_h ){
                
                $(this).attr('height','150px');
                $(this).css({
                    'left' : '50%',
                    'margin-left' : -( ((img_w / img_h) * 150) / 2) + 'px'
                });
                
            }else if(img_w < img_h){
                
                $(this).attr('width','150px');
                $(this).css({
                    'top' : '50%',
                    'margin-top' : -( ((img_h / img_w) * 150) / 2) + 'px'
                });
                
            }else{
                
                $(this).attr('width','150px');
                $(this).attr('height','150px');
                
            }
            
        });
    }
    
}