<?php
include 'conectar.php';

$id_pedido = $_GET['id_pedido'];

$sql = "SELECT o.id_pedido, o.fecha, i.nombre, io.cantidad, io.total
        FROM ordenes o
        JOIN articulos_en_pedidos io ON o.id_pedido = io.id_pedido
        JOIN items i ON io.id_articulo = i.id
        WHERE o.id_pedido = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();

$articulos_pedido = [];
while ($row = $result->fetch_assoc()) {
    $row['fecha'] = date('d/m/Y H:i', strtotime($row['fecha']));
    $articulos_pedido[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .ticket {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-detail {
            margin-bottom: 10px;
        }
        .ticket-detail span {
            font-weight: bold;
        }
        .print-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Ticket de Pedido</h1>
        <?php if (!empty($articulos_pedido)): ?>
            <div class="ticket-detail"><span>ID del Pedido:</span> <?php echo $articulos_pedido[0]['id_pedido']; ?></div>
            <div class="ticket-detail"><span>Fecha:</span> <?php echo $articulos_pedido[0]['fecha']; ?></div>
            <h2>Detalles del Pedido:</h2>
            <?php foreach ($articulos_pedido as $item): ?>
                <div class="ticket-detail"><span>Artículo:</span> <?php echo $item['nombre']; ?></div>
                <div class="ticket-detail"><span>Cantidad:</span> <?php echo $item['cantidad']; ?></div>
                <div class="ticket-detail"><span>Total:</span> $<?php echo $item['total']; ?></div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron detalles para este pedido.</p>
        <?php endif; ?>
        <button class="btn btn-primary print-btn" onclick="window.print()">Imprimir Ticket</button>
    </div>
</body>
</html>
