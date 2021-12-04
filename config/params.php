<?php

$local = include '_params.php';

return array_replace([
  'adminEmail'       => 'admin@example.com',
  'availableLocales' => [
    'en', 'ru',
  ],
], $local);
