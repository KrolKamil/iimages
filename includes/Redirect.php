<?php

class Redirect
{
    public function ifRedirect()
    {
        if(isset($_SESSION['user_id']))
        {
            $if_admin = false;
            foreach ($_SESSION['user_roles'] as $role)
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