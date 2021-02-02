<?php 
require('../app/functions.php');

$message = trim(filter_input(INPUT_GET,  'message'));
$username = trim(filter_input(INPUT_GET,  'username'));

$message = $message !== "" ? $message : '...';


include('../app/_parts/_header.php');
?>

<p><?= h($message); ?> by <?= h($username); ?></p>
<p><a href="index.php">Go back</a></p>


<?php
include('../app/_parts/_footer.php');