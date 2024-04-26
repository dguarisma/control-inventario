<?php
$previewImage = "https://inventory.obedalvarado.pw/img/productos/product.png";
if (isset($_GET['id'])) {
    $query = mysqli_query($mysqli, "SELECT * FROM productos WHERE id='$_GET[id]'")
        or die('error: ' . mysqli_error($mysqli));
    $data = mysqli_fetch_assoc($query);
    $imageSrc = (!empty($data['image']) && $data['image'] !== 'default') ? $data['image'] : $previewImage;
}
?>
<main>
    <section class="content-header">
        <h1>
            <i class="fa fa-edit icon-title"></i> Editar productos
        </h1>
        <ol class="breadcrumb">
            <li><a href="?route=home"><i class="fa fa-home"></i> Inicio </a></li>
            <li><a href="?route=products"> productos </a></li>
            <li class="active"> Más </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content h-[80vh] overflow-x-auto">
        <div class="container">
            <div class="sm:w-10/12 w-full m-auto my-5">
                <div class="box box-primary py-4 px-3">
                    <!-- form start -->
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="">
                                <div class="box-body box-profile">
                                    <div id="load_img" class="w-[220px] h-[220px]">
                                        <img class="img-responsive aspect-square object-cover" id="previewImage"
                                            src="<?= $imageSrc ?>" alt="Bussines profile picture">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <form name="addForm" id="addForm"
                                action="modules/products/proses.php?act=edit&id=<?= $data['id'] ?>"
                                class="form-horizontal" method="POST" enctype="multipart/form-data">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content">
                                        <div id="resultados_ajax"></div>
                                        <div class="tab-pane active" id="details">
                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Código</label>
                                                <div class="col-sm-4">
                                                    <input type="text"
                                                        class="placeholder-gray-500 pl-10 pr-4 bg-gray-200 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                                                        name="codigo" value="<?= $data['codigo'] ?>" readonly required>
                                                </div>
                                                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                                                <div class="col-sm-4">
                                                    <input type="text"
                                                        class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                                                        id="nombre" name="nombre" maxlength="100" required
                                                        value="<?= $data['nombre'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="manufacturer_id"
                                                    class="col-sm-2 control-label">Unidad</label>
                                                <div class="col-sm-4">
                                                    <select
                                                        class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                                                        name="manufacturer_id" id="manufacturer_id" required="">
                                                        <option value="" <?= ($data['unidad'] === '') ? 'selected' : '' ?>>
                                                            Selecciona</option>
                                                        <option value="botellas" <?= ($data['unidad'] === 'botellas') ? 'selected' : '' ?>>Botella</option>
                                                        <option value="cajas" <?= ($data['unidad'] === 'cajas') ? 'selected' : '' ?>>Cajas</option>
                                                        <option value="caja" <?= ($data['unidad'] === 'caja') ? 'selected' : '' ?>>Caja</option>
                                                        <option value="raya" <?= ($data['unidad'] === 'raya') ? 'selected' : '' ?>>Raya</option>
                                                        <option value="tubo" <?= ($data['unidad'] === 'tubo') ? 'selected' : '' ?>>Tubo</option>
                                                    </select>
                                                </div>

                                                <label for="status" class="col-sm-2 control-label">Estado</label>
                                                <div class="col-sm-4">
                                                    <select class="placeholder-gray-500 pl-10 pr-4 
                                                            rounded-lg border border-gray-400 w-full 
                                                            py-2 focus:outline-none focus:border-blue-400"
                                                        name="status" id="status">
                                                        <option value="Activo" <?= ($data['status'] === 'Activo') ? 'selected' : '' ?>>Activo</option>
                                                        <option value="Apagado" <?= ($data['status'] === 'Apagado') ? 'selected' : '' ?>>Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="precio_venta" class="col-sm-2 control-label">Precio de
                                                    venta</label>
                                                <div class="col-sm-4">
                                                    <div class="relative mb-6">
                                                        <div
                                                            class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="number" id="precio_venta"
                                                            class="placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                                                            name="precio_venta" required="" pattern="\d+(\.\d{2})?"
                                                            value="<?= $data['precio_venta'] ?>"
                                                            title="precio con 2 decimales">
                                                    </div>
                                                </div>
                                                <label for="stock" class="col-sm-2 control-label">Stock Inicial</label>
                                                <div class="col-sm-4">
                                                    <div class="relative mb-6">
                                                        <div
                                                            class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                            <i class="fa fa-th-large" aria-hidden="true"></i>
                                                        </div>
                                                        <input type="number"
                                                            class="placeholder-gray-500 pl-12 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                                                            id="stock" name="stock" required=""
                                                            value="<?= $data['stock'] ?>" pattern="\d{1,11}"
                                                            maxlength="11">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="image" class="col-sm-2 control-label">Imagen</label>
                                                <div class="col-sm-6">
                                                    <input accept="image/*"
                                                        class="block w-full text-2xl p-5 border border-gray-300 rounded-lg cursor-pointer"
                                                        name="image" id="image" type="file">
                                                </div>
                                            </div>
                                            <div class="box-footer mt-[18px]">
                                                <div class="flex flex-row justify-center items-center gap-5">
                                                    <input type="submit"
                                                        class="flex items-center justify-center focus:outline-none text-white bg-[#3BB1DC] hover:bg-[#3BB1DC]/90 rounded py-2 w-[20%] transition duration-150 ease-in"
                                                        name="Guardar" value="Guardar">
                                                    <a href="?route=products"
                                                        class="flex items-center justify-center border border-gray-400 hover:border-[#3BB1DC]/50 focus:outline-none hover:text-white bg-white hover:bg-[#3BB1DC]/50 rounded py-2 w-[20%] transition duration-150 ease-in">Cancelar</a>
                                                </div>
                                            </div><!-- /.box footer -->
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </form>
                        </div>
                        <!-- /.col -->
                    </div>
                </div><!-- /.box -->
            </div><!--/.col -->
        </div> <!-- /.row -->
    </section><!-- /.content -->
</main>

<?php
include_once ('template/footer.php');
?>
<script>
    $(function () {
        $("#image").change(function () {
            // Obtener el archivo seleccionado
            var file = this.files[0];
            // Verificar si se seleccionó un archivo
            if (file) {
                // Crear un objeto FileReader para leer el archivo
                var reader = new FileReader();
                // Configurar el evento onload del objeto FileReader
                reader.onload = function (e) {
                    // Asignar la URL de la imagen al atributo src del elemento <img>
                    $("#previewImage").attr("src", e.target.result);
                    // Mostrar el elemento <img>
                    $("#previewImage").show();
                };
                // Leer el contenido del archivo como una URL de datos (data URL)
                reader.readAsDataURL(file);
            } else {
                // Si no se selecciona ningún archivo, ocultar el elemento <img>
                $("#previewImage").hide();
            }
        });
        $('#addForm').submit(function (event) {
            // Evitar que el formulario se envíe de forma predeterminada
            event.preventDefault();
            const formData = new FormData(this);
            const serializedData = $(this).serialize();
            formData.append('existingData', serializedData);
            var srcValue = $("#previewImage").attr("src");
            formData.append('image', srcValue);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
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