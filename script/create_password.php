<?php
// Script untuk membuat password hash
$password = 'password'; // Ganti dengan password yang diinginkan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "<br>";
echo "Hashed: " . $hashed_password . "<br>";

// Untuk verifikasi
if (password_verify($password, $hashed_password)) {
    echo "Password cocok!";
} else {
    echo "Password tidak cocok!";
}
?>