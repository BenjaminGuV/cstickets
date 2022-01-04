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


    $path_includes_page_admin = CSTS_CSTICKETS__PLUGIN_URL . "api/save.php";

    $table_provider      = $wpdb->prefix . "cstickets_provider";

    $sql_exist_provider = sprintf("SELECT SQL_CALC_FOUND_ROWS *
                                    FROM %1\$s
                                    LIMIT %2\$d, %3\$d;", 
                                    $table_provider, $start_limit, $end_limit );
  
    $prepared_query = $wpdb->prepare( $sql_exist_provider );

    $results_exist_provider = $wpdb->get_results( $prepared_query );


    // all rows without filter
    $sql_select_all = sprintf( "SELECT FOUND_ROWS() as row_all;" );

    $prepared_query_select_all = $wpdb->prepare( $sql_select_all );

    $results_select_all = $wpdb->get_results( $prepared_query_select_all );

    $num_row_all = $results_select_all[0]->row_all;
    // / all rows without filter


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
                                    $path_includes_page_admin_int_before = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-provider.php&page_num=" . ( $page_current - 1);
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
                                        
                                        $path_includes_page_admin_int = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-provider.php&page_num=" . $i;
                                    ?>
                                        <li class=""><a href="<?php echo $path_includes_page_admin_int; ?>"><?php echo $i; ?></a></li>
                                    <?php
                                        
                                    }
                                    
                                }
                            ?>
                            <?php

                                if ( $page_current < $num_page ) {
                                    $path_includes_page_admin_int_after = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-provider.php&page_num=" . ( $page_current + 1);
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
    <div class="grid">
        <div class="col-12-12">
            <h1>Creación de proveedores</h1>
        </div>
    </div>
    <div class="wrap">
        
        <form id="form-s-providers" method="post" action="<?php echo $path_includes_page_admin; ?>">
            <div class="form-group mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name_provider" id="name_provider" class="form-control">
                <div class="mb-12 messages"></div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Nombre comercial</label>
                <input type="text" name="name_commercial_provider" id="name_commercial_provider" class="form-control">
                <div class="mb-12 messages"></div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">RFC</label>
                <input type="text" name="rfc_provider" id="rfc_provider" class="form-control">
                <div class="mb-12 messages"></div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Dirección</label>
                <textarea name="direction" id="direction" class="form-control" cols="30" rows="10"></textarea>
                <div class="mb-12 messages"></div>
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

