<?php
session_start();

require_once '../includes/init.php';

$myRedirect = new Redirect();
$myRedirect->ifRedirect();

?>
<!DOCTYPE html>
<html>
<?php
include '../includes/head.php';
?>
<body>
<div  class="container">
    <h1>Password generator</h1>
    <div class="col-sm-6">
        <form action="passwords.php" method="post">
            <div class="form-group">
                <h3>How many passwords generate:</h3>
                <input type="text" class="form-control" id="nr_passwords" name="nr_passwords" placeholder="">
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>

        <br><br>
        <a href="control.php"><button type="button" class="btn">Back</button></a>
        <br><br>
        <a href="logout.php"><button type="button" class="btn">Logout</button></a>

        <br><br><br><br><br>
        <form action="passwords.php" method="post">
            <input type="hidden" name="delete" value="1">
            <button type="sumbit" class="btn btn-danger">DELETE ALL USERS</button>
        </form>

    </div>
    <div class="col-sm-6">
        <?php
        $myPasswordGenerator = new PasswordGenerator();
        $myPasswordGenerator->createPasswords();
        $myPasswordGenerator->showPasswords();
        $myPasswordGenerator->deleteAllUsers();
        $myPasswordGenerator->ifPasswordsAreGenerated();
        ?>
    </div>
</div>
</body>
</html>