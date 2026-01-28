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

$result = $conn->query("SELECT * FROM pengaturan");
if ($result) {
    echo "Rows found: " . $result->num_rows . "\n";
    while ($row = $result->fetch_assoc()) {
        echo "Key: " . $row['h_key'] . " | Value: " . $row['h_value'] . "\n";
    }
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>