
<?php
    include("db.php");
    

    // $token = $_SESSION['csrf_token'];
    session_start();

    if(empty($_SESSION['csrf_token'])){

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    };
    if (
        !isset($_COOKIE['username']) ||
        !isset($_SESSION['username']) ||
        $_COOKIE['username'] !== $_SESSION['username']
    ){

        session_unset();
        session_destroy();

        setcookie("username", "", time() - 3600, "/");

        header("Location: index.html");

        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="assets/css/staff_profile.css">
        <link rel="stylesheet" href="assets/css/staff_update.css">
        <link rel="stylesheet" href="assets/css/delete.css">
        <link rel="stylesheet" href="assets/css/change_password.css">
        <link rel="stylesheet" href="assets/css/trainers.css">
        <link rel="stylesheet" href="assets/css/student.css">
        <link rel="stylesheet" href="assets/css/logout.css">    
        <link rel="stylesheet" href="assets/css/courses_u.css">        
        <link rel="stylesheet" href="assets/css/view_course_u.css">     
        <link rel="stylesheet" href="assets/css/myexams.css">        


        <title>Document</title>


        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "Google Sans", sans-serif;
            }

            html, body {
                height: 100%;
                overflow: hidden;
            }

            .staff-page {
                height: 100vh;
                background-color: #f4f6f9;
                display: flex;
                flex-direction: column;
            }

            /* Navbar */
            .staff-page #navbar-div {
                flex: 0 0 100px;
                background-color: rgb(28,122,173);
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 20px;
                color: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.15);
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .staff-page #navbar-div ul {
                list-style: none;
                display: flex;
                gap: 15px;
            }

            .staff-page #navbar-div li {
                padding: 8px 12px;
                cursor: pointer;
                border-radius: 6px;
                transition: .3s;
                background: rgba(255,255,255,0.15);
                font-size: 14px;
            }

            .staff-page #navbar-div li:hover {
                background: rgba(255,255,255,0.3);
            }

            /* Content Layout */
            .staff-page #content {
                flex: 1;
                display: flex;
                overflow: hidden;
            }

            /* Sidebar */
            .staff-page #activity-bar {
                width: 220px;
                background-color: white;
                border-right: 1px solid #ddd;
                box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            }

            .staff-page #activity-bar ul {
                list-style: none;
                padding-top: 20px;
            }

            .staff-page #activity-bar li {
                padding: 15px 20px;
                cursor: pointer;
                font-weight: 500;
                color: #333;
                transition: .3s;
            }

            .staff-page #activity-bar li:hover {
                background-color: rgb(28,122,173);
                color: white;
            }

            /* Main Content */
            .staff-page #main-content {
                flex: 1;
                padding: 20px;
                background-color: #f4f6f9;
                overflow-y: auto;
                height: 100%;
            }

            /* Cards */
            .staff-page .card {
                background: white;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 15px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            }
        </style>

    </head>

   
    <body class="staff-page">

        <div id="navbar-div">
            <?php
                    $data = $_COOKIE['username'];
                    echo "Hi Welcome staff: ", $data;

            ?>
           <ul>
                <li id="Profile">Profile</li>
                <li id="trainers">Trainers</li>
                <li id="students">Students</li>
                <li id="logout">Logout</li>
           </ul>
        </div>
        <div id="content">

            <div id="activity-bar">
                <ul>
                    <li id ="courses">Courses</li>
                    <li id="exams">Exams</li>

                </ul>
            </div>

            <div id="main-content">

            </div>

        </div>



        <script src="assets/scripts/jquery-4.0.0.min.js">

        </script>

        <script src="assets/scripts/staff_dashboard.js">

        </script>

        <script src="assets/scripts/staff_update.js">

        </script>
        
        <script src="assets/scripts/staff_profile.js">

        </script>

        <script src="assets/scripts/delete.js">

        </script>

        <script src="assets/scripts/change_password.js">

        </script>

        <script src="assets/scripts/courses_u.js">

        </script>

        <script src="assets/scripts/view_course_u.js">

        </script>

        <script src="assets/scripts/logout.js">

        </script>
    </body>
</html>
