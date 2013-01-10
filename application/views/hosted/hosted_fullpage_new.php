<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::style('css/override.css'); ?>
<script type="text/javascript">
$(document).ready(function(){

    $('.adminReply').click(function(){
        var parent = $(this).parents('.admin-comment-block');
        $.ajax({
            url: "/admin_reply",
            dataType: "json",
            data: {
                feedbackId: $(parent).find('.admin-comment-id').val(),
                adminReply: $(parent).find('.admin-comment-textbox').val()
            },
            type: "POST",
            success: function(result) {
                if(undefined != result.feedbackid){
                    $(parent).find('.admin-comment .admin-message .message').html(result.adminreply);
                    $(parent).find('.admin-comment-box').css('display','none');
                    $(parent).find('.admin-comment').css('display','block');
                }
          }
        });
    });


});
</script>
<script type="text/javascript">
    
    // general functions.
    
    // convert \n to br tags.
    function nl2br(s){
        return s.replace(/\n/g,'<br>');
    }
    
    // convert br tags to \n.
    function br2nl(s){
        return s.replace(/<br ?\/?>/g,'\n');
    }
    
    // convert html to entities.
    function html2entities(s){
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
    
    // convert entities to html.
    function entities2html(s){
        return s.replace(/&amp;/g,'&').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
    }
    
    
    
    $(document).ready(function(){
        
        // start of jquery raty.
        
        $('.star_rating').raty({
            hints: ['BAD', 'POOR', 'AVERAGE', 'GOOD', 'EXCELLENT'],
            score: function(){
                return $(this).attr('rating');
            },
            path: '/img/',
            starOn: 'star-fill.png',
            starOff: 'star-empty.jpg',
            readOnly: true
        });
        
        // end of jquery raty. 
        
        
        
        // start of description ajax edit.
        
        $('.company-text').hover(
            function(){
                if( $('#desc_textbox_con').css('display') != 'block' ){
                    $('.edit').css('display', 'inline-block');
                }
            },
            function(){
                $('.edit').css('display', 'none');
            }
        );
        
        $('.edit').click(function(){
            $('.edit').css('display', 'none');
            $('.save, .cancel').css('display', 'inline-block');
            $('#desc_text').css('display', 'none');
            $('#desc_textbox_con').css('display', 'block');
        });
        
        $('.cancel').click(function(){
            $('.edit').css('display', 'none');
            $('.save, .cancel').css('display', 'none');
            $('#desc_textbox_con').css('display', 'none');
            $('#desc_text').fadeIn();
            $('#desc_textbox').val( entities2html( br2nl($('#desc_text').html().replace(/\n/g,'')) ) );
        });
        
        $('.save').click(function(){
            
            var data = {};
            data['description'] = $('#desc_textbox').val();
            
            $.ajax({
                url: '/update_desc',
                type: 'post',
                data: data,
                success: function(result){
                    // if result returned 1, it means he's not logged in.
                    if( result == 1 ){
                        alert('You should be logged in to do this action');
                    }else{
                        $('#desc_text').html( nl2br( html2entities($('#desc_textbox').val()) ) );
                        $('.cancel').trigger('click');
                    }
                }
            });
            
        });
        
        // end of description ajax edit.
        
    });
    
</script>

<div id="mainWrapper">
	<div id="fadedContainer">
    	<div id="mainContainer">
            <div id="coverPhotoContainer">
                <div id="coverPhoto">
                    <img src="img/sample-cover.jpg" />
                </div>
            </div>
           
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text">
                        <div id="desc_text"><?= nl2br( HTML::entities($company->description) ); ?></div>
                        <?php if( ! is_null($user) ): ?>
                            <div id="desc_textbox_con">
                                <textarea id="desc_textbox" rows="3"><?=$company->description?></textarea>
                            </div>
                            <div id="action_buttons">
                                <div class="edit action_button" title="Edit"></div>
                                <div class="save action_button" title="Save"></div>
                                <div class="cancel action_button" title="Cancel"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="send-button"><a href="javascript:;">Send in feedback</a></div>
                </div>
            </div>
            
            <div class="hosted-block">
                <div class="company-reviews clear">
                    <div class="company-recommendation">
                        <div class="green-thumb">
                            <?php echo round(($company->total_recommendations / $company->total_feedback) * 100); ?>% 
                            of our customers recommend us to their friends.
                        </div>
                    </div>
                    <div class="company-rating">
                        <div class="review-count">Based on <?php echo $company->total_feedback; ?> reviews</div>
                        <div class="stars blue clear"><div class="star_rating" rating="<?php echo round($company->avg_rating); ?>"></div></div>
                        <div class="stars blue clear">
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star half"></div>    
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="feedbackContainer">
                <div id="timelineLayout">
                    <?=View::make('hosted/partials/hosted_feedback_partial_view', Array('collection' => $feeds))?>
                </div>
            </div>
</div>
</div>
</div>
