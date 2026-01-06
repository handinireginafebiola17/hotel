<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Debug System</h2>";

// 1. Cek PHP Version
echo "<h3>1. PHP Info:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Error Reporting: " . ini_get('error_reporting') . "<br><br>";

// 2. Cek Koneksi Database
echo "<h3>2. Test Database Connection:</h3>";
$host  = "localhost";
$user  = "root";
$pass  = "";
$dbase = "db_hotel";
$port  = 3307;

// Try to connect
$koneksi = @mysqli_connect($host, $user, $pass, $dbase, $port);

if ($koneksi) {
    echo "✅ Database Connection SUCCESS<br>";
    echo "Host: $host:$port<br>";
    echo "Database: $dbase<br>";
    
    // Cek tabel
    $result = mysqli_query($koneksi, "SHOW TABLES LIKE 'tbl_kamar'");
    if (mysqli_num_rows($result) > 0) {
        echo "✅ Tabel 'tbl_kamar' ADA<br>";
        
        // Hitung jumlah data
        $count = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_kamar");
        $row = mysqli_fetch_assoc($count);
        echo "Jumlah data: " . $row['total'] . "<br>";
        
        // Tampilkan sample data
        $data = mysqli_query($koneksi, "SELECT * FROM tbl_kamar LIMIT 3");
        echo "<h4>Sample Data:</h4>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Tipe</th><th>Harga</th><th>Status</th></tr>";
        while($d = mysqli_fetch_assoc($data)) {
            echo "<tr>";
            echo "<td>" . $d['id_kamar'] . "</td>";
            echo "<td>" . $d['tipe_kamar'] . "</td>";
            echo "<td>" . $d['harga'] . "</td>";
            echo "<td>" . $d['status'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Tabel 'tbl_kamar' TIDAK ADA<br>";
    }
    
    mysqli_close($koneksi);
} else {
    echo "❌ Database Connection FAILED<br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
}

// 3. Cek File Structure
echo "<h3>3. File Structure Check:</h3>";
$files = [
    'koneksi.php' => file_exists('koneksi.php'),
    'dashboard.php' => file_exists('dashboard.php'),
    'menu.php' => file_exists('menu.php'),
    'form/kamar/view.php' => file_exists('form/kamar/view.php'),
    'form/kamar/form.php' => file_exists('form/kamar/form.php'),
    'form/kamar/edit.php' => file_exists('form/kamar/edit.php'),
    'form/kamar/proses_kamar.php' => file_exists('form/kamar/proses_kamar.php'),
];

foreach ($files as $file => $exists) {
    echo ($exists ? "✅ " : "❌ ") . $file . "<br>";
}

// 4. Cek Session
echo "<h3>4. Session Status:</h3>";
echo "Session Status: " . session_status() . " (";
switch(session_status()) {
    case PHP_SESSION_DISABLED: echo "Sessions are disabled"; break;
    case PHP_SESSION_NONE: echo "No active session"; break;
    case PHP_SESSION_ACTIVE: echo "Session is active"; break;
}
echo ")<br>";

// 5. Cek apakah ada GET parameter
echo "<h3>5. URL Parameters:</h3>";
echo "GET menu: " . (isset($_GET['menu']) ? $_GET['menu'] : 'NOT SET') . "<br>";
echo "GET id: " . (isset($_GET['id']) ? $_GET['id'] : 'NOT SET') . "<br>";

// 6. Test Simple Query
echo "<h3>6. Simple Query Test:</h3>";
if ($koneksi) {
    $test_query = "SELECT 1 as test";
    $test_result = mysqli_query($koneksi, $test_query);
    if ($test_result) {
        echo "✅ Basic query works<br>";
    } else {
        echo "❌ Basic query failed: " . mysqli_error($koneksi) . "<br>";
    }
}
?>