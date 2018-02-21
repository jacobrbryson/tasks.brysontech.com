// **********************
//*    Event Handlers    *
// **********************
$(document).ready(function() {
    getCategories();
});

$("#form_categories_add").on("submit", function(e){
    e.preventDefault();
    
    addCategory($('#category_name').val());
});

$("#form_categories_update").on("submit", function(e){
    e.preventDefault();
    
    updateCategory($('#select_category_update').val());
});

$("#form_categories_update").on("submit", function(e){
   e.preventDefault();
   
   deleteCategory($('#select_category_delete').val());
});

// **********************
//*      Ajax calls      *
// ********************** 
function getCategories(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/categories/get",
        success: function(response) {
            populateCategories(response.data);
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function addCategory(name){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/categories/add",
        data:{name:name},
        success: function(response) {
            
            //expects the new category to be returned and adds it to the select boxes
            populateCategories(response.data);
            
            //Display at the bottom of the screen that the category has been added
            popup(response.data[0].name + " added.");
            
            //Clear the add category form
            $("#form_categories_add")[0].reset();
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function updateCategory(){
        var id=$('#form_categories_update').find("#select_category_update").val();
        var new_name = $("#form_categories_update").find("#new_name").val();
         $.ajax({
             type:"POST",
             url:"/application/categories/update",
             data: {id:id, new_name:new_name},
             success: function(response){
                 
                 //removes the pre-update category
                 $("#form_categories_update").find("option:selected").text(new_name);

                popup(response.new_name + " updated.");
             }
        });
         
}

function deleteCategory(){
    var id=$('form_categories_delete').find('#select_category_delete').val();
    console.log(id);
    $.ajax({
        type:"POST",
        url:"/application/categories/delete",
        data: {id:id},
        success: function(response){
         //removes the selected category
         $("#form_categories_update option:selected").remove();
        }
    });
}

// **********************
//*      Utilities       *
// ********************** 
function populateCategories(categories){
    for(i=0;i<categories.length;i++){
        $('#select_category_delete').append($('<option>', {value:categories[i].id, text:categories[i].name}));
        $('#select_category_update').append($('<option>', {value:categories[i].id, text:categories[i].name}));
    }
}

