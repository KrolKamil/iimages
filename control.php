<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<?php
include 'resources/head.php';

class Session
{
    private $password='';
    private $user_id = NULL;
    private $user_roles = array();

    public function setData()
    {
        if(!empty($_POST['password']))
        {
            $this->password = $_POST['password'];
            //$this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }
    }

    public function login()
    {
        //chcecking if user exist
        global $conn;

        $sql = "SELECT * FROM users";

        $tasks = $conn->query($sql);

        while($row = $tasks->fetch_array(MYSQLI_NUM))
        {
                if(password_verify($this->password,$row[1]))
                {
                    $this->user_id = $row[0];
                    break;
                }
        }

        //setting rules for user
        if($_SESSION['account']!='administrator')
        {
            if (isset($this->user_id)) {
                $sql = "SELECT roles.role_name FROM users 
                INNER JOIN user_roles ON users.id = user_roles.user_id 
                INNER JOIN roles ON user_roles.role_id = roles.id WHERE users.id ='$this->user_id'";

                $roles = $conn->query($sql);

                while ($row = $roles->fetch_array(MYSQLI_NUM)) {
                    $this->user_roles[] = $row[0];
                }
                $_SESSION["account"] = $this->user_roles;

            } else {
                header("Location: /iimages/index.php");
            }
        }
    }

    // $_SESSION["account"]

    public function setRoles()
    {
        $if_admin = false;
        foreach ($this->user_roles as $role)
        {
            if($role == 'administrator')
            {
                $if_admin = true;
                break;
            }
        }

        if($if_admin == false)
        {
            header("Location: /iimages/index.php");
        }
    }
}
?>
<body>

<div class="container">
    <h1>Admin Page</h1>
    <div class="row">
        <div class="col-sm-6">
            Hello Mr Admin.
            <a href="/iimages/passwords.php">Password Generator</a>
            <?php
            $data = new Session();

            $data->setData();

            $data->login();

            $data->setRoles();
            ?>
        </div>
    </div>
</div>


</body>
</html>