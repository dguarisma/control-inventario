<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
} else {
    if ($_GET['act'] == 'insert') {
        // Obtener los datos del formulario y limpiarlos
        $razon_social = mysqli_real_escape_string($mysqli, trim($_POST['razon_social']));
        $RIF = mysqli_real_escape_string($mysqli, trim($_POST['RIF']));
        $telefono = mysqli_real_escape_string($mysqli, trim($_POST['telefono']));
        $ubicacion = mysqli_real_escape_string($mysqli, trim($_POST['ubicacion']));
        $referencia = mysqli_real_escape_string($mysqli, trim($_POST['referencia']));
        $user_id = $_SESSION['id_user'];

        // Evitar SQL Injection y crear consulta preparada
        $stmt = $mysqli->prepare("INSERT INTO proveedor 
                (razon_social, RIF, telefono, ubicacion, referencia, user_id, created)
                VALUES (?, ?, ?, ?, ?, ?, NOW())");

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        // Vincular los parámetros a los marcadores de posición
        $stmt->bind_param("sssssi", $razon_social, $RIF, $telefono, $ubicacion, $referencia, $user_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "Registro exitoso"
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

        // Obtener los datos del formulario y limpiarlos
        $razon_social = mysqli_real_escape_string($mysqli, trim($_POST['razon_social']));
        $RIF = mysqli_real_escape_string($mysqli, trim($_POST['RIF']));
        $telefono = mysqli_real_escape_string($mysqli, trim($_POST['telefono']));
        $ubicacion = mysqli_real_escape_string($mysqli, trim($_POST['ubicacion']));
        $referencia = mysqli_real_escape_string($mysqli, trim($_POST['referencia']));
        $user_id = $_SESSION['id_user'];
        $id = $_GET['id'];

        // Evitar SQL Injection y crear consulta preparada
        $stmt = $mysqli->prepare("UPDATE proveedor SET razon_social=?, RIF=?, telefono=?, ubicacion=?, referencia=?, user_id=? WHERE id=?");

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        // Vincular los parámetros a los marcadores de posición
        $stmt->bind_param("ssssssi", $razon_social, $RIF, $telefono, $ubicacion, $referencia, $user_id, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "Actualización exitosa"
            );
            // Convertir el array a JSON y enviar la respuesta
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Error al actualizar los datos";
        }

        // Cerrar la consulta preparada
        $stmt->close();


    } elseif ($_GET['act'] == 'delete') {
        $id_proveedor = mysqli_real_escape_string($mysqli, $_GET['id']);

        // Preparar la consulta para eliminar el proveedor
        $stmt = $mysqli->prepare("DELETE FROM proveedor WHERE id = ?");

        // Vincular el parámetro del ID del proveedor
        $stmt->bind_param("i", $id_proveedor);

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // Éxito al eliminar el proveedor
            $response = array(
                "status" => "success",
                "message" => "Proveedor eliminado exitosamente."
            );
            // Convertir el array a JSON y enviar la respuesta
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Error al ejecutar la consulta preparada
            $response = array(
                "status" => "success",
                "message" => "Error al eliminar el proveedor."
            );
            // Convertir el array a JSON y enviar la respuesta
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        // Cerrar la consulta preparada
        $stmt->close();
    } elseif ($_GET['act'] == 'select') {
        $id = mysqli_real_escape_string($mysqli, $_GET['id']);

        $sql = "SELECT * FROM proveedor WHERE id = ?";

        // Preparar y ejecutar la consulta
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                // Verificar si se obtuvieron resultados
                if ($result->num_rows > 0) {
                    // Devolver los datos del proveedor en formato JSON como un objeto
                    echo json_encode(array("status" => "success", "proveedor" => $result->fetch_object()));
                } else {
                    // Si no se encontró ningún proveedor con el ID proporcionado
                    echo json_encode(array("status" => "error", "message" => "No se encontró ningún proveedor con el ID proporcionado."));
                }
            } else {
                // Si hubo un error al ejecutar la consulta
                echo json_encode(array("status" => "error", "message" => "Error al ejecutar la consulta."));
            }
            $stmt->close(); // Cerrar la consulta preparada
        } else {
            // Si hubo un error al preparar la consulta
            echo json_encode(array("status" => "error", "message" => "Error al preparar la consulta."));
        }

    }
}
?>