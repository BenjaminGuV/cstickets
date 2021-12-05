<?php 

    $path_includes_page_admin = CSTS_CSTICKETS__PLUGIN_URL . "api/save.php";

    $id_provider = 1;

    $table_provider = $wpdb->prefix . "cstickets_provider";

    $sql_exist_provider = sprintf("SELECT *
                                    FROM %s;", 
                                    $table_provider, $fid_posts );
  
    $prepared_query = $wpdb->prepare( $sql_exist_provider );

    $results_exist_provider = $wpdb->get_results( $prepared_query );

    if ( empty( $results_exist_provider ) ) {
        ?>
            <div class="wrap">
                <h1>Debe de crear un proveedor</h1>
            </div>
        <?php
        die();
    }

?>
<div class="wrap">
    <h1>Creación de productos</h1>
    <form method="post" action="<?php echo $path_includes_page_admin; ?>">
        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select class="form-control">
                <?php
                    foreach( $results_exist_provider as $provider ){
                    ?>
                        <option value="<?php echo $provider->id_wp_cstickets_provider; ?>"><?php echo $provider->name_commercial_provider; ?></option>
                    <?php
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="code" id="code" class="form-control">
        </div>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" id="name" class="form-control">      
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="text" name="precio" id="precio" class="form-control">
        </div>
        <div class="mb-3">
            <input type="hidden" name="id_provider" id="id_provider" value="<?php echo $id_provider; ?>">
            <input type="hidden" name="function" id="function" value="save-productos">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>