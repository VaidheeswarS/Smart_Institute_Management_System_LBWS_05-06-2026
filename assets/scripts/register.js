
$(document).ready(function(){

    let user = $(".designation");

    user.click(function(){

        let position = $(".designation:checked").val();

        var extra_field = $("#extra_field");

        if(position === "Staff"){

            extra_field.empty();

            var input = $("<input>");

            input.attr("type","file");
            input.attr("name", "staff_certificate");
            input.attr("placeholder","Provide certificate for proof");

            extra_field.append(input);

        }
        else if(position === "Student"){

            extra_field.empty();

        }

    });


    let form = $("form");

    form.eq(0).submit(function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({

            url: "register.php",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success: function(response){

                response = response.trim();

                if(response === "User Registered successfully"){

                    alert(response);

                    window.location.href = "index.html";

                }
                else{

                    alert(response);

                }

            },

            error: function(){

                alert("Something went wrong");

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