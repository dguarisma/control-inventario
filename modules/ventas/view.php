<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-folder-o icon-title"></i>Listado de Ventas
      <a class="btn pull-right
      focus:outline-none text-white bg-[#3BB1DC] hover:text-white rounded py-2 transition duration-150 ease-in"
        href="?route=add_ventas" title=" Agregar" data-toggle="tooltip">
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
                  <th class="center">Factura Nº</th>
                  <th class="center">Cliente</th>
                  <th class="center">Fecha</th>
                  <th class="center">Vendedor</th>
                  <th class="center">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($mysqli, "SELECT v.id AS ventaId, v.numero_factura, v.total, c.nombre, v.created, u.name_user 
                        FROM ventas v 
                        JOIN clientes c ON c.id = v.cliente_id 
                        JOIN usuarios u ON v.user_id = u.id_user
                        ORDER BY v.id DESC;
                        ")
                  or die('error: ' . mysqli_error($mysqli));

                while ($data = mysqli_fetch_assoc($query)) {
                  $date = date('d-m-Y', strtotime($data['created']));
                  echo "<tr>
                      <td width='80' class='center'>$data[numero_factura]</td>
                      <td width='80' align='center'>$data[nombre]</td>
                      <td width='100' align='center'> $date</td>
                      <td width='100' align='center'>  $data[name_user]</td>
                      <td width='100' align='center'> $data[total]</td>
                      <td class='center' width='80'><div> ";
                  ?>
                  <a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm" href="#"
                    onclick="deletePurchase('<?php echo $data['ventaId']; ?>');">
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
          url: 'modules/ventas/proses.php?act=delete&id=' + id,
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