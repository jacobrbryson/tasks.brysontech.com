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