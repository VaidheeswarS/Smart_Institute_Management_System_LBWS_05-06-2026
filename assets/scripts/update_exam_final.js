
$(document).on("submit","#update_exam_final", function(e){

e.preventDefault();


let button = e.originalEvent.submitter.name;

if(button=="updatebtn"){
    $.ajax({

        url : "update_exam_final.php",
        type: "POST",
        contentType: "application/json",
        dataType: "json",

        data : JSON.stringify({
            token: $("#csrf").val(),
            exam_detail: $("#exam_detail").val(),

        }),

        success: function(response){
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
            alert("something went wrong");
        }
    });

}




});

$(document).on("click","#final", function(){

    let box = $("#main-content");
    box.load("update_exam_confirmation.php");


});