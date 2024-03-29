angular.module('FormDirectives', ['FormServices'])
.directive('stars', function(Data) { 
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
          $(element).children('div').hover(function() { 
                var index = $(this).index() + 1;
                $('.star-container .star').css('background-position','bottom');
                $(this).css('background-position','top');
                rating = convert_rating_to_text(index);
                $('.star-text').html(rating);
                for(var i = 0;i<index;i++){
                    $(this).parent().find('.star:eq('+i+')').css('background-position','top');
                }
          }, function() {
                var current_rating = Data.rating;

                var rating = convert_rating_to_text(current_rating);
                $('.star-text').html(rating);

                $('.star-container .star').css('background-position','bottom');
                for(var i = 0;i<current_rating;i++){
                    $('.star-container').find('.star:eq('+i+')').css('background-position','top');
                }
              
          }).bind('click', function() {
                Data.rating = $(this).index() + 1;
          });
          /*
            $('.dynamic-stars .star-container .star').hover(function(){
                var index = $(this).index();
                var rating = "";
                $('.star-container .star').css('background-position','bottom');
                $(this).css('background-position','top');
                rating = convert_rating_to_text(index);
                $('.star-text span').html(rating);
                for(var i = 0;i<index;i++){
                    $(this).parent().find('.star:eq('+i+')').css('background-position','top');
                }
                
            },function(){
                var current_rating = $('#rating').val();
                var rating = convert_rating_to_text(current_rating - 1);
                $('.star-text span').html(rating);
                $('.star-container .star').css('background-position','bottom');
                for(var i = 0;i<current_rating;i++){
                    $('.star-container').find('.star:eq('+i+')').css('background-position','top');
                }
            }).click(function(){
                // send the rating value to the rating plugin
                var index = $(this).index() + 1;
                $('#rating').val(index);
            });
            */
          
        }
    }
});

function convert_rating_to_text(val){
    var rating;
    switch(val){
        case 5: rating = "Excellent!";
        break;
        case 4: rating = "Good";
        break;
        case 3: rating = "Average";
        break;
        case 2: rating = "Poor";
        break;
        case 1: rating = "Bad";
        break;
        default: rating = "";
        break;
    }
    return rating;
}
