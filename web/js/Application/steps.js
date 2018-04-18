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
            $("#steps_table").find("#step_info").append("<tr><td>" + name + "</td><td>No</td><td><button onclick=stepComplete(" + step.id + "); >Complete</button></td></tr>");
            //$("#steps_table").find("#step_info").append("<td><button onclick=completeStep(" + step.id + "); >Complete</button></td>");
            
        }
        
    });
}

function getSteps(){
    var task_id=$("#form_add_step").find("#task_id").val();
    $.ajax({
        type: "GET",
        datatype: "json",
        url: "/application/step/" + task_id,
        //data:{task_id:task_id},
        success: function(results) {            
            console.log(results);           
            var steps = JSON.parse(results);
            
             //if(steps.length > 0){ console.log("steps: " + steps.length);}else{console.log("No steps returned");};
            if(steps.length > 0){ buildStepsTable(); } else { $("#container_steps").html("No steps yet.");};
            buildSteps(steps);
            
        }
    });
}

function buildStepsTable(){
    var htmlString='<div id ="steps_table" class="col-12">\n\
                                <table class="table table-hover table-striped table-dark">\n\
                                <thead><th>Step</th><th>Complete</th></thead>\n\
                                <tbody id="step_info"></tbody></table></div>';
    $("#container_steps").html(htmlString);
    
}

function buildSteps(steps){
    
    for (i=0; i<steps.length; i++){
        
        $("#container_steps").find("#step_info").append('<tr><td>'+steps[i].step_description+'</td><td id="'+steps[i].id+'">'+(steps[i].complete ? "Yes" : "No")+'</td>\n\
                        <td><button onclick="stepComplete('+steps[i].id+');">Complete</button></td></tr>');
        console.log(steps[i].complete);
        
    }
    
}

function stepComplete(id){
    console.log("attempting to complete" + id);
    //alert("Completing step " + id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/application/step/complete/{id}",
            data:{id:id},
            success:function(response){
                console.log(response);
            $("#container_steps").find("#" + id).html("YES");    
            }
        });
}

    
function buildStep(steps){
    console.log(steps);    
        if(steps.complete === 1){
          $("#container_steps").find("#" +steps[i].id).html("YES");  
        }
    
}

function buildRows(steps){
    
}

function addRow(steps){
    
}

/*function completeStep(id){
   alert("Completing step " + id);
   $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/step/complete/{{id}}",
        data:{id:id},
        success:function(response){
            console.log(response);
            $("#steps_table").find("#step_info").remove(step.id);
        }
    });
}*/

$(document).ready(function() { 
    getSteps();
});

