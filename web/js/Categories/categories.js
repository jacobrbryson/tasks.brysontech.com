var addCategoryForm = document.getElementById("add_category_form");

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
        data: {name: document.getElementById("name").value},
        success: function(response) {
           alert("New Category Added");
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
