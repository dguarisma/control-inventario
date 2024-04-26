<?php
function head($title = '', $description = '')
{
    ob_start(); // Iniciar el almacenamiento en búfer de salida
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- favicon -->
        <link rel="shortcut icon" href="./assets/img/favicon.ico" />

        <!-- Bootstrap 3.3.2 -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <!-- Theme style -->
        <link href="assets/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- Custom CSS -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <!-- Bootstrap 3.3.2 -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- FontAwesome 4.3.0 -->
        <link href="assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Datepicker -->
        <link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- Chosen Select -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/chosen/css/chosen.min.css" />
        <!-- Theme style -->
        <link href="assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="assets/css/skins/skin-blue.css" rel="stylesheet" type="text/css" />
        <!-- Custom CSS -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>

    <body>
        <?php
        // Retornar el contenido del búfer de salida y limpiarlo
        return ob_get_clean();
}
?>