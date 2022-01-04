<?php 

    //pagination
    $wp_params_get = array(
        "page_num" => 1
    );

    $page_current = 1;

    if( isset( $_GET["page_num"] ) ){
        $wp_params_get["page_num"]   = $_GET["page_num"];
        $page_current                = $_GET["page_num"];
    }

    $limit_row    = 5;

    //start and end limits
    if ( $page_current == 1 ) {
        $start_limit = 0;
        $end_limit   = $limit_row;
    }else{
        $start_limit = ($page_current - 1) * $limit_row;
        $end_limit   = $limit_row;
    }


    $id_provider = 1;

    $table_provider = $wpdb->prefix . "cstickets_products";

    $sql_exist_provider = sprintf("SELECT SQL_CALC_FOUND_ROWS wp_cstickets_products.*, wp_cstickets_provider.name_commercial_provider
                                    FROM %1\$s
                                    INNER JOIN wp_cstickets_provider ON wp_cstickets_provider.id_wp_cstickets_provider = wp_cstickets_products.fid_wp_cstickets_provider
                                    LIMIT %2\$d, %3\$d;", 
                                    $table_provider, $start_limit, $end_limit);
  
    $prepared_query = $wpdb->prepare( $sql_exist_provider );

    $results_exist_products = $wpdb->get_results( $prepared_query );

    // all rows without filter
    $sql_select_all = sprintf( "SELECT FOUND_ROWS() as row_all;" );

    $prepared_query_select_all = $wpdb->prepare( $sql_select_all );

    $results_select_all = $wpdb->get_results( $prepared_query_select_all );

    $num_row_all = $results_select_all[0]->row_all;
    // / all rows without filter


    $sql_provider = sprintf( "SELECT *
                                FROM wp_cstickets_provider;" );

    $prepared_query = $wpdb->prepare( $sql_exist_provider );

    $results_exist_provider = $wpdb->get_results( $prepared_query );


    $path_includes_page_admin_providers  = "admin.php?page=cstickets%2Fincludes%2Fcstickets-products.php";


    $path_includes_page_admin = CSTS_CSTICKETS__PLUGIN_URL . "api/save.php";


    if ( $_GET["seccion"] == "index" || empty( $_GET["seccion"] ) ) {
    ?>
        <div class="grid">
            <div class="col-12">
                <h1>Index</h1>
            </div>
        </div>

        <div class="grid">
            <div class="col-12">
                <a href="<?php echo $path_includes_page_admin_providers; ?>&seccion=create" class="btn btn-primary" >Create</a>
            </div>
        </div>

        <div class="wrap">
            <table class="table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Código</td>
                        <td>Nombre</td>
                        <td>Precio</td>
                        <td>Nombre comercial</td>
                        <td>Acción</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if( !empty( $results_exist_products ) ){
                        foreach ($results_exist_products as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $results_exist_products[$key]->id_wp_cstickets_products; ?></td>
                            <td><?php echo $results_exist_products[$key]->code; ?></td>
                            <td><?php echo $results_exist_products[$key]->name; ?></td>
                            <td><?php echo $results_exist_products[$key]->precio; ?></td>
                            <td><?php echo $results_exist_products[$key]->name_commercial_provider; ?></td>
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

        <div class="wrap">
            <div class="row">
                <div class="col-nwe-12">
                    <?php
                        if ( !empty( $num_row_all / $limit_row ) ) {
                            $num_page = $num_row_all / $limit_row;
                            $num_page = floor( $num_page );

                            if ( $num_row_all % $limit_row !== 0 ) {
                                $num_page = $num_page + 1;
                            }

                            ?>
                            <ul id="newmoji-ul">
                                <?php
                                    if ( $page_current != 1 ) {
                                        $path_includes_page_admin_int_before = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-products.php&page_num=" . ( $page_current - 1);
                                    ?>
                                        <li class=""><a href="<?php echo $path_includes_page_admin_int_before; ?>"> < </a></li>
                                    <?php
                                    }
                                ?>
                                <?php
                                    for ($i=1; $i <= $num_page; $i++) { 
                                        
                                        if ( $i == $page_current ) {
                                        ?>
                                            <li class=""><?php echo $i; ?></li>
                                        <?php
                                        } else {
                                            
                                            $path_includes_page_admin_int = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-products.php&page_num=" . $i;
                                        ?>
                                            <li class=""><a href="<?php echo $path_includes_page_admin_int; ?>"><?php echo $i; ?></a></li>
                                        <?php
                                            
                                        }
                                        
                                    }
                                ?>
                                <?php

                                    if ( $page_current < $num_page ) {
                                        $path_includes_page_admin_int_after = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-products.php&page_num=" . ( $page_current + 1);
                                    ?>
                                    <li class=""><a href="<?php echo $path_includes_page_admin_int_after; ?>"> > </a></li>
                                    <?php
                                    }
                                ?>
                            </ul>
                            <?php

                        }
                    ?>
                </div>
            </div>
        </div>
    <?php
    } else if( $_GET["seccion"] == "create" ) {
    ?>
        <div class="wrap">
            <h1>Creación de productos</h1>
            <form id="form-s-products" method="post" action="<?php echo $path_includes_page_admin; ?>">
                <div class="mb-3">
                    <label class="form-label">Proveedor</label>
                    <select class="form-control">
                        <?php
                            foreach( $results_exist_provider as $provider ){
                            ?>
                                <option value="<?php echo $provider->id_wp_cstickets_provider; ?>"><?php echo $provider->name_commercial_provider; ?> - <?php echo $provider->name_provider; ?></option>
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
                    <a href="<?php echo $path_includes_page_admin_providers; ?>" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    <?php
    }

?>
