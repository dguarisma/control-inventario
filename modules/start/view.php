<!-- Content Header (Page header) -->
<section class="content-header my-4">
  <h2>
    <i class="fa fa-dashboard icon-title"></i> Inicio
  </h2>
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-dashboard"></i> Inicio</li>
  </ol>
</section>

<!-- Main content -->
<section class="content h-[80vh] overflow-x-auto">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Reporte de ventas <?= date("Y") ?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
              <p class="text-center">
                <strong>Compras &amp; Ventas <?= date("Y") ?></strong>
              </p>
              <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div><!-- /.col -->
            <div class="col-md-4">
              <!-- Info Boxes Style 2 -->
              <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-tags"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Inventario Neto</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    Productos en stock:
                    <?php
                    $query = "SELECT SUM(stock) AS total_stock FROM productos";
                    $resultado = $mysqli->query($query);
                    $fila = $resultado->fetch_assoc();
                    echo $fila['total_stock'];
                    ?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Ventas <?= date("Y") ?></span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    Facturas emitidas:
                    <?php
                    $query = "SELECT COUNT(*) AS total_ventas FROM ventas";
                    $resultado = $mysqli->query($query);
                    $fila = $resultado->fetch_assoc();
                    echo $fila['total_ventas'];
                    ?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              <div class="info-box bg-orange">
                <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Compras <?= date("Y") ?></span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    Compras realizadas:
                    <?php
                    $query = "SELECT COUNT(*) AS total_compras FROM compras";
                    $resultado = $mysqli->query($query);
                    $fila = $resultado->fetch_assoc();
                    echo $fila['total_compras'];
                    ?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              <div class="info-box bg-pink">
                <span class="info-box-icon"><i class="fa fa-users "></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Clientes</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    Clientes nuevos:
                    <?php
                    $query = "SELECT COUNT(*) AS total_clientes FROM clientes";
                    $resultado = $mysqli->query($query);
                    $fila = $resultado->fetch_assoc();
                    echo $fila['total_clientes'];
                    ?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- ./box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->

  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-8">
      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Últimas ventas</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th>Factura Nº</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th class="text-right">Total </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($mysqli, "SELECT v.id AS ventaId, v.numero_factura, v.total, c.nombre AS nombre_cliente, v.created AS fecha_venta, u.name_user AS nombre_usuario 
                FROM ventas v 
                JOIN clientes c ON c.id = v.cliente_id 
                JOIN usuarios u ON v.user_id = u.id_user 
                ORDER BY v.id DESC 
                LIMIT 10;
                ")
                  or die('error: ' . mysqli_error($mysqli));

                while ($data = mysqli_fetch_assoc($query)) {
                  $date = date('d-m-Y', strtotime($data['fecha_venta']));
                  ?>
                  <tr>
                    <td><a href="edit_sale.php?id=150"><?= $data['numero_factura'] ?></a></td>
                    <td><?= $data['nombre_cliente'] ?></td>
                    <td><?= $date ?></td>
                    <td class="text-right">180.00</td>
                  </tr>
                  <?php
                  $no++;
                }
                ?>
              </tbody>
            </table>
          </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="?route=add_ventas" class="btn btn-sm btn-default btn-flat pull-left">Nueva venta</a>
          <a href="?route=ventas" class="btn btn-sm btn-default btn-flat pull-right">Ver todas las facturas</a>
        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-4">


      <!-- PRODUCT LIST -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Nuevos productos</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <ul class="products-list product-list-in-box">
            <?php
            $query = mysqli_query($mysqli, "SELECT * FROM productos ORDER BY created_date DESC LIMIT 5")
              or die('error: ' . mysqli_error($mysqli));

            while ($data = mysqli_fetch_assoc($query)) {
              $precio_venta = format_rupiah($data['precio_venta']);
              $imageUrl = isset($data['image']) ? $data['image'] : '';
              $defaultImageUrl = 'images/user/user-default.png';
              $imageSrc = (!empty($imageUrl) && $imageUrl !== 'default') ? $imageUrl : $defaultImageUrl;
              ?>
              <li class="item">
                <div class="product-img">
                  <img src="<?= $imageSrc ?>" alt="Product Image">
                </div>
                <div class="product-info">
                  <a href="edit_product.php?id=10" class="product-title"><?= $data['precio_venta'] ?><span
                      class="label label-info pull-right"><?= $data['precio_venta'] ?></span></a>
                  <span class="product-description">
                    <?= $data['unidad'] ?> </span>
                </div>
              </li><!-- /.item -->
            <?php } ?>
          </ul>
        </div><!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="?route=products" class="uppercase">Ver todos los productos</a>
        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
<?php
include_once ('template/footer.php');

// Ejecutar la consulta SQL para obtener los datos de compras y ventas
$resultado = mysqli_query($mysqli, "
SELECT 'Compras' AS tipo, COUNT(*) AS cantidad, DATE_FORMAT(date_create, '%Y-%m-%d') AS fecha FROM compras GROUP BY fecha UNION ALL 
SELECT 'Ventas' AS tipo, COUNT(*) AS cantidad, DATE_FORMAT(created, '%Y-%m-%d') AS fecha FROM ventas GROUP BY fecha;
") or die(mysqli_error($mysqli));

// Inicializar un array para almacenar los datos
$data = array();

// Procesar los resultados y construir el formato deseado
while ($row = mysqli_fetch_assoc($resultado)) {
  $data[] =
    array("label" => $row['tipo'], "y" => (int) $row['cantidad']);
}

// Convertir el array a formato JSON
$json_data = json_encode($data);
?>
<script>
  window.onload = function () {
    var options = {
      title: {
      },
      data: [
        {
          type: "column",
          dataPoints: <?= $json_data ?>
        }
      ]
    };

    $("#chartContainer").CanvasJSChart(options);
  }
</script>