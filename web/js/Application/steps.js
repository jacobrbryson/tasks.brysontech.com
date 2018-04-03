$("#form_add_step").on("submit", function(e){
    e.preventDefault();
    
    addStep();
});

function addStep(){
    var name= $("#form_add_step").find("#step").val();
    var task_id=$("#form_add_step").find("#task_id").val();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/step/add",
        data:{step:name, task_id:task_id},
        success: function(response) {
            console.log(response);
            $("#steps_table").find("#step_info").append("<tr><td>" + name + "</td></tr>");
            
        }        
    });
}

function completeStep(id){
   alert("Completing step " + id);
   $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/step/complete/{{id}}",
        data:{id:id},
        success:function(response){
            console.log(response);
        }
    });
}


