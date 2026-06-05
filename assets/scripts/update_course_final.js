
$(document).on("submit","#update_course", function(e){

e.preventDefault();


let button = e.originalEvent.submitter.name;

if(button=="updatebtn"){
    $.ajax({

        url : "update_course_final.php",
        type: "POST",
        contentType: "application/json",
        dataType: "json",

        data : JSON.stringify({
            token: $("#csrf").val(),
            department: $("#department").val(),
            about: $("#about").val(),
            duration: $("#duration").val(),
            fees: $("#fees").val(),
        }),

        success: function(response){
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
            alert("something went wrong");
        }
    });

}
else{
    let box = $("#main-content");
    box.load("update_course.php");
}


});