var addCategoryForm = document.getElementById("add_category_form");
var categoryName = document.getElementById("categoryName").value;
var value = document.getElementById("categoryDropDown").value;
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
    console.log(document.getElementById("categoryDropDown").value);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/deleteCategory",
        data: {id: value},
        success: function(response) {
            alert("This Works");
        }
        /*error: function(){
            popup("Ajax Error - Refresh and try again.");
        }*/
    });

};
