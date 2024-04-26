<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-folder-o icon-title"></i> Listado de Compras
      <a class="btn pull-right
      focus:outline-none text-white bg-[#3BB1DC] hover:text-white rounded py-2 transition duration-150 ease-in"
        href="?route=add_compras" title=" Agregar" data-toggle="tooltip">
        <i class="fa fa-plus"></i> Agregar
      </a>
    </h1>
  </section>
  <section class="content w-full h-[80vh] overflow-x-auto">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-body">
            <table id="dataTables1" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="center">Compra Nº</th>
                  <th class="center">Proveedor</th>
                  <th class="center">Fecha</th>
                  <th class="center">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($mysqli, "SELECT 
                c.id AS compraId,
                 c.order_numero, c.total, 
                 p.razon_social, c.total, c.date_create, c.user_id
                FROM compras c 
                JOIN proveedor p ON c.proveedor_id = p.id 
                JOIN usuarios u ON c.user_id = u.id_user 
                ORDER BY p.id DESC;
                ")
                  or die('error: ' . mysqli_error($mysqli));

                while ($data = mysqli_fetch_assoc($query)) {
                  $date = date('d-m-Y', strtotime($data['date_create']));
                  echo "<tr>
                      <td width='80' class='center'>$data[order_numero]</td>
                      <td width='80' align='center'>$data[razon_social]</td>
                      <td width='100' align='center'> $date</td>
                      <td width='100' align='center'> $data[total]</td>
                      <td class='center' width='80'><div> ";
                  ?>
                  <a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm" href="#"
                    onclick="deletePurchase('<?php echo $data['compraId']; ?>');">
                    <i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                  </a>
                  <?php
                  echo "    </div>
                      </td>
                    </tr>";
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

<?php
include_once ('template/footer.php');
?>
<script>

  function deletePurchase(id) {
    console.log(id);
    Swal.fire({
      title: "¿Estás seguro de querer borrar la orden de compras?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Confirmar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'GET',
          url: 'modules/compras/proses.php?act=delete&id=' + id,
          success: function (response) {
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
                text: response?.message,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500
              });
            }
            setTimeout(function () {
              location.reload();
            }, 1000);
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
      }
    });
  }

</script>