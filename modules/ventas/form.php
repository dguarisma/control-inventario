<main>

  <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
        </div>
        <div class="modal-body">
          <!--      <form class="form-horizontal">
            <div class="form-group">
              <div class="col-sm-6">
                <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
              </div>
              <button type="button" class="btn btn-default" onclick="load(1)"><span
                  class="glyphicon glyphicon-search"></span> Buscar</button>
            </div>
          </form> -->
          <div id="loader" style="position: absolute; text-align: center; top: 55px; width: 100%;"></div>
          <!-- Carga gif animado -->
          <div class="outer_div">
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr class="warning">
                    <th>ID</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th><span class="pull-right">Cant.</span></th>
                    <th><span class="pull-right">Costo</span></th>
                    <th style="width: 36px;"></th>
                  </tr>
                  <?php
                  // Realizar la consulta SQL para obtener todos los proveedores
                  $sql = "SELECT * FROM productos";
                  $resultado = $mysqli->query($sql);
                  // Iterar sobre cada fila de resultados
                  while ($row = $resultado->fetch_assoc()) {
                    $fila_json = json_encode($row);
                    ?>
                    <tr>
                      <td><?= $row['id'] ?></td>
                      <td><?= $row['codigo'] ?></td>
                      <td><?= $row['nombre'] ?></td>
                      <td class="col-xs-1">
                        <div class="pull-right">
                          <input type="text"
                            class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                            style="text-align:right" name="cantidad[]" value="1">
                        </div>
                      </td>

                      <td class="col-xs-2">
                        <div class="input-group pull-right">
                          <input type="text"
                            class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                            style="text-align:right" name="precio_vent[]" value="<?= $row['precio_venta'] ?>">
                        </div>
                      </td>
                      <td><span class="pull-right">
                          <?php echo '<a href="#" class="agregar-producto"
                            data-fila="' . htmlspecialchars($fila_json, ENT_QUOTES, 'UTF-8') . '"><i
                              class="glyphicon glyphicon-shopping-cart "
                              style="font-size:24px;color: #5CB85C;"></i></a>' ?>
                        </span>
                      </td>
                    </tr>
                    <?php
                  }
                  // Liberar el resultado
                  $resultado->free();
                  ?>

                </tbody>
              </table>
            </div>
          </div><!-- Datos ajax Final -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-edit"></i> Agregar nueva venta</h1>

  </section>
  <!-- Main content -->
  <section class="content w-full h-[80vh] overflow-x-auto">
    <!-- Default box -->
    <form method="post" id="new_purchase">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Nueva Venta</h3>
        </div>
        <div class="box-body h-[80vh] ">
          <div class="row">
            <!-- *********************** Purchase ************************** -->
            <div class="col-md-12 col-sm-12">
              <div class="box box-info">
                <div class="box-header box-header-background-light with-border">
                  <h3 class="box-title">Detalles de la Factura</h3>
                </div>
                <div class="box-background">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-5">
                        <label class="font-bold">Clientes</label>
                        <div class="input-group w-full">
                          <select
                            class="js-example-basic-single placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                            name="cliente_id" required>
                            <option value="">Selecciona Cliente</option>
                            <?php
                            // Realizar la consulta SQL para obtener todos los proveedores
                            $sql = "SELECT * FROM clientes";
                            $resultado = $mysqli->query($sql);
                            // Iterar sobre cada fila de resultados
                            while ($row = $resultado->fetch_assoc()) {
                              // Obtener los datos relevantes de la fila
                              $id = $row['id'];
                              $nombre = $row['nombre'];

                              // Imprimir una opción HTML para cada proveedor
                              echo "<option value=\"$id\">$nombre</option>";
                            }

                            // Liberar el resultado
                            $resultado->free();
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="font-bold">Fecha</label>
                        <div class="input-group">
                          <input type="text"
                            class="placeholder-gray-500 pl-10 pr-4 bg-gray-100 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                            name="purchase_date" value="<?= date("d/m/Y") ?>" readonly="">
                        </div>
                      </div>
                      <div class="col-md-2">

                        <label class="font-bold">Factura Nº</label>
                        <input type="text"
                          class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                          name="numero_factura" id="order_number" required>
                      </div>

                      <div class="col-md-2">
                        <label class="font-bold">Agregar productos</label>
                        <button type="button" class="btn btn-block btn-info" data-toggle="modal"
                          data-target="#myModal"><i class="fa fa-search"></i> Buscar productos</button>
                      </div>
                    </div>

                  </div><!-- /.box-body -->
                </div>

              </div>
              <!-- /.box -->

            </div>
            <!--/.col end -->
          </div>
          <div id="resultados" class="col-md-12" style="margin-top:4px">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>CODIGO</th>
                  <th>NOMBRE</th>
                  <th class="text-center">CANT.</th>
                  <th><span class="pull-right">PRECIO UNIT.</span></th>
                  <th><span class="pull-right">PRECIO TOTAL</span></th>
                  <th></th>
                </tr>
                <tbody id="renderRows">
                </tbody>
                <tr>
                  <td colspan="4"><span class="pull-right">TOTAL $</span></td>
                  <td><span class="pull-right" id="filaTotal">0.00</span></td>
                  <td></td>
                </tr>

              </table>
            </div>
          </div><!-- Carga los datos ajax -->
          <div class="flex flex-row w-full justify-center items-center gap-5 ">
            <input type="submit"
              class="flex items-center justify-center focus:outline-none text-white bg-[#3BB1DC] hover:bg-[#3BB1DC]/90 rounded py-2 w-[20%] transition duration-150 ease-in"
              name="Guardar" value="Guardar">
            <a href="?route=compras"
              class="flex items-center justify-center border border-gray-400 hover:border-[#3BB1DC]/50 focus:outline-none hover:text-white bg-white hover:bg-[#3BB1DC]/50 rounded py-2 w-[20%] transition duration-150 ease-in">Cancelar</a>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </form>
  </section><!-- /.content -->
</main>

<?php
include_once ('template/footer.php');
?>
<script>

  var productosAgregados = [];
  function renderizarProductos() {
    var total = 0;
    // Limpiar el contenido actual de la tabla
    $('#renderRows').empty();
    // Iterar sobre los productos agregados
    productosAgregados.forEach(function (producto) {
      // Calcular el precio total del producto
      var precioTotalProducto = producto.precio_venta * producto.cantidad;
      // Agregar el precio total del producto al total general
      total += precioTotalProducto;
      // Crear una fila de la tabla con la información del producto
      var fila = `
          <tr>
            <td>${producto.codigo}</td>
            <td>${producto.nombre}</td>
            <td class="text-center">${producto.cantidad}</td>
            <td class="pull-right"><span class="pull-right">${producto.precio_venta}</span></td>
            <td><span class="pull-right">${precioTotalProducto}</span></td>
            <td><span class="pull-right"><a href="#" onclick="eliminar('${producto.id}')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
          </tr>`;
      // Agregar la fila a la tabla
      $('#renderRows').append(fila);
    });
    $('#filaTotal').text(total.toFixed(2));
  }

  function eliminar(idProducto) {
    // Buscar el índice del producto a eliminar
    var index = productosAgregados.findIndex(function (producto) {
      return producto.id === idProducto;
    });

    // Verificar si se encontró el producto
    if (index !== -1) {
      // Eliminar el producto del array
      productosAgregados.splice(index, 1);
      // Renderizar nuevamente la lista de productos
      renderizarProductos();
    } else {
      console.log("El producto no se encontró en la lista:", idProducto);
    }
  }
  $(function () {
    // Llamar a la función para renderizar los productos cuando sea necesario
    $('.agregar-producto').click(function () {
      // Obtener la fila correspondiente al botón clickeado
      var fila = $(this).closest('tr');
      // Obtener el ID del producto
      var idProducto = fila.find('td:eq(0)').text();
      var codigo = fila.find('td:eq(1)').text();
      // Obtener el nombre del producto
      var nombreProducto = fila.find('td:eq(2)').text();
      // Obtener el valor de cantidad y precio de venta de la fila actual
      var cantidad = fila.find('input[name="cantidad[]"]').val();
      var precio_venta = fila.find('input[name="precio_vent[]"]').val();

      // Validar si el producto ya ha sido agregado
      var productoExistente = productosAgregados.find(function (producto) {
        return producto.id === idProducto;
      });

      if (productoExistente) {
        // Si el producto ya existe, actualizar el precio de venta si es diferente
        if (productoExistente.precio_venta !== precio_venta || productoExistente.cantidad !== cantidad) {
          productoExistente.precio_venta = precio_venta;
          productoExistente.cantidad = cantidad;
        }
      } else {
        // Si el producto no existe, agregarlo al array productosAgregados
        var nuevoProducto = {
          id: idProducto,
          nombre: nombreProducto,
          codigo: codigo,
          cantidad: cantidad,
          precio_venta: precio_venta
        };
        productosAgregados.push(nuevoProducto);
      }
      renderizarProductos();
    });
    $('#new_purchase').submit(function (event) {
      // Evitar que el formulario se envíe de forma predeterminada
      event.preventDefault();
      // Obtener los datos del formulario
      const formData = new FormData(this);
      const serializedData = $(this).serialize();
      formData.append('existingData', serializedData);
      formData.append('details', JSON.stringify(productosAgregados));

      // Realizar la petición AJAX
      $.ajax({
        type: 'POST',
        url: 'modules/ventas/proses.php?act=insert',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log(response);
          if (response.status === 'success') {
            Swal.fire({
              title: response.message,
              position: "top-end",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              icon: "error",
              text: response,
              position: "top-end",
              showConfirmButton: false,
              timer: 1500
            });
          }
          /*   setTimeout(function () {
              location.reload();
            }, 1000); */
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: "error",
            text: 'Servicio no disponible',
            position: "top-end",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    });
    $('.js-example-basic-single').select2({
      language: "es"
    });
  });
</script>