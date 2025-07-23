
<?php
$file_path = $_POST['file_path'];
$table = $_POST['table_name'];

$query = "SELECT * FROM dfs.`$file_path`";

$ch = curl_init('http://drill:8047/query.json');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['queryType' => 'SQL', 'query' => $query]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$conn = new mysqli('mysql', 'root', 'rootpassword', 'etl_db');
foreach ($data['rows'] as $row) {
    $columns = implode(",", array_keys($row));
    $values = implode("','", array_map([$conn, 'real_escape_string'], array_values($row)));
    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
    $conn->query($sql);
}
$conn->close();

echo "✅ Proceso ETL completado exitosamente.";
?>
