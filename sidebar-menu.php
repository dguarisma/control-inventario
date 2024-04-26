<?php

$route = $_GET['route'] ?? '';
?>

<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<ul class="sidebar-menu">
			<li class="header">MENÚ</li>
			<li class="active">
				<a href="main.php">
					<i class="fa fa-home"></i> <span>Inicio</span>
				</a>
			</li>
			<li class="treeview <?php echo ($route === 'clientes' || $route === 'proveedores') ? 'active' : ''; ?>">
				<a href="#">
					<i class="fa fa-user"></i>
					<span>Contactos</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?= $route === 'clientes' ? 'active' : ''; ?>">
						<a href="?route=clientes"><i class="glyphicon glyphicon-user"></i>
							Clientes
						</a>
					</li>
					<li class="<?= $route === 'proveedores' ? 'active' : ''; ?>">
						<a href="?route=proveedores"><i class="glyphicon glyphicon-briefcase"></i>
							Proveedores
						</a>
					</li>

				</ul>
			</li>
			<li class="treeview <?php echo ($route === 'compras' || $route === 'add_compras') ? 'active' : ''; ?>">
				<a href="?route=product_transaction">
					<i class="fa fa-truck"></i>
					<span>Compras</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?= $route === 'add_compras' ? 'active' : ''; ?>">
						<a href="?route=add_compras">
							<i class="glyphicon glyphicon-shopping-cart"></i>
							Nueva compra
						</a>
					</li>
					<li class="<?= $route === 'compras' ? 'active' : ''; ?>">
						<a href="?route=compras">
							<i class="glyphicon glyphicon-th-list"></i>
							Historial de compras
						</a>
					</li>
				</ul>
			</li>
			<li
				class="treeview <?php echo ($route === 'products' || $route === 'add_product' || $route === 'edit_product') ? 'active' : ''; ?>">
				<a href="?route=products">
					<i class="glyphicon glyphicon-th-large"></i> <span>Productos</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?= $route === 'add_product' ? 'active' : ''; ?>">
						<a href="?route=add_product&form=add">
							<i class="glyphicon glyphicon-th-list"></i>
							Nuevo Producto
						</a>
					</li>
					<li class="<?= $route === 'products' ? 'active' : ''; ?>">
						<a href="?route=products">
							<i class="glyphicon glyphicon-shopping-cart"></i>
							Productos
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($route === 'ventas' || $route === 'add_ventas') ? 'active' : ''; ?>">
				<a href="#">
					<i class="fa fa-dollar"></i> <span>Facturación</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?= $route === 'ventas' ? 'active' : ''; ?>">
						<a href="?route=add_ventas&form=add">
							<i class="fa fa-cart-plus"></i>
							Nueva venta
						</a>
					</li>
					<li class="<?= $route === 'add_ventas' ? 'active' : ''; ?>">
						<a href="?route=ventas&form=add">
							<i class="glyphicon glyphicon-list-alt"></i>
							Administrar facturas
						</a>
					</li>
				</ul>
			</li>
			<li
				class="treeview <?php echo ($route === 'reporte-ventas' || $route === 'reporte-compras' || $route === 'inventory') ? 'active' : ''; ?>">
				<a href="#">
					<i class="glyphicon glyphicon-signal"></i> <span>Reportes</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?= $route === 'inventory' ? 'active' : ''; ?>">
						<a href="?route=inventory"><i class="fa fa-bar-chart"></i>
							Reporte de inventario
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview <?php echo ($route === 'user' || $route === 'add_user') ? 'active' : ''; ?>">
				<a href="#">
					<i class="fa fa-lock"></i> <span>Administrar accesos</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?= $route === 'user' ? 'active' : ''; ?>">
						<a href="?route=user"><i class="fa fa-users"></i> Usuarios</a>
					</li>
					<li class="<?= $route === 'add_user' ? 'active' : ''; ?>">
						<a href="?route=add_user"><i class="glyphicon glyphicon-briefcase"></i>
							Agregar Usuario
						</a>
					</li>
				</ul>
			</li>
			<li class="treeview">
				<a href="?route=respaldo">
					<i class="fa fa-wrench"></i> <span>Configuración</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>