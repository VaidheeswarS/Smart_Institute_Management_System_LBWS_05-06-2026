
<?php
     include("db.php");

?>


<?php

session_start();
$user = $_SESSION['username'];

$token = $_SESSION['csrf_token'];
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
<div id="staff-update">
    <form id="updateform">

        <input type="hidden" name="csrf"  value="<?php echo $token ?>">

            <table>

                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="uname" value="<?php echo $_SESSION['name'] ?>" ></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input type="text" name="uemail" value="<?php echo $_SESSION['email'] ?>"></td>
                    </tr>
                    
                    <tr>
                        <th>Phone</th>
                        <td><input type="text" name="uphone" value="<?php echo $_SESSION['phone'] ?>"></td>
                    </tr>
                    <tr>
                        <th>Certificate</th>
                        <td><input type="text" name="oldcertificate" value="<?php echo $_SESSION['certificate'] ?>" readonly></td>
                        <td><input type="file" name="ucertificate"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><input type="text" name="oldaadhar" value="<?php echo $_SESSION['aadhar'] ?>" readonly></td>
                        <td><input type="file" name="uaadhar"></td>
                    </tr>
                    <tr>
                        <th>Edit</th>
                        <td>
                            <input type="submit" value="Update">
                            
                        </td>
                    </tr>
            </table>
    </form>    
</div>