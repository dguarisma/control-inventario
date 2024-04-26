<?php

require_once "config/database.php";

$username = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username'])))));
$password = md5(mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password']))))));

if (!ctype_alnum($username) or !ctype_alnum($password)) {
	echo "Usuario y/o contraseña incorrectos. Por favor, inténtalo de nuevo.";
} else {
	// Crear la consulta preparada con marcadores de posición (?)
	$sql = "SELECT * FROM usuarios WHERE username=? AND password=? AND status='activo'";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $username, $password);
	// Ejecutar la consulta
	if (!$stmt->execute()) {
		echo "Error al ejecutar la consulta: " . $stmt->error;
		exit;
	}

	// Obtener el resultado de la consulta
	$result = $stmt->get_result();

	if (!$result) {
		echo "Error al obtener el resultado de la consulta: " . $stmt->error;
		exit;
	}

	// Obtener el número de filas
	$rows = $result->num_rows;
	if ($rows === 1) {
		$data = mysqli_fetch_assoc($result);
		session_start();
		$_SESSION['id_user'] = $data['id_user'];
		$_SESSION['username'] = $data['username'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['name_user'] = $data['name_user'];
		$_SESSION['permisos_acceso'] = $data['permisos_acceso'];
		$response = array(
			"status" => "success",
			"url" => "main.php"
		);

		// Convertir el array a JSON
		$json_response = json_encode($response);
		// Enviar la respuesta JSON
		header('Content-Type: application/json');
		echo $json_response;
	} else {
		echo "Usuario y/o contraseña incorrectos. Por favor, inténtalo de nuevo.";
	}
}
?>