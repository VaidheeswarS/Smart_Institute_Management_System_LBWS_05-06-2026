
$(document).on("submit","#user-form", function(e){

    e.preventDefault();

    let button = e.originalEvent.submitter.name;


    let row = $(e.originalEvent.submitter).closest(".row");


    if(button=="status"){
        var email = row.find(".email").text();
        
        $.ajax({
            url : "students_validation.php",
            type: "POST",
            contentType: "application/json",
            dataType:"json",
            data: JSON.stringify({
                token : $("#csrf").val(),
                user : email,

            }),
            success : function(response){
                if(response.success == true){
                    alert(response.message);
                    let box = $("#main-content");
                    box.load("students.php");

                }
                else{
                    alert(response.message);

                }
            },
            error: function(){
                alert("Something went wrong");

            }
        });
        


    }
    else {
        var email = row.find(".email").text();

        $.ajax({
            url : "students_validation_delete.php",
            type: "POST",
            contentType: "application/json",
            dataType:"json",
            data: JSON.stringify({
                token : $("#csrf").val(),
                user : email,

            }),
            success : function(response){
                if(response.success == true){
                    alert(response.message);
                    let box = $("#main-content");
                    box.load("students.php");
                }
                else{
                    alert(response.message);

                }
            },
            error: function(){
                alert("Something went wrong");

            }
        });
    }
    





});