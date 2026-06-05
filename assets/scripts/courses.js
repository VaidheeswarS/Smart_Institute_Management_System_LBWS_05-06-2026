
$(document).on("submit", "#course-form", function(e){

    e.preventDefault();

    let button = e.originalEvent.submitter.name;                       

    if (button=="Add"){
        let box = $("#main-content");
        box.load("add_course.php");
        
    }
    else if (button=="Delete"){
        
        let box = $("#main-content");
        box.load("delete_course.php");
    }
    else if(button=="Update"){
        let box = $("#main-content");
        box.load("update_course.php");
    }
    else{

        let coursebox = $(e.originalEvent.submitter).closest(".course");
        $.ajax({
           
            url : "course_validation.php",
            type : "POST",
            dataType: "json",
            contentType:"application/json",
            
            data : JSON.stringify({
                token: coursebox.find(".csrf").val(),
                dept: coursebox.find(".c-dept").text(),

            }),

            success: function(response){
                if(response.success==true){
            
                    let box = $("#main-content");
                    box.load("view_course.php");
                }
                else{
                    alert("Unable to view course");
                }

            },
            
            error: function(){
                alert("something went wrong.");
            }


        });
    }









});
