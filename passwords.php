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

        //zrozumiec jak dziala
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

        private function howManyPasswors()
        {
            $nr_passwords = $_POST['nr_passwords'];

            return $nr_passwords;
        }

        public function createPasswords()
        {
            for($i = 0; $i<$this->howManyPasswors(); $i++)
            {
                $this->passwords[] = $this->randomPassword();
            }
        }

        public  function  showPasswords()
        {
            echo '<table class="table">';
            echo '<thead>';
            echo'<tr>';
                    echo '<th>#</th>';
                    echo '<th>Passwords</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            foreach ($this->passwords as $pw)
            {
                echo '<tr>';
                    echo'<th>' . $i . '</th>';
                    echo'<th>' . $pw . '</th>';
                echo '</tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';
        }

        public function redirect()
        {
            $if_admin = false;
            foreach($_SESSION['account'] as $role)
            {
                if($role == 'administrator')
                {
                    $if_admin = true;
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

        </div>

        <div class="col-sm-6">
            <?php
               $createPassword = new passwordGenerator();

               $createPassword->createPasswords();

               $createPassword->showPasswords();



            ?>
        </div>
    </div>
</body>
</html>