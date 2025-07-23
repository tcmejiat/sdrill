<?php
$url = 'http://localhost:8047/query.json';

$query = "SELECT * FROM dfs.`/ruta/datos.json` LIMIT 10";

$data = json_encode([
    'queryType' => 'SQL',
    'query' => $query
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    $result = json_decode($response, true);
    if (isset($result['errorMessage'])) {
        echo 'Error de Drill: ' . $result['errorMessage'];
    } else {
        echo '<pre>';
        print_r($result['rows']);
        echo '</pre>';
    }
}
curl_close($ch);
?>
