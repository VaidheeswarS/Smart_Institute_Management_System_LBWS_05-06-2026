
$(document).on("submit", "#exam-form", function(e){

    e.preventDefault();

    let button = e.originalEvent.submitter.name;                       

    if (button=="Add"){
        let box = $("#main-content");
        box.load("add_exams.php");
        
    }
    else if(button=="Update"){
        let box = $("#main-content");
        box.load("update_exams.php");
    }
    else{
        
        let box = $("#main-content");
        box.load("delete_exams.php");
    }
    

});