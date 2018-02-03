<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php
include 'resources/head.php';

class Upload
{
    //I FUCK UP IMAGES TABLE AND SENDING IMAGES
    public function UploadData()
    {
        global $conn;
        
        if(isset($_POST['send']))
        {
            $image = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $sql = "INSERT INTO images VALUES('','$image','$image_name')";

            $conn->query($sql);
        }
    }
}

$myUploadData = new Upload();

$myUploadData->UploadData();

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


        </div>

        <div class="col-sm-6">
            have no idea why divided
        </div>
    </div>

</div>

</body>
</html>
