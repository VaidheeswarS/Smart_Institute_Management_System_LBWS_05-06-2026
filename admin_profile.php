
<?php
     include("db.php");

?>


<?php
session_start();
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
$email = $_SESSION['username'];

$query = "select * from users where email = '$email'";
$query_1 = mysqli_query($conn, $query);
$admin_data = mysqli_fetch_assoc($query_1);

$stmt = $conn->prepare("SELECT * from Department where id=?");
$stmt->bind_param("i",$admin_data['user_department']);
$stmt->execute();
$get = $stmt->get_result();
$data = $get->fetch_assoc();
$dept = $data['Dept'];

$token = $_SESSION['csrf_token'];

?>
    <div class="profile-page">
        <form id="editform">

            <input type="hidden" name="csrf" id="csrf" value="<?php echo $token ?>">

            <table>

                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" id="name" value="<?php echo $admin_data['name'] ?>" readonly></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="text" name="email" id="email" value="<?php echo $admin_data['email'] ?>" readonly></td>
                </tr>
                <tr>
                    <th>Designation</th>
                    <td><input type="text" name="designation" id="designation" value="<?php echo $admin_data['designation'] ?>" readonly></td>
                </tr>
                 <tr>
                    <th>Department</th>
                    <td><input type="text" name="dept" id="dept" value="<?php echo $dept ?>" readonly></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><input type="text" name="phone" id="phone" value="<?php echo $admin_data['phone'] ?>" readonly></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><input type="text" name="aadhar" id="aadhar" value="<?php echo $admin_data['aadhar'] ?>" readonly></td>
                </tr>
                <tr>    
                    <th>Password</th>
                    <td><input type="password" name="password" id="password" value="<?php echo $admin_data['password'] ?>" readonly></td>
                </tr>
                <tr>
                    <th>Edit</th>
                    <td>
                        <input type="submit" name="edit" value="Edit">
                        <input type="submit" name="delete" value="Delete">
                        <input type="submit" name="change_password" value="Change Password">
                    </td>
                </tr>
            </table>
            <div id="box">

            </div>
        </form>    



    </div>
