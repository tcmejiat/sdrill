
<!DOCTYPE html>
<html>
<head>
    <title>ETL Transporte Ecuador</title>
</head>
<body>
    <h1>Proceso ETL - Transporte Ecuador</h1>
    <form action="etl_process.php" method="post">
        <label>Ruta del archivo CSV:</label>
        <input type="text" name="file_path" placeholder="/data/transporte_inec_2013.csv" required><br><br>
        <label>Nombre de la tabla destino en MySQL:</label>
        <input type="text" name="table_name" required><br><br>
        <button type="submit">Iniciar ETL</button>
    </form>
</body>
</html>
