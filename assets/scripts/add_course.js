
$(document).on("submit", "#add_course_form", function(e){

    e.preventDefault();

    $.ajax({

        url : "add_course.php",
        type : "POST",
        contentType: "application/json",
        dataType: "json",
        data : JSON.stringify({
            token: $("#csrf").val(),
            name : $("#course-name").val(),
            about : $("#course-about").val(),
            duration : $("#course-duration").val(),
            fees : $("#course-fees").val(),

        }),

        success : function(response){
            if(response.success==true){
                alert(response.message);
                let box = $("#main-content");
                box.load("courses.php");

            }
            else{
                alert(response.message);
            }
        },

        error: function(){
            alert("Something went wrong");
        },

    });

    

});


$(document).on("click","#back", function(){

    let box = $("#main-content");
    box.load("courses.php");


});