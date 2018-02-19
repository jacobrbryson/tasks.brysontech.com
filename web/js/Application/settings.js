getCategories();
function getCategories(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/getCategories",
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
        $('#select_category').append($('<option>', {value:categories[i].id, text:categories[i].name}));
    }
}

function addCategory(name){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/addCategory",
        data:{name:name},
        success: function(response) {
            populateCategories(response.data);
            popup(response.data[0].name + " added.");
            $("#form_categories")[0].reset();
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function deleteCategory(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/addCategories",
        success: function(response) {
            populateCategories(response.data);
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