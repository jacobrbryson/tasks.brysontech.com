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
        $('#category').append($('<option>', {value:categories[i].id, text:categories[i].name}));
    }
}

function completeTask(taskid){
    $("#tasks-tr-" + taskid).remove();
    $("#tasks-tr-m-" + taskid).remove();
    
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/completeTask",
        data: {task_id: taskid},
        success: function(response) {
            popup(response.message);
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function deleteTask(taskid){
    var category_id = $("#tasks-tr-" + taskid).parent().parent().attr("id").replace('table_tasks_', '');
    
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/deleteTask",
        data: {task_id: taskid},
        success: function(response) {
            $("#tasks-tr-" + taskid).remove();
            $("#tasks-tr-m-" + taskid).remove();
            updateTab(category_id, -1);
            
            popup(response.message);
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function updateTab(category_id, value){
    var shownValue = parseInt($("#tasks_category_id_" + category_id).html());
    var newValue = shownValue + value;
    
    if(newValue > 0){
        $("#tasks_category_id_" + category_id).html(newValue);
    }else{
        $("#category_tab_" + category_id).remove();
    }
}

var addTaskForm = document.getElementById("form_add_task");
var addTaskBtn = document.getElementById("btn_add_task");
    
addTaskBtn.addEventListener('click', function(e){
    e.preventDefault();
    $("#modal_add_task").modal();
    $("#start_date_time").val(Math.round(new Date().getTime()/1000.0));
    $("#end_date_time").val(Math.round(new Date().getTime()/1000.0) + 86400);
});
    
addTaskForm.addEventListener('submit', function(e){
    e.preventDefault();
    description = this.description.value;
    
    if ($("#start_time").val() !== ''){
        $("#start_date_time").val(Math.round(new Date($("#start_time").val())/1000.0));
    }
    
    if($("#end_time").val() !== ''){
        $("#end_date_time").val(Math.round(new Date($("#end_time").val())/1000.0));
    }

    addTask();
});

function addTask(){
    var category_id = $("#form_add_task")
                .find("#category").val()
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/add",
        data: {data: $("#form_add_task").serialize()},
        success: function(response) {
            $("#form_add_task")[0].reset();
            $("#modal_add_task").modal('toggle');
            if($("#table_tasks_" + category_id).length){
                $("#table_tasks_" + category_id)
                    .append("<tr id='tasks-tr-" + response.task_id + "'><td>" + 
                    description + "</td><td class='text-center'>0</td><td class='td-actions text-right'><div class='hidden-lg-up text-center'><button type='button'  data-toggle='collapse' data-target='.task-" + 
                    response.task_id + "' class='btn btn-secondary btn-simple btn-sm btn-tasks'><i class='fa fa-plus-circle' aria-hidden='true'></i></button></div><div class='hidden-md-down'><button type='button' onclick='editTask(" + 
                    response.task_id + ");'rel='tooltip' title='Edit' class='btn btn-info btn-simple btn-sm btn-tasks'><i class='fa fa-pencil' aria-hidden='true'></i></button>&nbsp;<button type='button' onclick='completeTask(" + 
                    response.task_id + ");'rel='tooltip' title='Complete' class='btn btn-success btn-simple btn-sm btn-tasks'><i class='fa fa-check' aria-hidden='true'></i></button>&nbsp;<button type='button' onclick='deleteTask(" + 
                    response.task_id + ");'rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-sm btn-tasks'><i class='fa fa-times'></i></button></div></td></tr><tr id='tasks-tr-m-" + 
                    response.task_id +"' class='hidden-lg-up'><td colspan='3' style='border-top:none'><div class='navbar-collapse collapse task-" + 
                    response.task_id + "'><ul class='navbar-nav ml-auto'><li class='nav-item'><button type='button' onclick='editTask(" + 
                    response.task_id + ");'rel='tooltip' title='Edit' class='btn btn-info btn-simple btn-block'><i class='fa fa-pencil' aria-hidden='true'></i>Edit</button></li><li class='nav-item' style='padding-top:10px'><button type='button' onclick='completeTask(" + 
                    response.task_id + ");'rel='tooltip' title='Complete' class='btn btn-success btn-simple btn-block'><i class='fa fa-check' aria-hidden='true'></i>Complete</button></li><li class='nav-item' style='padding-top:10px'><button type='button' onclick='deleteTask(" + 
                    response.task_id + ");'rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-block'><i class='fa fa-times'></i>Delete</button></li></ul></div></td></tr>");
                popup("New Task Added");
                updateTab(category_id, 1);
            }else{
                location.reload();
            }
            
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

$(function () {
    var time = new Date().getTime() + 60 * 60 * 24 * 1000;
    
    $('#datetimepicker6').datetimepicker({
        date: new Date()
    });
    $('#datetimepicker7').datetimepicker({
        date: new Date(time)
    });
    $('#datetimepicker1').datetimepicker({
        date: new Date(time)
    });
    $("#datetimepicker6").on("dp.change", function (e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker7").on("dp.change", function (e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });
});
