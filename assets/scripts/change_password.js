
$(document).on("submit", "#changepassword_form",  function(e){

    e.preventDefault();

    $.ajax({

        url: "change_password_validation.php",
        type:"POST",
        contentType: "application/json",
        dataType: "json",
        data : JSON.stringify({
            token : $("#csrf").val(),
            old_password: $("#old").val(),
            new_password: $("#new").val(),
            confirm_password: $("#confirm").val(),
           

        }),

        success: function(response){

            if(response.success == true){

                if(response.userposition=="Staff"){
                    alert(response.message);
                    $("#main-content").load("staff_profile.php");
                }
                alert(response.message);
                $("#main-content").load("admin_profile.php");
            }
            else{
                alert(response.message);
            }
        },

        error: function(){
            alert("something went wrong.");
        }



    });


});