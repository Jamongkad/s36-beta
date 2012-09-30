jQuery(function($) {
    $('select[name="date-filter"]').bind('change', function(e) {
        if(($(this).val() == 'default')) {
            window.location = window.location.pathname;
        } else { 
            insertParam('date', $(this).val());     
        }
       
    });

    $('select[name="priority-filter"]').bind('change', function(e) {
        if(($(this).val() == 'default')) {
            window.location = window.location.pathname;
        } else {
            insertParam('priority', $(this).val());     
        } 
    });

    $('select[name="status-filter"]').bind('change', function(e) {

        if(($(this).val() == 'default')) {
            window.location = window.location.pathname;
        } else { 
            insertParam('status', $(this).val());
        } 

    });

    $('select[name="rating-limit"]').bind('change', function(e) {

        if(($(this).val() == 'default')) {
            window.location = window.location.pathname;
        } else { 
            insertParam('rating', $(this).val());
        } 

    });

    $('select[name="feedback-limit"]').bind('change', function(e) {

        if(($(this).val() == 'default')) {
            window.location = window.location.pathname;
        } else { 
            insertParam('limit', $(this).val());
        } 

    });


    $('select[name="category-filter"]').bind('change', function(e) {

        if(($(this).val() == 'default')) {
            window.location = window.location.pathname;
        } else {
            insertParam('category', $(this).val());
        } 
        
    });

    $('select[name="site_choice"]').bind('change', function(e) {
        var select = $(this).val();
        window.location = (select == 'all') ? "all" : "?site_id=" + $(this).val();
    });

})

//for dynamic GET parameters
function insertParam(key, value) {
    key = escape(key); value = escape(value);

    var kvp = document.location.search.substr(1).split('&');
    if (kvp == '') {
        document.location.search = '?' + key + '=' + value;
    } else { 
        var i=kvp.length; 
        var x; 
        while(i--) {
            x = kvp[i].split('=');

            if (x[0]==key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i<0) {
            kvp[kvp.length] = [key,value].join('=');
        }
        //this will reload the page, it's likely better to store this until finished
        document.location.search = kvp.join('&'); 
    }

}
