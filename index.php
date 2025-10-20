<?php
// ejemplo simple de tablas y columnas
$tablas = ['sample.csv', 'datos.json'];
$columnas = ['id','nombre','edad','ciudad','pais','*']; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consulta Apache Drill</title>
</head>
<body>
<h2>Consulta Apache Drill</h2>
<form method="post">
    <label>Tabla:</label>
    <select name="tabla">
        <?php foreach($tablas as $tabla): ?>
            <option value="<?= htmlspecialchars($tabla) ?>"><?= htmlspecialchars($tabla) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Columnas:</label><br>
    <?php foreach($columnas as $col): ?>
        <input type="checkbox" name="columnas[]" value="<?= htmlspecialchars($col) ?>"> <?= htmlspecialchars($col) ?><br>
    <?php endforeach; ?>
    <br>

    <label>Condición WHERE (opcional):</label><br>
    <input type="text" name="condicion" placeholder="ej: edad > 30"><br><br>

    <input type="submit" value="Ejecutar Consulta">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tabla = $_POST['tabla'];
    $columnas = $_POST['columnas'] ?? [];
    $condicion = trim($_POST['condicion']);

    if (empty($columnas)) {
        echo "Selecciona al menos una columna.";
        exit;
    }

    // Construir consulta
    $cols = implode(', ', array_map('trim', $columnas));
    $sql = "SELECT $cols FROM dfs.`default`.`/xampp\htdocs\sdrill/$tabla`";
    if ($condicion !== '') {
        $sql .= " WHERE $condicion";
    }

    echo "<p><strong>Consulta generada:</strong> ".htmlspecialchars($sql)."</p>";

    // Ejecutar consulta en Drill
    $query = ['queryType' => 'SQL', 'query' => $sql];
    $ch = curl_init('http://localhost:8047/query.json');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    // Mostrar resultados
    if (!empty($data['rows'])) {
        echo "<table border='1'><tr>";
        foreach (array_keys($data['rows'][0]) as $col) {
            echo "<th>".htmlspecialchars($col)."</th>";
        }
        echo "</tr>";
        foreach ($data['rows'] as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                // CORRECCIÓN: Verificar si $value es una cadena antes de aplicar htmlspecialchars()
                echo "<td>";
                if (is_string($value)) {
                    echo htmlspecialchars($value);
                } elseif (is_array($value)) {
                    // Si el valor es un array, lo convertimos a una cadena JSON para mostrarlo
                    echo htmlspecialchars(json_encode($value));
                } else {
                    // Para otros tipos de datos, como null o números, simplemente los mostramos
                    echo htmlspecialchars(print_r($value, true));
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay resultados o error en la consulta.";
    }
}
?>
</body>
</html>