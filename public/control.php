<?php
session_start();

require_once '../includes/init.php';

$myLoginUser = new LoginUser();
$myLoginUser->loginUser();

$myRedirect = new Redirect();
$myRedirect->ifRedirect();

?>
<!DOCTYPE html>
<html>
<body>
<?php
require_once '../includes/head.php';
?>
<div class="container">
    <h1>Admin Page</h1>
    <div class="row">
        <div class="col-sm-6">
            Hello Mr Admin.<br>
            <a href="passwords.php">Password Generator</a><br>

            <a href="upload.php">Upload Images</a><br>

            <a href="game.php">Game</a><br>

            <a href="winners.php">Winners</a><br>

            <a href="logout.php"><button type="submit" class="btn">Logout</button></a>
        </div>

        <div class="col-sm-6">
            <?php
            $myTableOfSettings = new TableOfSettings();

            $myTableOfSettings->showTableOfSettings();
            ?>

        </div>
    </div>
</div>


</body>
</html>