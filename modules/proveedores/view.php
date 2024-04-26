<main>
  <div class="modal fade" id="proveedor_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo Proveedor</h4>
        </div>
        <form role="form" id="addproveedor" class="form-horizontal py-5" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Razón Social</label>
              <div class="col-sm-7">
                <input type="hidden" name="id">
                <input type="text" placeholder="Ingresar el Nombre" class="placeholder-gray-500 pl-10
                   pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                  name="razon_social" autocomplete="off" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">RIF</label>
              <div class="col-sm-7">
                <input type="text" placeholder="Documento"
                  class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                  name="RIF" autocomplete="off" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Teléfono</label>
              <div class="col-sm-7">
                <input type="tel" placeholder="000-000-0000"
                  class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                  name="telefono" autocomplete="off" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Ubicación</label>
              <div class="col-sm-7">
                <input type="text" placeholder="Ingresar la Ubicación"
                  class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                  name="ubicacion" autocomplete="off" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Referencia</label>
              <div class="col-sm-7">
                <input type="text" placeholder="Referencia"
                  class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                  name="referencia" autocomplete="off" required>
              </div>
            </div>
          </div>
          <div class="modal-footer flex justify-center items-center gap-5">
            <button type="reset" onclick="cleanForm()" class="flex items-center 
              justify-center border border-gray-400 hover:border-[#3BB1DC]/50 
              focus:outline-none hover:text-white bg-white hover:bg-[#3BB1DC]/50 
              rounded py-2 w-full transition duration-150 ease-in" data-dismiss="modal">
              Cerrar
            </button>
            <button type="submit" id="guardar_datos" class="flex items-center justify-center
               focus:outline-none text-white bg-[#3BB1DC] 
               hover:bg-[#3BB1DC]/90 rounded py-2 w-full transition duration-150 ease-in">
              Registrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <section class="content-header">
    <h1>
      <i class="fa fa-folder-o icon-title"></i>Listado de Proveedores
      <a class="btn pull-right
      focus:outline-none text-white bg-[#3BB1DC] hover:text-white rounded py-2 transition duration-150 ease-in"
        onclick="cleanForm()" data-toggle="modal" href="#proveedor_modal" title=" Agregar" data-toggle="tooltip">
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
                  <th class="center">ID</th>
                  <th class="center">Proveedor</th>
                  <th class="center">RIF</th>
                  <th class="center">Dirección</th>
                  <th class="center">Contacto</th>
                  <th class="center">Referencia</th>
                  <th class="center">Agregado</th>
                  <th class="center"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($mysqli, "SELECT * FROM proveedor ORDER BY id DESC")
                  or die('error: ' . mysqli_error($mysqli));

                while ($data = mysqli_fetch_assoc($query)) {
                  $date = date('d-m-Y', strtotime($data['created']));
                  echo "<tr>
                      <td class='center'>$data[id]</td>
                      <td class='center'>$data[razon_social]</td>
                      <td align='center'>$data[RIF]</td>
                      <td align='center'>$data[ubicacion]</td>
                      <td align='center'>$data[telefono]</td>
                      <td align='center'>$data[referencia]</td>
                      <td align='center'>$date </td>
                      <td class='center' width='100'>
                        <div>" ?>
                  <a data-toggle='tooltip' data-placement='top' title='Modificar' style='margin-right:5px'
                    class='btn btn-primary btn-sm' onclick="editProveedor('<?= $data['id'] ?>')">
                    <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                  </a>
                  <a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm" href="#"
                    onclick="deleteProveedor('<?php echo $data['id']; ?>');">
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
  function cleanForm() {
    const form = document.getElementById('addproveedor');
    $("input[name='id']").val('')
    form.reset();
  }
  function editProveedor(id) {
    $.ajax({
      type: 'GET',
      url: 'modules/proveedores/proses.php?act=select&id=' + id,
      success: function (response) {
        if (JSON.parse(response).status === "success") {
          var proveedor = JSON.parse(response).proveedor;
          // Establecer los valores en los campos del formulario
          $("input[name='id']").val(proveedor.id);
          $("input[name='razon_social']").val(proveedor.razon_social);
          $("input[name='RIF']").val(proveedor.RIF);
          $("input[name='ubicacion']").val(proveedor.ubicacion);
          $("input[name='referencia']").val(proveedor.referencia);
          $("input[name='telefono']").val(proveedor.telefono);
          // Mostrar el modal
          $("#proveedor_modal").modal("show");
        } else {
          console.log("Error: " + response.message);
        }

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

  function deleteProveedor(id) {
    Swal.fire({
      title: "¿Quieres borrar el proveedor?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Confirmar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'GET',
          url: 'modules/proveedores/proses.php?act=delete&id=' + id,
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

  $(function () {
    // Escuchar el evento submit del formulario
    $('#addproveedor').submit(function (event) {
      // Evitar que el formulario se envíe de forma predeterminada
      event.preventDefault();
      // Obtener los datos del formulario
      const formData = $(this).serialize();
      let url;
      if ($("input[name='id']").val()) {
        url = 'modules/proveedores/proses.php?act=edit&id=' + $("input[name='id']").val();
      } else {
        url = 'modules/proveedores/proses.php?act=insert';
      }

      // Realizar la petición AJAX
      $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire({
              title: response.message,
              position: "top-end",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            $('#proveedor_modal').modal('hide');
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
            cleanForm();
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
    });
  });
</script>