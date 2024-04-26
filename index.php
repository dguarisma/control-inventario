<?php
include_once ('template/head.php');

session_start();
// Verificar si hay una sesión activa
if (isset($_SESSION['username'])) {
  // Redirigir a la página que desees si hay una sesión activa
  header("Location: main.php");
  exit; // ¡Importante! Asegúrate de salir del script después de redirigir
}
echo head('Login', 'Ingreso al sistema de inventario Sweet Donuts')
  ?>

<section class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
  <div class="flex flex-col bg-white shadow-md px-4 sm:px-6 md:px-8 lg:px-10 py-8 rounded-md w-1/4">
    <div class="flex flex-col items-center justify-center gap-3">
      <img class="w-36 h-36 rounded-full aspect-square my-3" src="assets/img/logo.jpeg" alt="logo">
      <h1 class="text-center text-5xl font-bold">Sweet Donuts</h1>
    </div>
    <form id="loginForm" action="login-check.php" method="POST" class="mt-10">
      <div class="flex flex-col mb-6">
        <label htmlFor="username" class="mb-1 tracking-wide text-gray-900">
          Username:
        </label>
        <div class="relative">
          <div class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-600">
            <svg class="h-6 w-6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
              viewBox="0 0 24 24" stroke="currentColor">
              <path
                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
            </svg>
          </div>
          <input id="username" type="username" name="username"
            class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
            placeholder="Ingresa Usuario" required autocomplete="off" />
        </div>
      </div>
      <div class="flex flex-col mb-6">
        <label htmlFor="password" class="mb-1 tracking-wide text-gray-900">
          Password:
        </label>
        <div class="relative">
          <div class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-600">
            <span>
              <svg class="h-6 w-6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                viewBox="0 0 24 24" stroke="currentColor">
                <path
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </span>
          </div>
          <input id="password" type="password" name="password"
            class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
            placeholder="Password" required autocomplete="off" />
        </div>
      </div>

      <div class="flex w-full my-12">
        <button type="submit"
          class="flex items-center justify-center focus:outline-none text-white bg-[#3BB1DC] hover:bg-[#3BB1DC]/50 rounded py-2 w-full transition duration-150 ease-in">
          <span class="mr-2">Login</span>
        </button>
      </div>
    </form>
    <div id="message"
      class="flex items-center justify-center bg-red-600 p-3 rounded text-white shadow-md transition duration-150 ease-in hidden" />
  </div>
</section>
<?php
include_once ('template/footer.php');
?>
<script>
  $(function () {
    // Escuchar el evento submit del formulario
    $('#loginForm').submit(function (event) {
      // Evitar que el formulario se envíe de forma predeterminada
      event.preventDefault();
      // Obtener los datos del formulario
      var formData = $(this).serialize();

      // Realizar la petición AJAX
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        success: function (response) {
          // Por ejemplo, redirigir a otra página si el inicio de sesión fue exitoso
          if (response.status === 'success') {
            window.location.href = response.url;
          } else {
            $('#message').removeClass('hidden').text(response);
            // Ocultar el mensaje después de un minuto
            setTimeout(function () {
              $('#message').addClass('hidden').text('');
            }, 1000);
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>