<!DOCTYPE html>
<html>
<head>
    <title>Mini Panel Apache Drill</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        textarea { width: 100%; height: 100px; }
        pre { background: #f4f4f4; padding: 10px; }
        button { padding: 8px 20px; }
    </style>
</head>
<body>
<h2>Mini Panel de Consultas a Apache Drill</h2>

<form method="post">
    <label>Escribe tu consulta SQL:</label><br>
    <textarea name="query"><?php echo htmlspecialchars($_POST['query'] ?? 'SELECT * FROM dfs.`/ruta/archivo.csv` LIMIT 10'); ?></textarea><br>
    <button type="submit">Ejecutar</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['query'])) {
    $query = $_POST['query'];
    $url = 'http://localhost:8047/query.json';
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
        echo '<p>Error: ' . curl_error($ch) . '</p>';
    } else {
        $result = json_decode($response, true);
        if (isset($result['errorMessage'])) {
            echo '<p style="color:red;">Error de Drill: ' . htmlspecialchars($result['errorMessage']) . '</p>';
        } else {
            echo '<h3>Resultado:</h3><pre>';
            print_r($result['rows']);
            echo '</pre>';
        }
    }
    curl_close($ch);
}
?>
</body>
</html>
