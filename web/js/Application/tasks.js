var addTaskForm = document.getElementById("add_tasks");
    
addTaskForm.addEventListener('submit', function(e){
    e.preventDefault();
    description = this.description.value;
    points = this.points.value;

    if(validateNewTask()){
        addTask(description, points);
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

function addTask(description, points){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/addTask",
        data: {description: description, points: points},
        success: function(response) {
            addTaskForm.reset();
            $("#tableTasks tr:last").after("<tr id='tasks-tr-"+ response.task_id + "'><td>" + description + "</td>\n\
                <td>" + points + "</td><td class='td-actions text-right'>\n\
                <button type='button' onclick='completeTask(" + response.task_id + ");' rel='tooltip' title='Complete Task' class='btn btn-success btn-simple btn-xs'>\n\
                <i class='fa fa-check' aria-hidden='true'></i></button>\n\
                <button type='button' onclick='deleteTask(" + response.task_id + ");' rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-xs'>\n\
                <i class='fa fa-times'></i></button></td></tr>");
        },
        error: function(){
            title   = "Something went wrong.";
            body    = "AJAX error.";

            showAlert(title, body);
        }
    });
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