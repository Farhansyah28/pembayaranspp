<?php
define('ENVIRONMENT', 'development');
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'pembayaranspp',
);
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$defaults = [
    ['nama_pesantren', 'Pesantren Digital'],
    ['alamat_pesantren', 'Jl. Merdeka No. 1, Jakarta'],
    ['telepon_pesantren', '081234567890'],
    ['logo_pesantren', 'logo.png']
];

foreach ($defaults as $d) {
    $key = $d[0];
    $val = $d[1];
    $check = $conn->query("SELECT id FROM pengaturan WHERE h_key = '$key'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO pengaturan (h_key, h_value) VALUES ('$key', '$val')");
        echo "Inserted $key\n";
    } else {
        echo "Skipped $key (already exists)\n";
    }
}

$conn->close();
?>