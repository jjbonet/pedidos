<?php
include 'conectar.php';

$id_articulos = $_POST['id_articulo'];
$quantities = $_POST['cantidad'];
$fecha_pedido = date('Y-m-d H:i:s');

// Insertar el pedido
$sql = "INSERT INTO ordenes (fecha) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha_pedido);
$stmt->execute();
$id_pedido = $stmt->insert_id;
$stmt->close();

// Insertar los elementos del pedido
foreach ($id_articulos as $index => $id_articulo) {
    $cantidad = $quantities[$index];

    // Obtener el precio del artículo
    $sql = "SELECT precio FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_articulo);
    $stmt->execute();
    $stmt->bind_result($precio);
    $stmt->fetch();
    $stmt->close();

    $total_precio = $precio * $cantidad;

    $sql = "INSERT INTO articulos_en_pedidos (id_pedido, id_articulo, cantidad, total) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $id_pedido, $id_articulo, $cantidad, $total_precio);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
echo "Pedido registrado exitosamente.";
?>
