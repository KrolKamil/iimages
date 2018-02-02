<?php
    session_start();

    class Redirect
    {
        public function ifRedirect()
        {
            if(isset($_SESSION['account_id']))
            {
                foreach ($_SESSION['account'] as $role) {
                    if ($role == 'administrator') {
                        header("Location: /iimages/control.php");
                        exit;
                    }
                }

                foreach ($_SESSION['account'] as $role) {
                    if ($role == 'user') {
                        header("Location: /iimages/game.php");
                        exit;
                    }
                }
            }
        }
    }

    $myRedirect = new Redirect();

    $myRedirect->ifRedirect();
?>
<!DOCTYPE html>
<html>
    <?php
    include 'resources/head.php';
    ?>
<body>

<div class="container">
    <h1>IIMAGES</h1>
    <div class="row">
        <div class="col-sm-6">
            <form action="control.php" method="post">
                <div class="form-group">
                    <h3>Password:</h3>
                    <input type="text" class="form-control" id="password" name="password" placeholder="">
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>

        </div>

    </div>
</div>
</body>
</html>