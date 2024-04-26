<?php
require_once "config/database.php";
require_once "config/fungsi_tanggal.php";
require_once "config/fungsi_rupiah.php";

// Verificar si no hay sesión iniciada
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
	// Redirigir a la página de inicio
	echo "<meta http-equiv='refresh' content='0; url=index.php'>";
} else {
	// Obtener el módulo solicitado
	$route = $_GET['route'] ?? '';
	// Si la ruta es main.php sin parámetros, redirigir al home
	if ($route === '' || $route === 'main.php') {
		include 'modules/start/view.php';
	} else {
		// Array asociativo que mapea los módulos a sus archivos correspondientes
		$routes = array(
			'home' => 'modules/start/view.php',
			'user' => 'modules/user/view.php',
			'proveedores' => 'modules/proveedores/view.php',
			'clientes' => 'modules/clientes/view.php',
			'add_user' => 'modules/user/form.php',
			'respaldo' => 'modules/respaldo/view.php',
			'edit_user' => 'modules/user/edit.php',
			'products' => 'modules/products/view.php',
			'edit_product' => 'modules/products/edit.php',
			'add_product' => 'modules/products/form.php',
			'compras' => 'modules/compras/view.php',
			'add_compras' => 'modules/compras/form.php',
			'ventas' => 'modules/ventas/view.php',
			'add_ventas' => 'modules/ventas/form.php',
			'form_product_transaction' => 'modules/product_transaction/form.php',
			'menu' => 'modules/menu/view.html',
			'inventory' => 'modules/inventory/view.php',
			'profile' => 'modules/profile/view.php',
			'form_profile' => 'modules/profile/form.php',
			'password' => 'modules/password/view.php'
		);

		// Verificar si el módulo existe en el array
		if (array_key_exists($route, $routes)) {
			// Incluir el archivo del módulo correspondiente
			include $routes[$route];
		} else {
			// Manejar el caso en que el módulo solicitado no exista
			include '404.php';
		}
	}
}
