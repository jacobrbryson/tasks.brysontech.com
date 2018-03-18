// **********************
//*    Event Handlers    *
// **********************
$(document).ready(function() {
    getCategories();
    getStats();
});

$("#form_categories_add").on("submit", function(e){
    e.preventDefault();
    
    addCategory($('#category_name').val());
});

$("#form_categories_update").on("submit", function(e){
    e.preventDefault();
    
    updateCategory($('#select_category_update').val());
});

$("#form_categories_delete").on("submit", function(e){
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

function getStats(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/stats/completedByCategory",
        success: function(response) {
            //console.log(response);
            var total   = [];
            var name    = [];
            for(i=0;i<response.length;i++){
                total.push(response[i].total);
                name.push(response[i].Name);
            }
            var ctx = document.getElementById("stats");
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: name,
        datasets: [{
            label: 'Weekly Tasks',
            data: total,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    }
});
            console.log(name);
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
            if(response){
                //add new category to select boxes
                $('#select_category_delete').append($('<option>', {value:response, text:name}));
                $('#select_category_update').append($('<option>', {value:response, text:name}));

                //alert the user it has been done
                popup(name + " added.");

                //clear out the add category form
                $("#form_categories_add")[0].reset();
            }else{
                popup("Failed to add " + name);
            }
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function updateCategory(){
    var id=$('#form_categories_update').find("#select_category_update").val();
    var new_name = $("#form_categories_update").find("#new_name").val();
    var old_name = $("#form_categories_update").find("option:selected").text();
    $.ajax({
        type:"POST",
        url:"/application/categories/update",
        data: {id:id, new_name:new_name},
        success: function(response){
            if(response){
                //changes the selected category in the select boxes
                $("#form_categories_update").find("option:selected").text(new_name);
                $("#form_categories_delete option[value=" + id + "]").text(new_name);

                //clears out the update category form
                $("#form_categories_update")[0].reset();

                popup("Updated category: " + old_name + " to " + new_name);
            }else{
                popup("Failed to update category " + old_name);
            }
        }
    });
}

function deleteCategory(){
    var id=$('#form_categories_delete').find('#select_category_delete').val();
    var old_name = $("#form_categories_delete").find("option:selected").text();
    $.ajax({
        type:"POST",
        url:"/application/categories/delete",
        data: {id:id},
        success: function(response){
            if(response){
                //removes the selected category from delete select box
                $("#form_categories_delete option:selected").remove();
                
                //removes the selected category from the update select box
                $("#form_categories_update option[value=" + id + "]").remove();

                popup("Deleted " + old_name);
            }else{
                popup("Failed to delete " + old_name);
            }
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

