<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
} else {
    if ($_GET['act'] == 'insert') {

        $numero_factura = mysqli_real_escape_string($mysqli, trim($_POST['numero_factura']));
        $cliente_id = mysqli_real_escape_string($mysqli, trim($_POST['cliente_id']));
        $created_user = $_SESSION['id_user'];

        $details_json = $_POST['details'];
        $details_array = json_decode($details_json);
        $total = 0;

        $query = "INSERT INTO ventas (cliente_id,user_id,total, numero_factura, created) 
                   VALUES ('$cliente_id','$created_user',0,$numero_factura , NOW())";
        // Ejecutar la consulta
        if (mysqli_query($mysqli, $query)) {
            $last_id = mysqli_insert_id($mysqli);
            // Iterar sobre cada detalle de la compra
            foreach ($details_array as $detail) {
                // Obtener los valores de cada propiedad del objeto
                $precio = mysqli_real_escape_string($mysqli, $detail->precio_venta);
                $cantidad = mysqli_real_escape_string($mysqli, $detail->cantidad);
                $codigo = mysqli_real_escape_string($mysqli, $detail->codigo);
                $id = mysqli_real_escape_string($mysqli, $detail->id);

                // Calcular el subtotal del detalle de la venta
                $subtotal = $precio * $cantidad;

                // Agregar el subtotal al total
                $total += $subtotal;

                // Insertar el detalle de la compra en la tabla 'detalles_ventas'
                $query = "INSERT INTO detalles_ventas (ventas_id, producto_id, precio, cantidad, created) 
                VALUES ('$last_id', '$id', '$precio', '$cantidad', NOW())";
                mysqli_query($mysqli, "UPDATE productos SET stock =  stock - '$cantidad' WHERE id = '$id'");
                mysqli_query($mysqli, "
                       INSERT INTO `transaccion_inventory`(`codigo_transaccion`,`fecha`, `codigo`, `numero`, `created_user`, `created_date`, `tipo_transaccion`) 
                           VALUES ($numero_factura,NOW(), '$codigo', ' $cantidad', '$created_user', NOW(), 'Salida')
                       ") or die(mysqli_error($mysqli));

                // Ejecutar la consulta
                if (mysqli_query($mysqli, $query)) {
                    // echo "Error al insertar datos: " . mysqli_error($mysqli);
                } else {
                    echo "Error al insertar detalle de ventas: " . mysqli_error($mysqli);
                }
            }

            $query_update_compra = "UPDATE ventas SET total = '$total' WHERE id = '$last_id'";
            if (mysqli_query($mysqli, $query_update_compra)) {
                $response = array(
                    "status" => "success",
                    "message" => "Orden de Venta creada exitosamente"
                );
                // Convertir el array a JSON y enviar la respuesta
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                echo "Error al insertar detalle de compra: " . mysqli_error($mysqli);
            }
        } else {
            echo "Error al insertar datos: " . mysqli_error($mysqli);
        }

    } elseif ($_GET['act'] == 'update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {

                $codigo = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
                $nombre = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
                $pventa = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['pventa'])));
                $unidad = mysqli_real_escape_string($mysqli, trim($_POST['unidad']));

                $updated_user = $_SESSION['id_user'];

                $query = mysqli_query($mysqli, "UPDATE productos SET  nombre       = '$nombre',
                                                                    precio_venta      = '$pventa',
                                                                    unidad          = '$unidad',
                                                                    updated_user    = '$updated_user'
                                                              WHERE codigo       = '$codigo'")
                    or die('error: ' . mysqli_error($mysqli));


                if ($query) {

                    header("location: ../../main.php?module=inventory&alert=2");
                }
            }
        }
    } elseif ($_GET['act'] == 'delete') {
        // Obtener el ID de la compra
        $ventas_id = mysqli_real_escape_string($mysqli, $_GET['id']);

        // Eliminar detalles_ventas relacionados con la compra específica
        $query_detalles = mysqli_query($mysqli, "DELETE FROM detalles_ventas WHERE ventas_id = '$ventas_id'")
            or die('Error al eliminar detalles_ventas: ' . mysqli_error($mysqli));

        // Verificar si la eliminación de detalles_ventas fue exitosa
        if ($query_detalles) {
            // Eliminar la compra correspondiente
            $query_compra = mysqli_query($mysqli, "DELETE FROM ventas WHERE id = '$ventas_id'")
                or die('Error al eliminar compra: ' . mysqli_error($mysqli));

            // Verificar si la eliminación de la compra fue exitosa
            if ($query_compra) {
                $response = array(
                    "status" => "success",
                    "message" => "Orden de Venta borrado exitosamente"
                );
                // Convertir el array a JSON y enviar la respuesta
                header('Content-Type: application/json');
                echo json_encode($response);

            } else {
                // Manejar el error si la eliminación de la compra falla
                die('Error al eliminar compra: ' . mysqli_error($mysqli));
            }
        } else {
            // Manejar el error si la eliminación de detalles_ventas falla
            die('Error al eliminar detalles_ventas: ' . mysqli_error($mysqli));
        }
    }
}
?>