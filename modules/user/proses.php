<?php
session_start();

require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
	echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
} else {

	if ($_GET['act'] == 'insert') {
		$username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
		$password = md5(mysqli_real_escape_string($mysqli, trim($_POST['password'])));
		$name_user = mysqli_real_escape_string($mysqli, trim($_POST['name_user']));
		$permisos_acceso = mysqli_real_escape_string($mysqli, trim($_POST['permisos_acceso']));
		$image = isset($_POST["image"]) ? $_POST["image"] : "";
		// Evitar SQL Injection y crear consulta preparada
		$stmt = $mysqli->prepare("INSERT INTO usuarios 
		 (username, image, password, name_user, permisos_acceso, created_at)
		 VALUES (?, ?, ?, ?, ?, NOW())");
		$stmt->bind_param("sssss", $username, $image, $password, $name_user, $permisos_acceso);

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

	} elseif ($_GET['act'] == 'update') {
		// Variables recibidas del formulario
		$username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
		$password = md5(mysqli_real_escape_string($mysqli, trim($_POST['password'])));
		$name_user = mysqli_real_escape_string($mysqli, trim($_POST['name_user']));
		$id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
		$permisos_acceso = mysqli_real_escape_string($mysqli, trim($_POST['permisos_acceso']));
		$image = isset($_POST["image"]) ? $_POST["image"] : "";

		// Verificar si se proporcionó una contraseña
		$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

		// Preparar la consulta de actualización con marcadores de posición
		$sql = "UPDATE usuarios SET 
			username = ?,
			name_user = ?,
			permisos_acceso = ?";
		// Si se proporcionó una contraseña, agregarla a la consulta
		if (!is_null($password)) {
			$sql .= ", password = ?";
		}
		// Si se proporcionó una imagen, agregarla a la consulta
		if (!empty($image)) {
			$sql .= ", image = ?";
		}
		$sql .= " WHERE id_user = ?";

		// Preparar la consulta
		$stmt = $mysqli->prepare($sql);
		if ($stmt === false) {
			die('Error en la preparación de la consulta: ' . $mysqli->error);
		}

		// Vincular los parámetros a los marcadores de posición
		$params = array($username, $name_user, $permisos_acceso);
		if (!is_null($password)) {
			$params[] = $password;
		}
		$params[] = $id;

		// Si se proporcionó una imagen, vincularla
		if (!empty($image)) {
			$params[] = $image;
		}

		// Obtener el tipo de datos para los parámetros
		$types = str_repeat('s', count($params));

		// Vincular los parámetros
		$stmt->bind_param($types, ...$params);

		// Ejecutar la consulta
		if ($stmt->execute()) {
			$response = array(
				"status" => "success",
				"message" => "Actualización exitosa."
			);
			// Convertir el array a JSON y enviar la respuesta
			header('Content-Type: application/json');
			echo json_encode($response);
		} else {
			echo "Error al actualizar";
		}

		// Cerrar la consulta preparada
		$stmt->close();

	} elseif ($_GET['act'] == 'off') {
		$id = mysqli_real_escape_string($mysqli, $_POST['id']);
		$status = mysqli_real_escape_string($mysqli, $_POST['status']);
		$newStatus = ($status == 'activo') ? 'bloqueado' : 'activo';
		$query = mysqli_query($mysqli, "UPDATE usuarios SET status = '$newStatus' WHERE id_user = '$id'");

		if ($query) {
			$response = array(
				"status" => "success",
				"message" => "Actualización exitosa."
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