function addCategory(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/addCategory",
        data: {name: "Name of Category"},
        success: function(response) {
            alert("This Works");
        }
        /*error: function(){
            popup("Ajax Error - Refresh and try again.");
        }*/
    });

};

function deleteCategory(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/tasks/deleteCategory",
        data: {name: "Name of Category"},
        success: function(response) {
            alert("This Works");
        }
        /*error: function(){
            popup("Ajax Error - Refresh and try again.");
        }*/
    });

};
