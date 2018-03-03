<?php

include 'DatabaseConnection.php';

class LoginUser extends DatabaseConnection
{
    private $user_id = NULL;
    private $user_roles = array();

    private function getPasswordFromPost()
    {
        if(!empty($_POST['password']))
        {
            return $_POST['password'];
        }
    }

        private function setRolesForUser($id)
    {

        $sql = "SELECT roles.role_name FROM users 
                INNER JOIN user_roles ON users.id = user_roles.user_id 
                INNER JOIN roles ON user_roles.role_id = roles.id WHERE users.id ='$id'";

        $roles = $this->connect()->query($sql);

        while ($row = $roles->fetch_array(MYSQLI_NUM)) {
            $this->user_roles[] = $row[0];
        }
        $_SESSION["user_roles"] = $this->user_roles;
        $_SESSION["user_id"] = $this->user_id;
    }

    public function loginUser()
    {
        //chcecking if user exist
        if(!isset($_SESSION['user_id']))
        {
            $password = $this->getPasswordFromPost();

            $sql = "SELECT * FROM users";

            $tasks = $this->connect()->query($sql);

            while ($row = $tasks->fetch_array(MYSQLI_NUM)) {
                if (password_verify($password, $row[1])) {
                    $this->user_id = $row[0];
                    $this->setRolesForUser($this->user_id);
                    break;
                }
            }
        }
    }
}