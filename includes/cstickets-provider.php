<?php
    $path_includes_page_admin = CSTS_CSTICKETS__PLUGIN_URL . "api/save.php";

    $table_provider      = $wpdb->prefix . "cstickets_provider";

    $sql_exist_provider = sprintf("SELECT *
                                    FROM %s
                                    LIMIT 10;", 
                                    $table_provider, $fid_posts );
  
    $prepared_query = $wpdb->prepare( $sql_exist_provider );

    $results_exist_provider = $wpdb->get_results( $prepared_query );

    $path_includes_page_admin_tickets  = "admin.php?page=cstickets%2Fincludes%2Fcstickets-provider.php"

?>

<?php 

    if ( $_GET["seccion"] == "index" || empty( $_GET["seccion"] ) ) {
    ?>
    <div class="grid">
        <div class="col-12">
            <h1>Index</h1>
        </div>
    </div>

    <div class="grid">
        <div class="col-12">
            <a href="<?php echo $path_includes_page_admin_tickets ?>&seccion=create" class="btn btn-primary" >Create</a>
        </div>
    </div>

    <div class="wrap">
        <table class="table">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nombre comercial</td>
                    <td>Nombre</td>
                    <td>RFC</td>
                    <td>Direccion</td>
                    <td>Acción</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                if( !empty( $results_exist_provider ) ){
                    foreach ($results_exist_provider as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $results_exist_provider[$key]->id_wp_cstickets_provider; ?></td>
                        <td><?php echo $results_exist_provider[$key]->name_commercial_provider; ?></td>
                        <td><?php echo $results_exist_provider[$key]->name_provider; ?></td>
                        <td><?php echo $results_exist_provider[$key]->rfc_provider; ?></td>
                        <td><?php echo $results_exist_provider[$key]->direction; ?></td>
                        <td>
                            <a href="#asd" class="btn btn-info">EDIT</a>
                            <a href="#asd" class="btn btn-danger">DELETE</a>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    } else if( $_GET["seccion"] == "create" ) {
    ?>
    <div class="grid">
        <div class="col-12-12">
            <h1>Creación de proveedores</h1>
        </div>
    </div>
    <div class="wrap">
        
        <form method="post" action="<?php echo $path_includes_page_admin; ?>">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name_provider" id="name_provider" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre comercial</label>
                <input type="text" name="name_commercial_provider" id="name_commercial_provider" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">RFC</label>
                <input type="text" name="rfc_provider" id="rfc_provider" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <textarea name="direction" id="direction" class="form-control" cols="30" rows="10"></textarea>
            </div>
            
            <div class="group-form">
                <input type="hidden" name="function" id="function" value="save-provider">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href='<?php echo $path_includes_page_admin_tickets; ?>'>Cancelar</a>
            </div>
        </form>
    </div>
    <?php
    }
    

?>

