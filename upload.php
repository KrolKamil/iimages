<?php
session_start();

include 'resources/connection.php';

class Upload
{
    //I FUCK UP IMAGES TABLE AND SENDING IMAGESd
    public function UploadData()
    {
        global $conn;

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

                    $conn->query($sql);

                    move_uploaded_file($_FILES['image']['tmp_name'][$i], $target);
                }
            }

        }
    }


    public function showImages()
    {
        global $conn;

        $sql = "SELECT * FROM images";

        if($images = $conn->query($sql))
        {
            while ($image = $images->fetch_array(MYSQLI_NUM)) {

                echo '<img src="resources/images/' . $image[1] . '" id="iimages" >';

            }
        }
    }

    public function deleteImages()
    {
        global $conn;

        if(isset($_POST['delete']))
        {
            $sql = "SELECT image FROM images";

            if($images = $conn->query($sql))
            {
                while($image = $images->fetch_array(MYSQLI_NUM))
                {
                    unlink('resources/images/' . $image[0]);
                }

                $sql = "TRUNCATE TABLE images";

                $conn->query($sql);
            }
        }
    }

    public function deleteWinnersImages()
    {
        global $conn;

        if(isset($_POST['deleteWinners']))
        {
            $sql = "SELECT image FROM images_winners";

            $result = $conn->query($sql);

            if(count($result) > 0)
            {
                $sql = "TRUNCATE TABLE images_winners";

                $conn->query($sql);
            }
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
                header("Location: index.php");
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

$myUploadData = new Upload();

$myUploadData->ifRedirect();


?>
<!DOCTYPE html>
<html>
<?php
include 'resources/head.php';
?>
<body>
<div class="container">
    <h1>Upload Images</h1>
    <div class="row">
        <div class="col-sm-6">

            <form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image[]" multiple/>
                <br>
                <input type="hidden" name="send" value="1">
                <button type="submit" class="btn">Upload</button>
            </form>

            <br>
            <a href="control.php"><button type="button" class="btn" name="btn_upload" value="1">Back</button></a>

            <br><br><br><br>
            <form action="upload.php" method="post">
                <input type="hidden" name="delete" value="1">
                <button type="submit" class="btn btn-danger">DELETE ALL IMAGES</button>
            </form>

            <br><br><br><br>
            <form action="upload.php" method="post">
                <input type="hidden" name="deleteWinners" value="1">
                <button type="submit" class="btn btn-danger">DELETE WINNERS IMAGES</button>
            </form>

            <br>

            <?php

            $myUploadData->UploadData();

            $myUploadData->deleteImages();

            $myUploadData->deleteWinnersImages();
            ?>

        </div>

        <div class="col-sm-6">
            <?php
            $myUploadData->showImages();
            ?>
        </div>
    </div>

</div>

</body>
</html>
