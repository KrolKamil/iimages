<?php

class RedirectForIndex
{
    public function ifRedirect()
    {
        if(isset($_SESSION['user_id']))
        {
            foreach ($_SESSION['user_roles'] as $role) {
                if ($role == 'administrator') {
                    header("Location: control.php");
                    exit();
                }
            }

            foreach ($_SESSION['user_roles'] as $role) {
                if ($role == 'user') {
                    header("Location: game.php");
                    exit();
                }
            }
        }
    }
}