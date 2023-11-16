<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $codigo = $data['codigo'];
    $nombre = $data['nombre'];

    // Verificar si el producto ya está en el carrito
    if (!in_array($codigo, $_SESSION['carrito'])) {
        // Agregar el producto al carrito
        $_SESSION['carrito'][] = $codigo;

        // Actualizar la tabla del carrito
        echo "<tr>
                <td>" . $codigo . "</td>
                <td>" . $nombre . "</td>
                <td>Precio del producto</td>
                <td><button onclick='EliminarDelCarrito(this)'>Eliminar</button></td>
              </tr>";
    } else {
        echo "Producto ya en el carrito";
    }
}
?>
