function editTask(taskid){
    //get task information
    
    //show task information in the modal
}

function submitTaskEdits(data){
    //serialize data
    
    //pass it over via ajax to the controller, let her do her job.
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
            if(response.result){
                popup(response.message);
            } else {
                popup(response.message);
            }
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

function deleteTask(taskid){
    console.log("Delete TaskId: " + taskid);
    $("#tasks-tr-" + taskid).remove();
    $("#tasks-tr-m-" + taskid).remove();
                
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/deleteTask",
        data: {task_id: taskid},
        success: function(response) {
            if(response.result){
                popup(response.message);
            } else {
                popup(response.message);
            }
        },
        error: function(){
            popup("Ajax Error - Refresh and try again.");
        }
    });
}

// When the user clicks on <div>, open the popup
function popup(message) {
    showPopup(message);
    setTimeout(function(){
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("hide");
    }, 3000);
}

function showPopup(message){
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

function addCategory(){
    console.log("calling add category");
}

function deleteCategory(){
    console.log("calling delete category");
}