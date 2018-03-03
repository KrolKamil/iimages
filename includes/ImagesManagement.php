<?php

include 'DatabaseConnection.php';

class ImagesManagement extends DatabaseConnection
{
    public function UploadData()
    {

        if(isset($_POST['send']))
        {
            if (!file_exists($_FILES['image']['tmp_name'][0]) || !is_uploaded_file($_FILES['image']['tmp_name'][0]))
            {
                echo "Can't upload no existing file.";
            }
            else
            {
                for($i=0; $i<count($_FILES['image']['name']); $i++)
                {
                    $image = $_FILES['image']['name'][$i];

                    $target = "resources/images/" . basename($image);

                    $sql = "INSERT INTO images VALUES('','$image')";

                    $this->connect()->query($sql);

                    move_uploaded_file($_FILES['image']['tmp_name'][$i], $target);
                }
            }

        }
    }


    public function showImages()
    {
        $sql = "SELECT * FROM images";

        if($images = $this->connect()->query($sql))
        {
            while ($image = $images->fetch_array(MYSQLI_NUM)) {

                echo '<img src="resources/images/' . $image[1] . '" id="iimages" >';

            }
        }
    }

    public function deleteImages()
    {

        if(isset($_POST['delete']))
        {
            $sql = "SELECT image FROM images";

            if($images = $this->connect()->query($sql))
            {
                while($image = $images->fetch_array(MYSQLI_NUM))
                {
                    unlink('resources/images/' . $image[0]);
                }

                $sql = "TRUNCATE TABLE images";

                $this->connect()->query($sql);
            }
        }
    }

    public function deleteWinnersImages()
    {

        if(isset($_POST['deleteWinners']))
        {
            $sql = "SELECT image FROM images_winners";

            $result = $this->connect()->query($sql);

            if(count($result) > 0)
            {
                $sql = "TRUNCATE TABLE images_winners";

                $this->connect()->query($sql);
            }
        }
    }
}