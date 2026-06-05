
$(document).on("submit","#logout", function(e){

    e.preventDefault();

    let button = e.originalEvent.submitter.name;

    if(button=="yes"){
        $.ajax({

            url :"logout.php",
            type : "POST",
            dataType:"json",
            contentType: "application/json",

            data: JSON.stringify({
                token : $("#csrf").val(),
            }),

            success: function(response){
                if(response.success==true){
                    alert(response.message);
                    window.location.replace("index.html");
                }
                else{
                    alert(response.message);
                }
            },

            error:function(){
                alert("Something went wrong");
            }
            
        });
    }
    else{
        window.location.reload();
    }








});