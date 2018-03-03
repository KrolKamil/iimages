<?php
session_start();

include '../includes/init.php';

$myRedirect = new Redirect();
$myRedirect->ifRedirect();

$myGame = new Game();
$myGame->playGame();

?>
<!DOCTYPE html>
<html>
<?php
include '../includes/head.php';
?>
<body>
    <div class="container">
        <h1>( ͡°( ͡° ͜ʖ( ͡° ͜ʖ ͡°)ʖ ͡°) ͡°)</h1>
        <div class="col-sm-6">
            <form action="game.php" method="post">
                <?php
                $myGame->showWinnerImage();
                ?>

                <button type="submit" class="btn">Send</button>
            </form>
        </div>
        <div class="col-sm-6">
            <form action="game.php" method="post">

                <?php
                $myGame->showImage();
                ?>

                <button type="submit" class="btn">Send</button>
            </form>
        </div>
    </div>
</body>
</html>

