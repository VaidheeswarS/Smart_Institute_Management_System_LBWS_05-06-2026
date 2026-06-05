
$(document).on("submit","#deleteform", function(e){

    e.preventDefault();
    let button = e.originalEvent.submitter.name;

    if (button == "yes"){
         
        $.ajax({
            url: "delete_validation.php",
            type:"POST",
            contentType : "application/json",
            dataType:"json",

            data : JSON.stringify({
                token : $("#csrf").val(),
            }),

            success: function(response){

                if (response.message == "Account Deleted Successfully"){
                    alert(response.message);
                    window.location.replace("index.php");

                }
                else{
                    alert(response.message);
                }
            },
            
            error: function(){
                alert("something went wrong.");
            }

        });

    }
    else{
        $("#main-content").load("admin_profile.php");
    }


});