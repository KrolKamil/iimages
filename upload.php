<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php
include 'resources/head.php';

class Upload
{
    //I FUCK UP IMAGES TABLE AND SENDING IMAGESd
    public function UploadData()
    {
        global $conn;

        if(isset($_POST['send']))
        {
            if (!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name']))
            {
                echo "Can't upload no existing file.";
            }
            else
            {
                $image = $_FILES['image']['name'];

                $target = "resources/images/" . basename($image);

                $sql = "INSERT INTO images VALUES('','$image')";

                $conn->query($sql);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target))
                {
                    echo "Image uploaded successfully";
                }
                else
                {
                    echo "Failed to upload image";
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

                echo "<img src='resources/images/" . $image[1] . "' >";

            }
        }
    }



}

?>
<body>
<div class="container">
    <h1>Upload Images</h1>
    <div class="row">
        <div class="col-sm-6">

            <form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image"/>
                <br>
                <input type="hidden" name="send" value="1">
                <button type="submit" class="btn">Upload</button>
            </form>

            <br>
            <a href="/iimages/control.php"><button type="button" class="btn" name="btn_upload" value="1">Back</button></a>

            <?php
            $myUploadData = new Upload();

            $myUploadData->UploadData();
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
