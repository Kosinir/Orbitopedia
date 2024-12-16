<?php
// Hasło, które chcesz zaszyfrować
$password = "Student1";

// Szyfrowanie hasła
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Wyświetlenie zaszyfrowanego hasła
echo "Zaszyfrowane hasło: " . $hashedPassword;
?>
