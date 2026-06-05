
$(document).on("submit", "#delete_course_form", function(e){

    e.preventDefault();

    // let coursebox = $(e.originalEvent.submitter).closest(".course");
    
    $.ajax({

            url : "delete_course.php",
            type:"POST",
            contentType:"application/json",
            dataType:"json",
            
            data : JSON.stringify({
                token: $("#csrf").val(),
                dept: $("#del-c").val(),
            }),

            success: function(response){
                if(response.success == true){
                    
                    alert(response.message);
                    let box = $("#main-content");
                    box.load("courses.php");
                }
                else{
                    alert("Unable to Delete course");
                }

            },
            
            error: function(){
                alert("something went wrong");
            }


        });
});



$(document).on("click","#back", function(){

    let box = $("#main-content");
    box.load("courses.php");


});