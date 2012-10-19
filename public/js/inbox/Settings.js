jQuery(function($) {
    CategoryControl();
    $('a.add-new-ctgy').bind("click", function(e) {
        var ctgy_nm = $("input[name='category_nm']");
        var ctgy_list = $("#ctgy-list");
        
        if(ctgy_nm.val() == false) 
            alert("Category Name cannot be blank.");           
        else 
            $.ajax({
                url: ctgy_list.attr('hrefaction')
              , type: "POST" 
              , data: {ctgy_nm: ctgy_nm.val(), companyId: $("input[name='companyid']").val()}
              , success: function(msg) {
                  ctgy_list.append(msg);
                  ctgy_nm.val("");
                  CategoryControl();
              }
            }); 
       
        e.preventDefault();
    })

    function CategoryControl() {
       $('a.rename-ctgy, a.delete-ctgy').unbind('click.ctgy-controls').bind('click.ctgy-controls', function(e) {
           var class_name = $(this).attr('class');
           var that = $(this);

           if(class_name == 'rename-ctgy') {
               var input = $('<input type="text" name="ctgy_nm"/>').val(
                   that.parents('div').siblings('div').children('.ctgy-name').html()
               );

              if(that.text() == "Update") {
                  var ctgy_nm_val = $('input[name="ctgy_nm"]').val()
                  that.text("Rename") 
                        .parents('div')
                        .siblings('div')
                        .children('.ctgy-name')
                        .html( ctgy_nm_val ).end().end().end()
                  $.ajax({ url: that.attr('href'), type: "POST", data: {ctgy_nm: ctgy_nm_val} });
              } else {
                  that.text("Update")     
                        .parents('div')
                        .siblings('div')
                        .children('.ctgy-name')
                        .html( input ).end().end().end()
              }
              
           }

           if(class_name == 'delete-ctgy') {
              var d = that.parents('div.grids');
              if(confirm("Are you sure you want to delete this category? There is no undo.")) {
                  $.ajax({ url: $(this).attr('href'), success: function(msg) { d.fadeOut(); } });
              }
           }

           e.preventDefault();
       })
    }    
})
