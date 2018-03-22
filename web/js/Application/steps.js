$("#form_add_step").on("submit", function(e){
    e.preventDefault();
    
    addStep();
});

function addStep(){
    var name= $("#form_add_step").find("#step").val();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/application/step/add",
        data:{step:name},
        success: function(response) {
            console.log(response);
        }        
    });
}


