<?php

require('../app/functions.php');
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
     <form action='result.php' method='get'>
       <input type="text" name='message'>
       <button>send</button>
     </form>
     
  <?php
    include('../app/_parts/_footer.php');