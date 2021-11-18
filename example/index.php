<?php

use Argo\Password;

require_once __DIR__ . '/../vendor/autoload.php';

$passwordStr = '@bc$ldAlW_0-3989mld';
// $passwordStr = 'abc';
// $passwordStr = 'qwerty123';
// $passwordStr = 'dsjakljdsa90jkl3210dsjkal';
$pepper = 'y7Bz2wutmN6fBBELEAllkICfRhK3j1Tj';
$password = new Password();
$hashRes = $password->hash($passwordStr, [
  'pepper' => $pepper,
]);
$verified = $password->verify($passwordStr, $hashRes);
echo PHP_EOL;
echo json_encode(
  [
    'passwordStr' => $passwordStr,
    'pepper' => $pepper,
    'hashRes' => $hashRes,
    'verified' => $verified,
  ],
  JSON_PRETTY_PRINT
);
echo PHP_EOL;

echo PHP_EOL;
