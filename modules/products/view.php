<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-folder-o icon-title"></i> Listado de Productos
      <a class="btn pull-right
      focus:outline-none text-white bg-[#3BB1DC] hover:text-white rounded py-2 transition duration-150 ease-in"
        href="?route=add_product&form=add" title="Agregar" data-toggle="tooltip">
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
                  <th class="center">Código</th>
                  <th class="center">Imagen</th>
                  <th class="center">Nombre</th>
                  <th class="center">Estado</th>
                  <th class="center">Unidad</th>
                  <th class="center">Stock</th>
                  <th class="center">Precio</th>
                  <th class="center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($mysqli, "SELECT * FROM productos ORDER BY codigo DESC")
                  or die('error: ' . mysqli_error($mysqli));

                while ($data = mysqli_fetch_assoc($query)) {
                  $precio_venta = format_rupiah($data['precio_venta']);
                  $imageUrl = isset($data['image']) ? $data['image'] : '';
                  $defaultImageUrl = 'images/user/user-default.png';
                  $imageSrc = (!empty($imageUrl) && $imageUrl !== 'default') ? $imageUrl : $defaultImageUrl;
                  echo "<tr>
                      <td width='80' class='center' style='vertical-align: middle;'>$data[codigo]</td>
                      <td width='180' style='vertical-align: middle;' class='center'>
                             <img class='m-auto w-32 h-32 object-cover aspect-radio p-3' src='$imageSrc'>
                      </td>
                      <td width='180' class='center' style='vertical-align: middle;'>$data[nombre]</td>
                      <td width='100' align='center' style='vertical-align: middle;'>
                          <span class='label " . ($data['status'] === 'Activo' ? 'bg-green' : 'label-danger') . "'>
                          " . $data['status'] . "
                          </span>
                     </td>
                      <td width='100' align='center' style='vertical-align: middle;'>$data[unidad]</td>
                      <td width='80' align='center' style='vertical-align: middle;'>$data[stock]</td>
                      <td width='100' align='center' style='vertical-align: middle;'>$ $precio_venta</td>
                      <td class='center' width='80' style='vertical-align: middle;'>
                        <div>
                          <a data-toggle='tooltip' data-placement='top' title='Modificar' 
                          style='margin-right:5px' class='btn btn-primary btn-sm'
                           href='?route=edit_product&form=edit&id=$data[id]'>
                              <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                          </a>";
                  ?>
                  <a data-toggle="tooltip" id="delete" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm"
                    onclick="deleteProduct(<?= $data['id'] ?>)">
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
  </section><!-- /.content-->
</main>

<?php
include_once ('template/footer.php');
?>

<script>
  function deleteProduct(id) {
    Swal.fire({
      title: "¿Estás seguro de borrar el producto?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Confirmar",
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
        formData.append('id', id);
        $.ajax({
          type: 'POST',
          url: 'modules/products/proses.php?act=delete',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.status === 'success') {
              Swal.fire({
                title: "Borrado exitoso.",
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