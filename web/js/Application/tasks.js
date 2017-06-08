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
                //alert(response.message);
                taskComp(response.message);
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

// When the user clicks on <div>, open the popup
function taskComp(message) {
    var popup = document.getElementById("myPopup");
    document.getElementById("popup_message").innerHTML = message;
    popup.classList.toggle("show");
}

function showNote(type) {
    var text = "";
    
    if(type === "disabled"){
        text = "This item can be enabled in <a href='/application/settings' title='Settings'>Settings</a>";
    }
    var note = document.getElementById("note");
    note.innerHTML = text;
    note.classList.toggle("show");
}