<?php
include 'conectar.php';

// Obtener los artículos
$sql = "SELECT id, nombre, precio FROM items";
$result = $conn->query($sql);

$options = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['id']}'>{$row['nombre']} - $ {$row['precio']}</option>";
    }
} else {
    $options .= "<option>No hay artículos disponibles</option>";
}

echo $options;
$conn->close();
?>
