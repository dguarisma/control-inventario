<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-folder-o icon-title"></i> Listado de Productos
    </h1>

  </section>
  <section class="content w-full h-[80vh] overflow-x-auto">
    <div class="row box">
      <div class="col-md-12">
        <div class="box-body">
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Código</th>
                <th class="center">Producto</th>
                <th class="center">Imagen</th>
                <th class="center">Existencia</th>
                <th class="center">Costo</th>
                <th class="center">Total</th>
                <th class="center">Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $query = mysqli_query($mysqli, "
              SELECT * FROM transaccion_inventory 
              JOIN productos ON transaccion_inventory.codigo = productos.codigo 
        
              ORDER BY transaccion_inventory.codigo  DESC")
                or die('error: ' . mysqli_error($mysqli));

              while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                  <td class="center"><?= $no++ ?></td>
                  <td class="center"><?= $data['codigo_transaccion'] ?></td>
                  <td class="center"><?= $data['nombre'] ?></td>
                  <td class="center"> <img class='m-auto w-32 h-32 object-cover aspect-radio p-3'
                      src='<?= $data['image'] ?>'></td>
                  <td class="center"><?= $data['stock'] ?></td>
                  <td class="center"><?= $data['precio_venta'] ?></td>
                  <td class="center"><?= $data['stock'] * $data['precio_venta'] ?></td>
                  <td class="center"><?= $data['tipo_transaccion'] ?></td>
                </tr>

                <?php
                $no++;
              }
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
    </div> <!-- /.row -->
  </section><!-- /.content -->
</main>