<?php
include 'conectar.php';

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los pedidos
$sql = "SELECT id_pedido, fecha FROM ordenes ORDER BY fecha DESC";
$result = $conn->query($sql);

$rows = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fecha_formateada = date('d/m/Y H:i', strtotime($row['fecha']));
        $rows .= "<tr>
                    <td>{$row['id_pedido']}</td>
                    <td>{$fecha_formateada}</td>
                    <td><a href='ver_ticket.php?id_pedido={$row['id_pedido']}' class='btn btn-info'>Ver Ticket</a></td>
                  </tr>";
    }
} else {
    $rows .= "<tr><td colspan='3'>No hay pedidos registrados</td></tr>";
}

echo $rows;
$conn->close();
?>
