
# Panel PHP + Apache Drill

## Descripción
Interfaz web que permite al usuario:
- Seleccionar tabla (CSV o JSON)
- Seleccionar columnas
- Especificar condición WHERE
- Ejecutar consulta dinámica a Apache Drill desde PHP

## Pre-Requisitos
- XAMPP o similar (servidor Apache + PHP). (Instalar)
- Apache Drill corriendo en http://localhost:8047 (Instalar)
- Archivos CSV/JSON ubicados en dfs.`default`.`/xampp\htdocs\sdrill/ (Configura la ruta en el archivo index.php)

## Cómo usar
1. Copia el archivo index.php en htdocs
2. Abre http://localhost/index.php
3. Selecciona tabla, columnas y condición
4. Verás la consulta generada y resultados

## Consultado y generado en mayo 2025
