
$(document).on("submit", "#updateform", function(e){

    e.preventDefault();

        let formdata = new FormData(this);

        $.ajax({

            url:"staff_update_validation.php",
            type: "POST",

            data : formdata,
            dataType: "json",
            contentType: false,
            processData: false,

            success : function(response){

                if (response.message == "Data updated"){
                    alert(response.message);
                    $("#main-content").load("staff_profile.php");

                    // window.location.replace("");
                }
                else{
                    alert(response.message);
                }
            },

            error: function(xhr, status, error){

                console.log(xhr.responseText);
                console.log(status);
                console.log(error);

                alert(xhr.responseText);

            }
        });

});

