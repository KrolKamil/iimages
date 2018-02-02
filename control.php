<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<?php
include 'resources/head.php';

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
                header("Location: /iimages/game.php");
                exit;
            }
        }
        else
        {
            header("Location: /iimages/");
            exit;
        }
    }
}
?>
<body>

<div class="container">
    <h1>Admin Page</h1>
    <div class="row">
        <div class="col-sm-6">
            Hello Mr Admin.<br>
            <a href="/iimages/passwords.php">Password Generator</a><br>

            <a href="/iimages/logout.php"><button>Logout</button></a>

            <?php
            $session = new Session();

            $session->logAccount();

            $session->ifRedirect();


            ?>
        </div>
    </div>
</div>


</body>
</html>