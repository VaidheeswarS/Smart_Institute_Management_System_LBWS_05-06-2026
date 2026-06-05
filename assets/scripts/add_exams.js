
$(document).on("submit", "#add_exams_form", function(e){

    e.preventDefault();

    $.ajax({

        url : "add_exams.php",
        type : "POST",
        contentType: "application/json",
        dataType: "json",
        data : JSON.stringify({
            token: $("#csrf").val(),
            sub : $("#sub-name").val(),
            detail : $("#exam-detail").val(),
            date : $("#exam-date").val(),

        }),

        success : function(response){
            if(response.success==true){
                alert(response.message);
                let box = $("#main-content");
                box.load("exams.php");

            }
            else{
                alert(response.message);
            }
        },

        error: function(){
            alert("Something went wrong");
        },

    })

});

$(document).on("click","#bak", function(){

    let box = $("#main-content");
    box.load("exams.php");


});