
$(document).on("submit", "#delete_exam_Confim_form", function(e){

    e.preventDefault();

    // let coursebox = $(e.originalEvent.submitter).closest(".course");
    
    $.ajax({

            url : "delete_exam_confirmation.php",
            type:"POST",
            contentType:"application/json",
            dataType:"json",
            
            data : JSON.stringify({
                token: $("#csrf").val(),
                dept: $("#del-exam-sub").val(),
            }),

            success: function(response){
                if(response.success == true){
                    
                    alert(response.message);
                    let box = $("#main-content");
                    box.load("exams.php");
                }
                else{
                    alert(response.message);
                }

            },
            
            error: function(){
                alert("something went wrong");
            }


        });
});

$(document).on("click","#delback", function(){

    let box = $("#main-content");
    box.load("delete_exams.php");


});