<?php
echo "\n";
echo 'Password "' . $password . '" with PASSWORD_DEFAULT hash algorithm:';
echo "\n";
echo "\n";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
//echo password_hash($password, PASSWORD_DEFAULT);
echo "\n";
echo "Total Length: " . strlen($hash);
echo "\n";

$options = [
  'cost' => 12,
];
?>
