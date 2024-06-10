<?php
include 'conectar.php';

$id_articulo = $_GET['id'];

$sql = "SELECT precio FROM items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_articulo);
$stmt->execute();
$stmt->bind_result($precio);
$stmt->fetch();
$stmt->close();

echo $precio;
$conn->close();
?>
