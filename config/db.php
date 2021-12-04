<?php

$local = include '_db.php';

return array_replace([
  'class'    => 'yii\db\Connection',
  'dsn'      => 'mysql:host=localhost;dbname=instablocker',
  'username' => 'username',
  'password' => 'password',
  'charset'  => 'utf8mb4',
], $local);
