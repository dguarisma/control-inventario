<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
} else {
    if ($_GET['act'] == 'insert') {
        $codigo = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
        $nombre = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
        $precio_venta = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['precio_venta'])));
        $unidad = mysqli_real_escape_string($mysqli, trim($_POST['manufacturer_id']));
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
        $stock = mysqli_real_escape_string($mysqli, trim($_POST['stock']));
        $image = mysqli_real_escape_string($mysqli, trim($_POST['image']));
        $created_user = $_SESSION['id_user'];

        $stmt = $mysqli->prepare("INSERT INTO productos 
            (codigo, image, nombre, unidad, precio_venta, stock, created_user, updated_user, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $mysqli->error);
        }
        $stmt->bind_param(
            "ssssisiis",
            $codigo,
            $image,
            $nombre,
            $unidad,
            $precio_venta,
            $stock,
            $created_user,
            $created_user,
            $status
        );

        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "¡Producto creado con éxito!"
            );
            // Convertir el array a JSON y enviar la respuesta
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Error al guardar los datos";
        }

        // Cerrar la consulta preparada
        $stmt->close();

    } elseif ($_GET['act'] == 'edit') {

        $codigo = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
        $nombre = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
        $precio_venta = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['precio_venta'])));
        $unidad = mysqli_real_escape_string($mysqli, trim($_POST['manufacturer_id']));
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
        $id = mysqli_real_escape_string($mysqli, trim($_GET['id'])); // Usar el id en lugar de código
        $stock = mysqli_real_escape_string($mysqli, trim($_POST['stock']));
        $image = mysqli_real_escape_string($mysqli, trim($_POST['image']));
        $created_user = $_SESSION['id_user'];

        $stmt = $mysqli->prepare("UPDATE productos 
            SET image = ?, nombre = ?, unidad = ?, precio_venta = ?, stock = ?, status = ?, updated_user = ?
            WHERE id = ?"); // Usar el campo id en la cláusula WHERE
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $mysqli->error);
        }
        $stmt->bind_param(
            "ssssisii",
            $image,
            $nombre,
            $unidad,
            $precio_venta,
            $stock,
            $status,
            $created_user,
            $id
        );
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "¡Producto actualizado con éxito!"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Error al guardar los datos";
        }

        $stmt->close();

    } elseif ($_GET['act'] === 'delete') {
        $id = $_POST['id'];

        $query = mysqli_query($mysqli, "DELETE FROM productos WHERE id='$id'");
        if ($query) {
            $response = array(
                "status" => "success",
                "message" => "Borrado exitoso."
            );
            // Convertir el array a JSON y enviar la respuesta
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Error al actualizar";
        }
    }
}
?>