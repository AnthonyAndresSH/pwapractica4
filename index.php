<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">    
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        body{
            background: #4e2ca7;
            color: #FFF;
        }
    </style>
</head>
<body>

    <?php
    $servername = "localhost";
    $username = "id21471118_clase4";
    $password = "Andres123**";
    $dbname = "id21471118_facturita";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT Codigo, Nombre, Descripcion, Precio FROM productos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <div class="container">
            <div class="row">
                <h2>Consulta de Productos</h2>
                <table>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>                    
                        <th>Accion</th>                    
                    </tr>

                    <?php
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["Codigo"] . "</td>
                                <td>" . $row["Nombre"] . "</td>
                                <td>" . $row["Descripcion"] . "</td>
                                <td>" . $row["Precio"] . "</td>
                                <td><img src='img/img".$row["Codigo"].".PNG'  alt='Imagen del producto' style='width: 100px; height: 100px;' ></td>
                                <td>  <button class='btn btn-primary' onclick='AgregarAlCarrito(" . $row["Codigo"] . ", \"" . $row["Nombre"] . "\", " . $row["Precio"] . ")'>Agregar</button> </td>
                                     
                              </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No se encontraron productos.";
                }

                $conn->close();
                ?>
                <h2>Carrito de compras  </h2>
                <table id="carrito">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </table>
            </div>
        </div>

        </body>
        <script>
    function AgregarAlCarrito(codigo, nombre,precio) {
        // Crear un nuevo objeto para enviar al servidor
        var producto = {
            codigo: codigo,
            nombre: nombre,
            precio: precio
        };

        // Enviar la información al servidor mediante AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "agregar_al_carrito.php", true);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Actualizar la tabla del carrito después de la respuesta del servidor
                var carritoTable = document.getElementById("carrito");
                var newRow = carritoTable.insertRow(-1); // Insertar al final de la tabla

                var cellCodigo = newRow.insertCell(0);
                var cellNombre = newRow.insertCell(1);
                var cellPrecio = newRow.insertCell(2);
                var cellAcciones = newRow.insertCell(3);

                cellCodigo.innerHTML = codigo;
                cellNombre.innerHTML = nombre;
                cellPrecio.innerHTML = precio;
                cellAcciones.innerHTML = "<button class='btn btn-danger' onclick='EliminarDelCarrito(this)'>Eliminar</button>";
            }
        };
        xhr.send(JSON.stringify(producto));
    }

    function EliminarDelCarrito(button) {
        // Obtener la fila actual
        var row = button.parentNode.parentNode;

        // Obtener el código del producto a eliminar
        var codigo = row.cells[0].innerHTML;

        // Enviar la información al servidor mediante AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_del_carrito.php", true);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Eliminar la fila del carrito después de la respuesta del servidor
                row.parentNode.removeChild(row);
            }
        };
        xhr.send(JSON.stringify({ codigo: codigo }));
    }
</script>


</html>
