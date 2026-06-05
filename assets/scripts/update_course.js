
$(document).on("submit", "#update_course_form", function(e){

    e.preventDefault();

    let button = e.originalEvent.submitter.name;

    if(button=="choose_course"){

            
        $.ajax({

                url : "update_course.php",
                type:"POST",
                contentType:"application/json",
                dataType:"json",
                
                data : JSON.stringify({
                    token: $("#csrf").val(),
                    dept: $("#up-c").val(),
                }),

                success: function(response){
                    if(response.success == true){
                        
                        alert(response.message);
                        let box = $("#main-content");
                        box.load("update_course_final.php");
                    }
                    else{
                        alert("Unable to Delete course");
                    }

                },
                
                error: function(){
                    alert("something went wrong");
                }


            });
    }
    else{
        let box = $("#main-content");
        box.load("courses.php");
    }

});