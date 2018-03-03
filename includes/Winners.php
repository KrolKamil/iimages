<?php

include 'DatabaseConnection.php';

class Winners extends DatabaseConnection
{
    private function ifShowWinners()
    {

        $sql = "SELECT * FROM users INNER JOIN user_roles ON users.id = user_roles.user_id WHERE user_roles.role_id = 2";

        $result = $this->connect()->query($sql);

        if($result->num_rows == 0)
        {
            $sql = "SELECT * FROM images_winners";

            $result = $this->connect()->query($sql);

            if($result->num_rows > 0)
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    public function showWinners()
    {

        if($this->ifShowWinners())
        {
            $sql = "SELECT images.image, images_winners.count_chosen FROM images INNER JOIN images_winners ON images.id = images_winners.img_id";

            $result = $this->connect()->query($sql);

            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>#</th>';
            echo '<th>IMG</th>';
            echo '<th>Link</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($image = $result->fetch_array(MYSQLI_NUM))
            {
                echo '<tr>';
                echo '<th>' . $image[1] . '</th>';
                echo '<th>' . '<img src="resources/images/' . $image[0] . '"id="img_winners" >' . '</th>';
                echo '<th>' . '<a href="resources/images/' . $image[0] . '"id="img_winners" >\( ͡° ͜/// ͡°)/</a>' . '</th>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        else
        {
            echo "Waiting for results";
        }
    }
}