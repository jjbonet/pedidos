<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Pedido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Ticket de Pedido</h1>
    <?php
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'bar_orders');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_articulo = $_POST['item'];

        // Obtener el artículo seleccionado de la base de datos
        $sql = "SELECT name, precio FROM items WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_articulo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p>Artículo: " . $row['name'] . "</p>";
            echo "<p>Precio: $" . $row['precio'] . "</p>";
        } else {
            echo "<p>Error: Artículo no encontrado</p>";
        }
        $stmt->close();
    } else {
        echo "<p>No se recibió ningún dato.</p>";
    }

    $conn->close();
    ?>
    <a href="index.php">Volver</a>
</body>
</html>
