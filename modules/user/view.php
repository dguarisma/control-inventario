<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-user icon-title"></i> Gestión de Usuarios
      <a class="btn pull-right
      focus:outline-none text-white bg-[#3BB1DC] hover:text-white rounded py-2  transition duration-150 ease-in"
        href="?route=add_user" title="Agregar" data-toggle="tooltip">
        <i class="fa fa-plus"></i> Agregar
      </a>
    </h1>

  </section>
  <!-- Main content -->
  <section class="content w-full h-[80vh] overflow-x-auto">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-body">
            <table id="dataTables1" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="center">No.</th>
                  <th class="center">Foto</th>
                  <th class="center">Nombre de usuario</th>
                  <th class="center">Nombre</th>
                  <th class="center">Permisos de acceso</th>
                  <th class="center">Status</th>
                  <th class="center"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;

                $query = mysqli_query($mysqli, "SELECT * FROM usuarios ORDER BY id_user DESC")
                  or die('error: ' . mysqli_error($mysqli));

                while ($data = mysqli_fetch_assoc($query)) {
                  echo "<tr>
                              <td width='50' class='center'>$no</td>";
                  if ($data['image'] == "") {
                    echo "<td class='center'><img class='img-user m-auto' src='images/user/user-default.png' width='45'></td>";
                  } else {
                    echo "<td class='center align-middle'>
                                <img class='m-auto w-32 h-32 rounded-full object-cover aspect-radio p-3'
                                  src='" . $data['image'] . "'>
                              </td>";
                  }

                  echo "<td class='center' style='vertical-align:middle'>" . $data['username'] . "</td>
                              <td class='center' style='vertical-align:middle'>" . $data['name_user'] . "</td>
                              <td class='center' style='vertical-align:middle'>" . $data['permisos_acceso'] . "</td>
                              <td class='center' style='vertical-align:middle'>" . $data['status'] . "</td>
                              <td class='center' style='vertical-align:middle' width='100'>
                                <div>";

                  // Asignar un identificador único para cada botón
                  $activeOffId = "activeOff_$no";
                  $btn_class = ($data['status'] !== 'activo') ? 'btn-success' : 'btn-danger';

                  // Output del botón con su identificador único
                  echo "<a href='#' data-toggle='tooltip' id='$activeOffId' 
                  onclick='activeUser(\"" . $data['id_user'] . "\", \"" . $data['status'] . "\")'
                  data-placement='top' title='Bloqueado'
                                  style='margin-right:5px' class='btn $btn_class btn-sm'>";
                  if ($data['status'] == 'activo') {
                    echo "<i style='color:#fff' class='glyphicon glyphicon-off'></i>";
                  } else {
                    echo "<i style='color:#fff' class='glyphicon glyphicon-ok'></i>";
                  }
                  echo "</a>";

                  // Agregar el enlace de Modificar
                  echo "<a data-toggle='tooltip' data-placement='top' title='Modificar' class='btn btn-primary btn-sm'
                                  href='?route=edit_user&id={$data['id_user']}'>
                                  <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                              </a>
                            </div>
                          </td>
                        </tr>";
                  $no++;
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
  function activeUser(id, state) {
    Swal.fire({
      title: "¿Quieres guardar los cambios?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Confirmar",
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
        formData.append('id', id);
        formData.append('status', state);
        $.ajax({
          type: 'POST',
          url: 'modules/user/proses.php?act=off',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.status === 'success') {
              Swal.fire({
                title: "Exitoso",
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