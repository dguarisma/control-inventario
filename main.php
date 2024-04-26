<?php
session_start();
include_once ('template/head.php');
echo head('Sweet Donuts', 'Servicio de pedidos de donas - Sweet Donuts');
if (!isset($_SESSION['username'])) {
  // Redirigir a la página que desees si hay una sesión activa
  header("Location: index.php");
  exit; // ¡Importante! Asegúrate de salir del script después de redirigir
}
?>

<script language="javascript">
  function getkey(e) {
    if (window.event)
      return window.event.keyCode;
    else if (e)
      return e.which;
    else
      return null;
  }

  function goodchars(e, goods, field) {
    var key, keychar;
    key = getkey(e);
    if (key == null) return true;

    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();
    goods = goods.toLowerCase();

    // check goodkeys
    if (goods.indexOf(keychar) != -1)
      return true;
    // control keys
    if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
      return true;

    if (key == 13) {
      var i;
      for (i = 0; i < field.form.elements.length; i++)
        if (field == field.form.elements[i])
          break;
      i = (i + 1) % field.form.elements.length;
      field.form.elements[i].focus();
      return false;
    };
    // else return false
    return false;
  }
</script>

<main class="skin-blue fixed w-full">
  <header class="main-header bg-transparent">
    <!-- Logo -->
    <div class="logo">
      <div class="flex justify-center items-center h-full">
        <a href="#" onclick="window.location.reload(); return false;" class="relative p-2">
          <img src="./assets/img/logo.jpeg" alt="Logo" class="w-16 h-16 rounded-full aspect-square">
        </a>
      </div>
    </div>

    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php include "top-menu.php" ?>
        </ul>
      </div>
    </nav>
  </header>

  <div class="wrapper">
    <aside class="main-sidebar">
      <section class="sidebar">
        <?php include "sidebar-menu.php" ?>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <?php include "content.php"; ?>
    </div><!-- /.content-wrapper -->
    <!-- Modal Logout -->
    <div class="modal fade" id="logout">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-sign-out"> Salir</i></h4>
          </div>
          <div class="modal-body">
            <p>¿Seguro que quieres salir? </p>
          </div>
          <div class="modal-footer">
            <a type="button" class="btn btn-danger" href="logout.php">Si, Salir</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <footer class="main-footer">
      <strong>Derechos de autor &copy; <?php echo date('Y'); ?> - <a href="" target="_blank">Luis Grau</a>.</strong>
    </footer>
  </div><!-- ./wrapper -->
  <?php
  include_once ('template/footer.php');
  ?>