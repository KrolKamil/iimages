<?php
session_start();

require_once '../includes/init.php';

$myRedirect = new Redirect();
$myRedirect->ifRedirect();

?>
<!DOCTYPE html>
<html>
<?php
include '../includes/head.php';
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
            $myImagesManagement = new ImagesManagement();
            $myImagesManagment->UploadData();
            $myImagesManagment->deleteImages();
            $myImagesManagment->deleteWinnersImages();
            ?>

        </div>

        <div class="col-sm-6">
            <?php
            $myImagesManagment->showImages();
            ?>
        </div>
    </div>

</div>

</body>
</html>
