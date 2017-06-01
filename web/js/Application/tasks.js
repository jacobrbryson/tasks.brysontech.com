var addTaskForm = document.getElementById("form_add_task");
var addTaskBtn = document.getElementById("btn_add_task");

addTaskBtn.addEventListener('click', function(e){
    e.preventDefault();
    
    $("#modal_add_task").modal();
});
    
addTaskForm.addEventListener('submit', function(e){
    e.preventDefault();
    description = this.description.value;
    points = this.points.value;

    if(validateNewTask()){
        addTaskBasic(description, points);
    } else {
        alert("Invalid task");
    }
    
});

function validateNewTask(description, points){
    isNumber = !isNaN(points);

    if(description === ""){
        return false;
    }

    return true;
}

function addTaskBasic(description, points){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/addTask",
        data: {description: description, points: points},
        success: function(response) {
            addTaskForm.reset();
            $("#tableTasks tr:last").after("<tr id='tasks-tr-" + response.task_id + "'><td>" + description + "</td><td class='text-center'>" + points + "</td><td class='td-actions text-right'><div class='hidden-lg-up text-center'><button type='button'  data-toggle='collapse' data-target='.task-" + response.task_id + "' class='btn btn-secondary btn-simple btn-sm btn-tasks'><i class='fa fa-plus-circle' aria-hidden='true'></i></button></div><div class='hidden-md-down'><button type='button' onclick='editTask(" + response.task_id + ");'rel='tooltip' title='Edit' class='btn btn-info btn-simple btn-sm btn-tasks'><i class='fa fa-pencil' aria-hidden='true'></i></button>&nbsp;<button type='button' onclick='completeTask(" + response.task_id + ");'rel='tooltip' title='Complete' class='btn btn-success btn-simple btn-sm btn-tasks'><i class='fa fa-check' aria-hidden='true'></i></button>&nbsp;<button type='button' onclick='deleteTask(" + response.task_id + ");'rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-sm btn-tasks'><i class='fa fa-times'></i></button></div></td></tr><tr class='hidden-lg-up'><td colspan='3' style='border-top:none'><div class='navbar-collapse collapse task-" + response.task_id + "'><ul class='navbar-nav ml-auto'><li class='nav-item'><button type='button' onclick='editTask(" + response.task_id + ");'rel='tooltip' title='Edit' class='btn btn-info btn-simple btn-block'><i class='fa fa-pencil' aria-hidden='true'></i>Edit</button></li><li class='nav-item' style='padding-top:10px'><button type='button' onclick='completeTask(" + response.task_id + ");'rel='tooltip' title='Complete' class='btn btn-success btn-simple btn-block'><i class='fa fa-check' aria-hidden='true'></i>Complete</button></li><li class='nav-item' style='padding-top:10px'><button type='button' onclick='deleteTask(" + response.task_id + ");'rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-block'><i class='fa fa-times'></i>Delete</button></li></ul></div></td></tr>");
            $("#modal_add_task").modal('toggle');
        },
        error: function(){
            title   = "Something went wrong.";
            body    = "AJAX error.";

            showAlert(title, body);
        }
    });
}

function editTask(taskid){
    //get task information
    
    //show task information in the modal
}

function submitTaskEdits(data){
    //serialize data
    
    //pass it over via ajax to the controller, let her do her job.
}

function completeTask(taskid){
    console.log("Complete TaskId: " + taskid);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/completeTask",
        data: {task_id: taskid},
        success: function(response) {
            if(response.result){
                $("#tasks-tr-" + taskid).remove();
                $("#tasks-tr-m-" + taskid).remove();
                alert(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function(){
            title   = "Something went wrong.";
            body    = "AJAX error.";

            showAlert(title, body);
        }
    });
}

function deleteTask(taskid){
    console.log("Delete TaskId: " + taskid);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/deleteTask",
        data: {task_id: taskid},
        success: function(response) {
            if(response.result){
                $("#tasks-tr-" + taskid).remove();
                $("#tasks-tr-m-" + taskid).remove();
                alert(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function(){
            title   = "Something went wrong.";
            body    = "AJAX error.";

            showAlert(title, body);
        }
    });
}