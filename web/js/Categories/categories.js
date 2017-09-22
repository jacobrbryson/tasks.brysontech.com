var addCategoryForm = document.getElementById("add_category_form");
var addCatgoryBtn = document.getElementById("add_category_btn");

addCategoryBtn.addEventListener('click', function(e){
    e.preventDefault();
    //$("#modal_add_task").modal();
    //$("#start_date_time").val(Math.round(new Date().getTime()/1000.0));
    //$("#end_date_time").val(Math.round(new Date().getTime()/1000.0) + 86400);
});

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
        data: {data: $data},
        success: function(response) {
           popup("New Category Added");;
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
