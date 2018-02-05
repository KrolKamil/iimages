<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php
include "resources/head.php";

//IDZE JAK KREW Z NOSA
//TUTAJ SKONCZYLEM
// DO DOROBIENIA:
// WYBIERANIE OBRAZKOW I ROZGRYWKA

class Game
{
    public function playGame()
    {
        //if(!isset($_SESSION['winner']))
        //{
            global $conn;

            $sql = "SELECT id FROM images";

            $result = $conn->query($sql);

            $images_id = array();

            while ($id = $result->fetch_array(MYSQLI_NUM))
            {
                $images_id[] = $id[0];
            }

            $_SESSION['winner'] = $images_id[0];

            array_splice($images_id,0,1);

            $_SESSION['images_id'] = $images_id;
        //}
    }

    public function showImage()
    {
        global $conn;

        $id = $_SESSION['images_id'][0];

        $sql = "SELECT image FROM images WHERE id = '$id'";

        $images = $conn->query($sql);

        while ($image = $images->fetch_array(MYSQLI_NUM))
        {
            echo "<img src='resources/images/" . $image[0] . "' id=img >";
        }
    }

    public function showWinnerImage()
    {
        global $conn;

        $id = $_SESSION['winner'];

        $sql = "SELECT image FROM images WHERE id = '$id'";

        $images = $conn->query($sql);

        while ($image = $images->fetch_array(MYSQLI_NUM))
        {
            echo "<img src='resources/images/" . $image[0] . " ' id=img_winner>";
        }
    }
}

$myGame = new Game();

$myGame->playGame();

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

