// share.

$('.share-button').click(function(){
    $(this).find('.share-box').fadeToggle('fast');
});

$('.share-box').hover(function(){},function(){
    $(this).fadeOut('fast');
});


// jquery raty.

$('.star_rating').raty({
    hints: ['BAD', 'POOR', 'AVERAGE', 'GOOD', 'EXCELLENT'],
    score: function(){
        return $(this).attr('rating');
    },
    path: '/img/',
    starOn: 'star-fill.png',
    starOff: 'star-empty.png',
    readOnly: true
});



// description ajax edit.

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
    $('#desc_textbox').val( Helpers.entities2html( Helpers.br2nl($('#desc_text').html().replace(/\n/g,'')) ) );
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
                display_error_mes( ['You should be logged in to do this action'] );
            }else{
                $('#desc_text').html( Helpers.nl2br( Helpers.html2entities($('#desc_textbox').val()) ) );
                $('.cancel').trigger('click');
            }
        }
    });
    
});
