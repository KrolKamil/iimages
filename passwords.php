<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php
include 'resources/head.php';
class passwordGenerator
{
    private $passwords = array();
    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    private function howManyPasswords()
    {
        $nr_passwords = $_POST['nr_passwords'];
        return $nr_passwords;
    }
    public function createPasswords()
    {
        if(!empty($_POST['nr_passwords']))
        {
            for ($i = 0; $i < $this->howManyPasswords(); $i++)
            {
                $this->passwords[] = $this->randomPassword();
            }
            $this->sendPasswords();
        }
    }
    private function sendPasswords()
    {
        global $conn;
        foreach($this->passwords as $password)
        {
            $pswd_hash = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users VALUES('', '$pswd_hash')";
            $conn->query($sql);
            $sql = "SELECT LAST_INSERT_ID()";
            $query_id = $conn->query($sql);
            while ($id = $query_id->fetch_array(MYSQLI_NUM))
            {
                $sql = "INSERT INTO user_roles VALUES('$id[0]',2)";
                $conn->query($sql);
            }
        }
    }
    public function  showPasswords()
    {
        if(empty(!$this->passwords)) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>#</th>';
            echo '<th>Passwords</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            foreach ($this->passwords as $pw) {
                echo '<tr>';
                echo '<th>' . $i . '</th>';
                echo '<th>' . $pw . '</th>';
                echo '</tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';
        }
    }
    public function deleteAllUsers()
    {
        if(!empty($_POST['delete']))
        {
            global $conn;
            $sql = "SELECT users.id FROM users INNER JOIN user_roles ON users.id = user_roles.user_id WHERE user_roles.role_id = 2";
            $users_id = $conn->query($sql);
            while ($id = $users_id->fetch_array(MYSQLI_NUM))
            {
                $sql = "DELETE FROM users WHERE id = '$id[0]'";
                $conn->query($sql);
            }
            $sql = "DELETE FROM user_roles WHERE role_id = 2";
            $conn->query($sql);
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
                header("Location: /iimages/");
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
        <a href="/iimages/control.php"><button type="button" class="btn">Back</button></a>
        <br><br>
        <a href="/iimages/logout.php"><button type="button" class="btn">Logout</button></a>

        <br><br><br><br><br>
        <form action="passwords.php" method="post">
            <input type="hidden" name="delete" value="1">
            <button type="sumbit" class="btn btn-danger">DELETE ALL USERS</button>
        </form>

    </div>
    <div class="col-sm-6">
        <?php
        $createPassword = new passwordGenerator();
        $createPassword->ifRedirect();
        $createPassword->createPasswords();
        $createPassword->showPasswords();
        $createPassword->deleteAllUsers();
        ?>
    </div>
</div>
</body>
</html>