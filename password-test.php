<?php

$test_string = "test1234";

$options = [ 'cost' => 12, ];

$hash = password_hash($test_string, PASSWORD_BCRYPT, $options);

$test = '$2$y12$TSLdNPVcXaCiUKo9U/RE5OqV91scR2WuRKC.VA28wRQv19i2iuXzy';

$test_string2 = "hahaha";

echo "\n";
echo "Password in plain text: " . $test_string2;
echo "\n";
echo "Password as hashed with BCRYPT and cost 12: " . $hash;
echo "\n";
echo "Test string from database: " . $test;
echo "\n";
echo "Going to test if the string matches the hash algorithm used to create it...";
echo "\n";
$pass = password_verify($test_string2, $test);
echo "\n";
echo "$pass";
echo "\n";
echo "Password verify: " . $pass;
echo "\n";

if (password_verify('test1234', $hash)) {
  echo "Password is valid!";
} else {
  echo "Invalid password.";
}

?>
