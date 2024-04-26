<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-folder-o icon-title"></i>Ejecutar Respaldo de base de datos
      <a class="btn pull-right
      focus:outline-none text-white bg-[#3BB1DC] hover:text-white rounded py-2 transition duration-150 ease-in"
        href="?route=add_compras" title=" Agregar" data-toggle="tooltip">
        <i class="fa fa-plus"></i> Agregar
      </a>
    </h1>
  </section>
  <section class="content w-full h-[80vh] overflow-x-auto bg-white flex flex-col justify-center items-center">
    <div class="flex w-full justify-center items-center gap-5">
      <input type="button" id="respaldo"
        class="flex items-center justify-center focus:outline-none text-white bg-[#3BB1DC] hover:bg-[#3BB1DC]/90 rounded py-2 w-[20%] transition duration-150 ease-in"
        name="Ejecutar" value="Ejecutar">
      <a href="?route=home"
        class="flex items-center justify-center border border-gray-400 hover:border-[#3BB1DC]/50 focus:outline-none hover:text-white bg-white hover:bg-[#3BB1DC]/50 rounded py-2 w-[20%] transition duration-150 ease-in">Cancelar</a>
    </div>
  </section><!-- /.content -->
</main>

<?php
include_once ('template/footer.php');
?>

<script>
  $(function () {
    $('#respaldo').on('click', function (event) {
      event.preventDefault();
      $.ajax({
        type: 'GET',
        url: 'modules/respaldo/proses.php',
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire({
              title: response?.message,
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
  })
</script>