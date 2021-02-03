<?php 

require('../app/functions.php');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// $message = trim(filter_input(INPUT_POST, 'message'));
// $message = $message !== '' ? $message : '....';
// $filename = '../app/messages.txt';
// $fp = fopen($filename, 'a');
// fwrite($fp, $message . "\n");
// fclose($fp);
// } else {
//   exit('Invalid Request');
// }


// $message = trim(filter_input(INPUT_GET,  'message'));
// $username = trim(filter_input(INPUT_GET,  'username'));

// $message = $message !== "" ? $message : '...';

// $colors = filter_input(INPUT_GET, 'colors', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
// $colors = empty($colors) ? 'None selected' : implode(',', $colors);

// $color = filter_input(INPUT_GET, 'color');
// $color =isset($color) ? $color : 'None selected';
// $color = $color ?? 'transparent';
// $colorFromGet = filter_input(INPUT_GET, 'color') ?? 'transparent';
// setcookie('color', $colorFromGet);
// $_SESSION['color'] = $colorFromGet;


include('../app/_parts/_header.php');
?>


<p><a href="index.php">Go back</a></p>


<?php
include('../app/_parts/_footer.php');