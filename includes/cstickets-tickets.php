<?php 

    $path_includes_page_admin = CSTS_CSTICKETS__PLUGIN_URL . "api/save.php";

    $id_provider = 1;

    $table_provider = $wpdb->prefix . "cstickets_provider";

    $sql_exist_provider = sprintf("SELECT *
                                    FROM %s
                                    LIMIT 10;", 
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


    $sql_data_products = sprintf("SELECT *
                                  FROM wp_cstickets_products
                                  WHERE fid_wp_cstickets_provider = 1;", $id_product);

    $temp_data_products = $wpdb->prepare($sql_data_products);
    $data_products      = $wpdb->get_results( $temp_data_products );

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Creación de ticket</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!--
            <form method="post" action="<?php echo $path_includes_page_admin; ?>">
            -->
                <div class="row">
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="code" class="col-form-label">Código</label>
                            <select name="sel-code-list" id="sel-code-list">
                                <?php
                                    foreach( $data_products as $key => $value ){
                                    ?>
                                        <option value="<?php echo $data_products[$key]->id_wp_cstickets_products; ?>"><?php echo $data_products[$key]->code; ?> - <?php echo $data_products[$key]->name; ?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="cantidad" class="col-form-label">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="nombre" class="col-form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="precioxunidad" class="col-form-label">Precio x unidad</label>
                            <input type="text" class="form-control" id="precioxunidad" name="precioxunidad">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="precioxcantidad" class="col-form-label">Precio x cantidad</label>
                            <input type="text" class="form-control" id="precioxcantidad" name="precioxcantidad">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <button id="add-acc-tickets" class="btn btn-success">Agregar</button>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="code" class="col-form-label">Código</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="cantidad" class="col-form-label">Cantidad</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="nombre" class="col-form-label">Nombre</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="precioxunidad" class="col-form-label">Precio x unidad</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row mb-3">
                            <label for="precioxcantidad" class="col-form-label">Precio x cantidad</label>
                        </div>
                    </div>
                </div>

                <div id="append-table">
                </div>
    
                <div class="row">
                    <hr>
                </div>

                <div id="cont-subtotal">
                </div>

                <div class="row">
                    <hr>
                </div>

                <div id="cont-iva">
                </div>


                <div class="row">
                    <hr>
                </div>

                <div id="cont-total">
                </div>

                <div class="row">
                    <hr>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="group-form">
                            <input type="text" name="id_provider" id="id_provider" value="<?php echo $id_provider; ?>">
                            <input type="text" name="function" id="function" value="save-tickets-productos">
                            <button id="form-save-tickets" class="btn btn-success" type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
            <!--
            </form>
            -->
        </div>
    </div>
</div>
