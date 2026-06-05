
$(document).on("submit", "#update_exam_Confim_form", function(e){

    e.preventDefault();

    // let coursebox = $(e.originalEvent.submitter).closest(".course");
    
    $.ajax({
            url : "update_exam_confirmation.php",
            type:"POST",
            contentType:"application/json",
            dataType:"json",
            
            data : JSON.stringify({
                token: $("#csrf").val(),
                dept: $("#up-exam-sub").val(),
            }),

            success: function(response){

                if(response.success == true){
                    
                    alert(response.message);
                    let box = $("#main-content");
                    box.load("update_exam_final.php");
                }
                else{
                    alert(response.message);
                }

            },
            
            error: function(xhr){
                console.log(xhr.responseText);
                alert(xhr.responseText);
            }

        });
});

$(document).on("click","#upback", function(){

    let box = $("#main-content");
    box.load("update_exams.php");


});