

$(document).on("submit", "#editform", function(e)
{
    e.preventDefault();

    // let formdata = $(this).serialize();
    let button = e.originalEvent.submitter.name;

    if(button==="edit"){
        
        $.ajax({

            url: "staff_profile_validation.php",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({
                token : $("#csrf").val(),
                name : $("#name").val(),
                email : $("#email").val(),
                phone : $("#phone").val(),
                certificate : $("#certificate").val(),
                aadhar : $("#aadhar").val(),
                password : $("#password").val()

            }),

            success: function(response){

                if(response.message.trim()=="Data verified"){

                    alert(response.message);
                    
                    // window.location.href = "admin_update.php";
                    $("#main-content").load("staff_update.php");

                }
                else{
                    alert(response.message);
                }
                
            },

            error: function(){
                alert("Something went wrong.");
            }  

        });
    }
    else if(button==="delete"){
    
        $("#main-content").load("delete.php");
    
        // window.location.href = "delete.php";

    }
    else{
        $.ajax({
            url: "token_validation.php",
            type:"POST",
            contentType : "application/json",
            dataType:"json",

            data : JSON.stringify({
                token : $("#csrf").val(),
            }),

            success: function(response){

                if (response.message == "token matched"){

                    $("#main-content").load("change_password.php");

                }
                else{
                    alert("Invalid session");
                }
            },
            
            error: function(){
                alert("something went wrong.");
            }

        });
    }

});