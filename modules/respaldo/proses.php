<?php
session_start();

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
} else {
    // Configuración de la conexión a la base de datos
    $servername = "localhost"; // Cambia esto por tu servidor de base de datos
    $username = "root"; // Cambia esto por tu nombre de usuario de la base de datos
    $password = ""; // Cambia esto por tu contraseña de la base de datos
    $database = "sweetdonuts"; // Cambia esto por el nombre de tu base de datos

    // Nombre del archivo de respaldo SQL
    $backup_file = 'backup.sql';

    // Comando para generar el respaldo de toda la base de datos
    $command = "mysqldump --user={$username} --password={$password} --host={$servername} {$database} > {$backup_file}";

    // Ejecutar el comando para generar el respaldo
    exec($command, $output, $return_var);

    // Verificar si el respaldo se creó correctamente
    if ($return_var === 0 && file_exists($backup_file)) {
        // Descargar el archivo SQL
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($backup_file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backup_file));

        // Leer el archivo SQL y enviar su contenido al navegador
        readfile($backup_file);

        // Cambiar los permisos del archivo para que sea eliminable
        chmod($backup_file, 0666);

        // Eliminar el archivo temporal después de la descarga
        unlink($backup_file);
        exit;
    } else {
        echo "Error al generar el respaldo de la base de datos";
    }

}
?>