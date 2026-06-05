
$(document).ready(function(){

    var profile = $("#Profile");
    profile.css("cursor","pointer");

    profile.click(function(){

        var box = $("#main-content");
        box.load("admin_profile.php");

    });

    
    let courses = $("#courses");
    courses.css("cursor","pointer");

        courses.click(function(){

            let box = $("#main-content");
            box.load("courses_u.php");


        });

    

    let mycourse = $("#mycourse");
    mycourse.css("cursor","pointer");

    mycourse.click(function(){
    
        let box = $("#main-content");
        box.load("individual_course.php");

    });

    
    let exams = $("#exams");
    exams.css("cursor","pointer");
    
    exams.click(function(){
    
        let box = $("#main-content");
        box.load("myexams.php");

    });

    
   
    let logout = $("#logout");
    logout.css("cursor","pointer");

    logout.click(function(){
        
        let box = $("#main-content");
        box.load("logout.php");

    });

});