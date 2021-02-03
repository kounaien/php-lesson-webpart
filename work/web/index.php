<?php

require('../app/functions.php');

createToken();

define('FILENAME', '../app/messages.txt');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  validateToken();
  
  $message = trim(filter_input(INPUT_POST, 'message'));
  $message = $message !== '' ? $message : '....';
  // $filename = '../app/messages.txt';
  $fp = fopen(FILENAME, 'a');
  fwrite($fp, $message . "\n");
  fclose($fp);

  header('Location: http://localhost:8080/result.php');
  exit;
  } 

// $filename = '../app/messages.txt';
$messages = file(FILENAME, FILE_IGNORE_NEW_LINES);
// $color = filter_input(INPUT_COOKIE, 'color') ?? 'transparent';




include('../app/_parts/_header.php');


$names = 
[
  'taro',
  'jiro',
  'saburo',
];
?>

    <ul> 
      <?php if (empty($names)) :?>
        <li>Nobody</li>
        <?php else: ?> 
          <p>Hello,!</p> 
          <?php foreach($names as $name): ?>
      <li><?= h($name); ?></li>
    <?php endforeach; ?>
    </ul>
          <?php endif; ?>

    <ul>
    <?php foreach ($messages as $message): ?>
    <li>
      <?= h($message); ?>
    </li>
      <?php endforeach; ?>
    </ul>


     <form action='index.php' method='post'>
      <input type="text" name='message'>
     <!-- <label>
            <input type="radio" name="color" value='orange'>orange
     </label>
     <label>
            <input type="radio" name="color" value='blue'>blue
     </label>
     <label>
            <input type="radio" name="color" value='yellow'>yellow
     </label> -->
     <!-- <select name="colors[]" id="" multiple>
            <option value="orange">orange</option>
            <option value="blue">blue</option>
            <option value="yellow">yellow</option>
     </select> -->
        <!-- <textarea name="message" id="" cols="10" rows="3"></textarea> -->
       <!-- <input type="text" name='message'> -->
       <!-- <input type="text" name='username'> -->
       <input type="hidden" name='token' value="<?= h($_SESSION['token']); ?>">
       <button>send</button>
       <!-- <a href="reset.php">[ reset ]</a> -->
     </form>
     
  <?php
    include('../app/_parts/_footer.php');