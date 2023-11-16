<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $codigo = $data['codigo'];

    // Buscar la posición del producto en el carrito
    $posicion = array_search($codigo, $_SESSION['carrito']);

    if ($posicion !== false) {
        // Eliminar el producto del carrito
        unset($_SESSION['carrito'][$posicion]);
        // Reindexar el array para evitar huecos
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}
?>
