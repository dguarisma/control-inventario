<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Salida de productos

    <a class="btn btn-primary btn-social pull-right" href="?module=form_product_transaction&form=add" title="Agregar" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Nueva salida
    </a>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  

    if (empty($_GET['alert'])) {
      echo "";
    } 

    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
              Datos de productos han sido registrados correctamente.
            </div>";
    }
    ?>

      <div class="box box-primary">
        <div class="box-body">
         
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
           
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Codigo de Transación</th>
                <th class="center">Fecha</th>
                <th class="center">Codigo</th>
                <th class="center">Producto</th>
                <th class="center">Cantantidad</th>
                <th class="center">Unidad</th>
                <th class="center">Acciones</th>
              </tr>
            </thead>
         
            <tbody>
            <?php  
            $no = 1;
           
            $query = mysqli_query($mysqli, "SELECT a.tipo_transaccion, a.codigo_transaccion,a.fecha,a.codigo,a.numero,b.codigo,b.nombre,b.unidad
                                            FROM transaccion_inventory as a INNER JOIN productos as b ON a.codigo=b.codigo ORDER BY codigo_transaccion DESC")
                                            or die('error '.mysqli_error($mysqli));

           
            while ($data = mysqli_fetch_assoc($query)) { 
              $fecha         = $data['fecha'];
              $exp             = explode('-',$fecha);
              $fecha2   = $exp[2]."-".$exp[1]."-".$exp[0];

             
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='100' class='center'>$data[codigo_transaccion]</td>
                      <td width='80' class='center'>$fecha</td>
                      <td width='80' class='center'>$data[codigo]</td>
                      <td width='200'>$data[nombre]</td>
                      <td width='100' align='right'>$data[numero]</td>
                      <td width='80' class='center'>$data[unidad]</td>
                      <td class='center' width='80'>
                      <div>";
          ?>
                        <a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm" href="modules/product_transaction/proses.php?act=delete&id=<?php echo $data['codigo_transaccion'];?>" onclick="return confirm('está seguro de eliminar <?php echo $data['nombre']; ?> ?');"><i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                        </a>
          <?php
            echo "    </div>
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
  </div>   <!-- /.row -->
</section><!-- /.content