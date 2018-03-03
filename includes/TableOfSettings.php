<?php

include 'DatabaseConnection.php';

class TableOfSettings extends DatabaseConnection
{
    public function showTableOfSettings()
    {
        $sql = "SELECT * FROM users INNER JOIN user_roles ON users.id = user_roles.user_id WHERE user_roles.role_id = 2";

        $users = $this->connect()->query($sql);

        if($users->num_rows > 0)
        {
            $users = 1;
        }
        else
        {
            $users = 0;
        }

        $sql = "SELECT * FROM images";

        $images = $this->connect()->query($sql);

        if($images->num_rows > 0)
        {
            $images = 1;
        }
        else
        {
            $images = 0;
        }

        $sql = "SELECT * FROM images_winners";

        $images_winners = $this->connect()->query($sql);

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