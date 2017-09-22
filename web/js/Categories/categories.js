var addCategoryForm = document.getElementById("add_category_form");
var categoryName = document.getElementById("name").value;
addCategoryForm.addEventListener('submit', function(e){
    e.preventDefault();
    addCategory();
});

function addCategory(){
    $data = $("#add_category_form").serialize();
    
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/addCategory",
        data: {name: categoryName},
        success: function(categoryName) {
           alert("Category " + categoryName + " has been added");
        }
        /*error: function(){
            popup("Ajax Error - Refresh and try again.");
        }*/
    });

};

function deleteCategory(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/deleteCategory",
        data: {name: "Name of Category"},
        success: function(response) {
            alert("This Works");
        }
        /*error: function(){
            popup("Ajax Error - Refresh and try again.");
        }*/
    });

};
