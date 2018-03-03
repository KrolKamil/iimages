<?php

include 'DatabaseConnection.php';

class PasswordGenerator
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
        foreach($this->passwords as $password)
        {
            $pswd_hash = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users VALUES('', '$pswd_hash')";
            $this->connect()->query($sql);
            $sql = "SELECT LAST_INSERT_ID()";
            $query_id = $this->connect()->query($sql);
            while ($id = $query_id->fetch_array(MYSQLI_NUM))
            {
                $sql = "INSERT INTO user_roles VALUES('$id[0]',2)";
                $this->connect()->query($sql);
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
            $sql = "SELECT users.id FROM users INNER JOIN user_roles ON users.id = user_roles.user_id WHERE user_roles.role_id = 2";
            $users_id = $this->connect()->query($sql);
            while ($id = $users_id->fetch_array(MYSQLI_NUM))
            {
                $sql = "DELETE FROM users WHERE id = '$id[0]'";
                $this->connect()->query($sql);
            }
            $sql = "DELETE FROM user_roles WHERE role_id = 2";
            $this->connect()->query($sql);
        }
    }

    public function ifPasswordsAreGenerated()
    {
        $sql = "SELECT * FROM user_roles WHERE role_id = 2";

        if($this->connect()->query($sql)->num_rows > 0)
        {
            echo "Some one is still playing";
        }
    }
}