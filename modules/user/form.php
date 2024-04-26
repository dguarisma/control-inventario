<main>
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i>
      Agregar Usuario
    </h1>
    <ol class="breadcrumb">
      <li><a href="?route=home"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?route=user"> Usuario </a></li>
      <li class="active"> agregar </li>
    </ol>
  </section>
  <section class="content h-[80vh] overflow-x-auto">
    <div class="container">
      <div class="sm:w-1/2 w-full m-auto">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" id="loginForm" class="form-horizontal py-5" method="POST"
            action="modules/user/proses.php?act=insert" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <div class="col-span-6 ml-2 sm:col-span-4 md:mr-3">
                  <!-- Wrap the file input and label inside a div -->
                  <div class="cursor-pointer">
                    <!-- Photo File Input -->
                    <input type="file" id="photoInput" name="image" class="hidden" accept="image/*">
                    <label for="photoInput" class="block text-gray-700 font-normal mb-2 text-center">
                      Foto Perfil
                    </label>
                    <div class="text-center w-[20%] m-auto" id="fileInputWrapper">
                      <!-- New Profile Photo Preview -->
                      <div class="mt-2">
                        <span id="previewImage"
                          class="block w-40 h-40 rounded-full m-auto shadow hover:bg-gray-200 bg-no-repeat bg-cover bg-center"
                          style="background-image: url('https://t4.ftcdn.net/jpg/05/49/98/39/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg');">
                        </span>
                      </div>
                      <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300
                        rounded-md text-base text-gray-700  tracking-widest shadow-sm 
                        hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue
                        active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3">
                        Seleccionar Archivo
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-7">
                  <input type="text"
                    class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                    name="name_user" autocomplete="off" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Usuario</label>
                <div class="col-sm-7">
                  <input type="text"
                    class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                    name="username" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Contraseña</label>
                <div class="col-sm-7">
                  <div class="flex justify-center items-center gap-2">
                    <input type="password" id="password"
                      class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                      name="password" autocomplete="off" required>
                    <div class="input-group-append cursor-pointer" id="togglePassword">
                      <i class="fa fa-eye" aria-hidden="true" id="showPassword"></i>
                      <i class="fa fa-eye-slash hidden" aria-hidden="true" id="hidePassword"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Perfil</label>
                <div class="col-sm-7">
                  <select
                    class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                    name="permisos_acceso" required>
                    <option value=""></option>
                    <option value="Administrador">Administrador</option>
                    <option value="Asistente">Asistente</option>
                  </select>
                </div>
              </div>

            </div><!-- /.box body -->
            <div class="box-footer">
              <div class="flex flex-row justify-center items-center gap-3">
                <input type="submit"
                  class="flex items-center justify-center focus:outline-none text-white bg-[#3BB1DC] hover:bg-[#3BB1DC]/90 rounded py-2 w-full transition duration-150 ease-in"
                  name="Guardar" value="Guardar">
                <a href="?route=user"
                  class="flex items-center justify-center border border-gray-400 hover:border-[#3BB1DC]/50 focus:outline-none hover:text-white bg-white hover:bg-[#3BB1DC]/50 rounded py-2 w-full transition duration-150 ease-in">Cancelar</a>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div> <!-- /.row -->
  </section><!-- /.content -->
</main>

<?php
include_once ('template/footer.php');
?>
<script>
  // Add event listener to the file input wrapper div
  document.getElementById('fileInputWrapper').addEventListener('click', function () {
    // Trigger click on the file input
    document.getElementById('photoInput').click();
  });

  // Handle file selection change
  document.getElementById('photoInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      const previewImage = document.getElementById('previewImage');
      const imageUrl = e.target.result;
      previewImage.style.backgroundImage = `url('${imageUrl}')`;
    };
    reader.readAsDataURL(file);
  })
  $(function () {
    $('#togglePassword').click(function () {
      var passwordField = $('#password');
      var passwordFieldType = passwordField.attr('type');

      if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        $('#showPassword').addClass('hidden');
        $('#hidePassword').removeClass('hidden');
      } else {
        passwordField.attr('type', 'password');
        $('#showPassword').removeClass('hidden');
        $('#hidePassword').addClass('hidden');
      }
    });
    // Escuchar el evento submit del formulario
    $('#loginForm').submit(function (event) {
      // Evitar que el formulario se envíe de forma predeterminada
      event.preventDefault();
      // Obtener los datos del formulario
      const formData = new FormData(this);
      const serializedData = $(this).serialize();
      const backgroundImage = $('#previewImage').css('backgroundImage');
      const url = backgroundImage.replace('url("', '').replace('")', '');
      formData.append('existingData', serializedData);
      formData.append('image', url);

      // Realizar la petición AJAX
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.status === 'success') {
            $('#loginForm')[0].reset();
            const backgroundImage = $('#previewImage').css('backgroundImage', 'url(https://t4.ftcdn.net/jpg/05/49/98/39/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg)');
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