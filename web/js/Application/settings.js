//runs on JS load and put the current categories in the select boxes.
getCategories();
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

function populateCategories(categories){
    for(i=0;i<categories.length;i++){
        $('#select_category_delete').append($('<option>', {value:categories[i].id, text:categories[i].name}));
        $('#select_category_update').append($('<option>', {value:categories[i].id, text:categories[i].name}));
    }
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
            $("#form_categories")[0].reset();
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

$("#form_categories").on("submit", function(e){
    e.preventDefault();
    
    addCategory($('#category_name').val());
});

function updateCategory(id, name){
         $.ajax({
             type:"POST",
             url:"/application/categories/update",
             data: {id:id, new_name:name},
             success: function(response){
                 
                 //removes the pre-update category
                 $("#form_categories_update option:selected").remove();
            
                //expects the new category to be returned and adds it to the select boxes     
                populateCategories(response.data);

                //Display at the bottom of the screen that the category has been updated
                popup(response.data[0].name + " updated.");

                //Clear the update category form
                $("#form_categories_update")[0].reset();
             }
        });
         
}