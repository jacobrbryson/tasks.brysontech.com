$(document).ready(function () {
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

        $("#start_date_time").val(Math.round(new Date($("#start_time").val())/1000.0));
        $("#end_date_time").val(Math.round(new Date($("#end_time").val())/1000.0));

        if(validateNewTask(description)){
            addTask();
        } else {
            alert("Please enter a description for your task.");
        }
    });

    function validateNewTask(description, points){
        isNumber = !isNaN(points);
        if(description === ""){
            return false;
        }
        return true;
    }

    function addTask(){
        $data = $("#form_add_task").serialize();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/tasks/addTask",
            data: {data: $data},
            success: function(response) {
                addTaskForm.reset();
                $("#tableTasks tr:last").after("<tr id='tasks-tr-" + response.task_id + "'><td>" + description + "</td><td class='text-center'>0</td><td class='td-actions text-right'><div class='hidden-lg-up text-center'><button type='button'  data-toggle='collapse' data-target='.task-" + response.task_id + "' class='btn btn-secondary btn-simple btn-sm btn-tasks'><i class='fa fa-plus-circle' aria-hidden='true'></i></button></div><div class='hidden-md-down'><button type='button' onclick='editTask(" + response.task_id + ");'rel='tooltip' title='Edit' class='btn btn-info btn-simple btn-sm btn-tasks'><i class='fa fa-pencil' aria-hidden='true'></i></button>&nbsp;<button type='button' onclick='completeTask(" + response.task_id + ");'rel='tooltip' title='Complete' class='btn btn-success btn-simple btn-sm btn-tasks'><i class='fa fa-check' aria-hidden='true'></i></button>&nbsp;<button type='button' onclick='deleteTask(" + response.task_id + ");'rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-sm btn-tasks'><i class='fa fa-times'></i></button></div></td></tr><tr id='tasks-tr-m-" + response.task_id +"' class='hidden-lg-up'><td colspan='3' style='border-top:none'><div class='navbar-collapse collapse task-" + response.task_id + "'><ul class='navbar-nav ml-auto'><li class='nav-item'><button type='button' onclick='editTask(" + response.task_id + ");'rel='tooltip' title='Edit' class='btn btn-info btn-simple btn-block'><i class='fa fa-pencil' aria-hidden='true'></i>Edit</button></li><li class='nav-item' style='padding-top:10px'><button type='button' onclick='completeTask(" + response.task_id + ");'rel='tooltip' title='Complete' class='btn btn-success btn-simple btn-block'><i class='fa fa-check' aria-hidden='true'></i>Complete</button></li><li class='nav-item' style='padding-top:10px'><button type='button' onclick='deleteTask(" + response.task_id + ");'rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-block'><i class='fa fa-times'></i>Delete</button></li></ul></div></td></tr>");
                $("#modal_add_task").modal('toggle');
            },
            error: function(){
                title   = "Something went wrong.";
                body    = "AJAX error.";

                showAlert(title, body);
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
});