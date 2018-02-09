<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php
include "resources/head.php";

class Game
{
    public function playGame()
    {
        global $conn;

        if(!isset($_SESSION['winner']))
        {
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
        }
        else
        {
            if(count($_SESSION['images_id']) >= 1)
            {
                $winner_id = $_POST['winner'];

                $_SESSION['winner'] = $winner_id;

                array_splice($_SESSION['images_id'],0,1);
            }
            if(count($_SESSION['images_id']) == 0)
            {
                //INSERTING WINNER IMAGE ID TO DB
                $winner_id = $_SESSION['winner'];

                $sql = "SELECT id FROM images_winners WHERE img_id = '$winner_id'";

                if($conn->query($sql)->num_rows > 0)
                {
                    $sql = "UPDATE images_winners SET count_chosen = count_chosen + 1 WHERE img_id = '$winner_id'";

                    $conn->query($sql);
                }
                else
                {
                    $sql = "INSERT INTO images_winners VALUES('', '$winner_id', 1)";

                    $conn->query($sql);
                }
                //DELETING USER AFTER GAME

                $if_admin = false;
                foreach ($_SESSION['account'] as $role)
                {
                    if ($role == 'administrator')
                    {
                        $if_admin = true;
                        break;
                    }
                }

                if($if_admin == false)
                {
                    //DELETING USER

                    $user_id = $_SESSION['account_id'];

                    $sql = "DELETE FROM users WHERE id = '$user_id'";

                    $conn->query($sql);

                    $sql = "DELETE FROM user_roles WHERE user_id = '$user_id'";

                    $conn->query($sql);


                    if (ini_get("session.use_cookies")) {
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                            $params["path"], $params["domain"],
                            $params["secure"], $params["httponly"]
                        );
                    }

                    session_destroy();

                    header("Location: /iimages/");
                    exit;
                }
                else
                {
                    unset($_SESSION['images_id']);
                    unset($_SESSION['winner']);
                    header("Location: /iimages/");
                    exit;
                }



            }
        }

    }

    public function showImage()
    {
        global $conn;

        $id = $_SESSION['images_id'][0];

        $sql = "SELECT * FROM images WHERE id = '$id'";

        $images = $conn->query($sql);

        while ($image = $images->fetch_array(MYSQLI_NUM))
        {
            echo '<img src="resources/images/' . $image[1] . '" name="img" id="img" >';
            echo '<input type=hidden value ="'  . $image[0] . '" name="winner" >';
        }
    }

    public function showWinnerImage()
    {
        global $conn;

        $id = $_SESSION['winner'];

        $sql = "SELECT * FROM images WHERE id = '$id'";

        $images = $conn->query($sql);

        while ($image = $images->fetch_array(MYSQLI_NUM))
        {
            echo '<img src="resources/images/' . $image[1] . '" name="img_winner" id="img">';
            echo '<input type=hidden value ="'  . $image[0] . '" name="winner" >';
        }
    }

    public function ifRedirect()
    {
        if(!isset($_SESSION['account_id']))
        {
            header("Location: /iimages/");
            exit;
        }
    }
}

$myGame = new Game();

$myGame->ifRedirect();

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

