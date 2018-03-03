<?php
session_start();

require_once '../includes/init.php';

?>
<!DOCTYPE html>
<html>
<?php
include '../includes/head.php';
?>
<body>

<div class="container">
    <h1>Winners</h1>
    <div class="row">
            <?php
            $myWinners = new Winners();
            $myWinners->ShowWinners();
            ?>

    </div>
</div>
</body>
</html>