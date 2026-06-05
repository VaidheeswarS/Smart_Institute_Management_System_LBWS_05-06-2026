
$(document).on("submit", "#course-form", function(e){

    e.preventDefault();


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
                    box.load("view_course_u.php");
                }
                else{
                    alert("Unable to view course");
                }
            },
            
            error: function(){
                alert("something went wrong.");
            }


        });



});
