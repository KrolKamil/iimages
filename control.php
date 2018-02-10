<?php
    session_start();

    include 'resources/connection.php';

class Setup
{
    public function showSetup()
    {
        global $conn;

        $sql = "SELECT * FROM users INNER JOIN user_roles ON users.id = user_roles.user_id WHERE user_roles.role_id = 2";

        $users = $conn->query($sql);

        if($users->num_rows > 0)
        {
            $users = 1;
        }
        else
        {
            $users = 0;
        }

        $sql = "SELECT * FROM images";

        $images = $conn->query($sql);

        if($images->num_rows > 0)
        {
            $images = 1;
        }
        else
        {
            $images = 0;
        }

        $sql = "SELECT * FROM images_winners";

        $images_winners = $conn->query($sql);

        if($images_winners->num_rows > 0)
        {
            $images_winners = 1;
        }
        else
        {
            $images_winners = 0;
        }

        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name:</th>';
        echo '<th>#</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        echo '<tr>';
        echo '<th>Players</th>';
        echo '<th>' . $users . '</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>Images</th>';
        echo '<th>' . $images . '</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>Winners</th>';
        echo '<th>' . $images_winners . '</th>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
    }
}

class Session
{
    private $user_id = NULL;
    private $user_roles = array();

    private function getPassword()
    {
        if(!empty($_POST['password']))
        {
            return $_POST['password'];
        }
    }

    private function setRoles($id)
    {
        global $conn;

        $sql = "SELECT roles.role_name FROM users 
                INNER JOIN user_roles ON users.id = user_roles.user_id 
                INNER JOIN roles ON user_roles.role_id = roles.id WHERE users.id ='$id'";

        $roles = $conn->query($sql);

        while ($row = $roles->fetch_array(MYSQLI_NUM)) {
            $this->user_roles[] = $row[0];
        }
        $_SESSION["account"] = $this->user_roles;
        $_SESSION["account_id"] = $this->user_id;
    }

    public function logAccount()
    {
        //chcecking if user exist
        if(!isset($_SESSION['account_id']))
        {
            global $conn;
            $password = $this->getPassword();

            $sql = "SELECT * FROM users";

            $tasks = $conn->query($sql);

            while ($row = $tasks->fetch_array(MYSQLI_NUM)) {
                if (password_verify($password, $row[1])) {
                    $this->user_id = $row[0];
                    $this->setRoles($this->user_id);
                    break;
                }
            }
        }
    }

    public function ifRedirect()
    {
        if(isset($_SESSION['account_id']))
        {
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
                header("Location: game.php");
                exit;
            }
        }
        else
        {
            header("Location: index.php");
            exit;
        }
    }
}

$session = new Session();

$session->logAccount();

$session->ifRedirect();

?>
<!DOCTYPE html>
<html>
<body>
<?php
    include 'resources/head.php';
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
            $mySetup = new Setup();

            $mySetup->showSetup();
            ?>

        </div>
    </div>
</div>


</body>
</html>