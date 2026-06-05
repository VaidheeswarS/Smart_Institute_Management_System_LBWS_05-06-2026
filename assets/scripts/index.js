
$(document).ready(function(){

let form = $("form");
form.eq(0).submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "index.php",   
        type: "POST",   
        contentType:"application/json",
        dataType:"json",

        data: JSON.stringify({
            email: $("#email").val(),
            password: $("#password").val()
        }),

        success: function(response){

            response.message = response.message.trim();

            if(response.message=="Login Successful"){

                alert(response.message);

                switch(response.user_type){

                    case "Admin":
                        window.location.replace("Admin_dashboard.php");
                        break;
                    
                    case "Staff":
                        window.location.replace("staff_dashboard.php");
                        break;

                    case "Student":
                        window.location.replace("user_dashboard.php");
                        break;

                    default:
                        alert("Invalid role.");
                }

            }
            else{
                alert(response.message);
            }
        },

        error:function(){
            alert("something went wrong.");
        }

    });


});
    
    let fb_button = $("#fb-button");
    fb_button.click(function(){
        alert("Service temporarily not available");
    });

    let g_button = $("#g-button");
    g_button.click(function(){
        alert("Service temporarily not available");
    });

    let forget = $("#forget");
    forget.click(function(){
        alert("Service temporarily not available");
    });

    let eye = $("#eye");
    eye.click(function(){
        let password = $("#password");
        if(password.attr("type")=="password"){
            password.attr("type","text");
            eye.attr("class","fa-solid fa-eye");

        }
        else if(password.attr("type")=="text"){
            password.attr("type","password");
            eye.attr("class","fa-solid fa-eye-slash eye");

        }

    });
});