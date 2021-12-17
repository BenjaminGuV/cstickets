<?php 
    global $wpdb;
    

    $table_provider      = $wpdb->prefix . "cstickets_provider";
    $table_name_products = $wpdb->prefix . "cstickets_products";


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
    

    $sql_exist_provider = sprintf("SELECT *
                                    FROM %s
                                    LIMIT 10;", 
                                    $table_provider, $fid_posts );
  
    $prepared_query = $wpdb->prepare( $sql_exist_provider );

    $results_exist_provider = $wpdb->get_results( $prepared_query );

    $sql_exist_products = sprintf("SELECT *
                                    FROM %s
                                    LIMIT 10;", 
                                    $table_name_products, $fid_posts );
  
    $prepared_query = $wpdb->prepare( $sql_exist_products );

    $results_exist_products = $wpdb->get_results( $prepared_query );

    $sql_list_tickets = sprintf( "SELECT SQL_CALC_FOUND_ROWS wp_cstickets_tickets.*, id_wp_cstickets_tickets as id,
                                        wp_cstickets_provider.name_commercial_provider as nombre_proveedor
                                    FROM wp_cstickets_tickets
                                    INNER JOIN wp_cstickets_provider ON wp_cstickets_tickets.fid_wp_cstickets_provider = wp_cstickets_provider.id_wp_cstickets_provider
                                    ORDER BY id_wp_cstickets_tickets DESC
                                    LIMIT %1\$d, %2\$d;",
                                    $start_limit, $end_limit );

    $prepared_query = $wpdb->prepare( $sql_list_tickets );

    $list_tickets = $wpdb->get_results( $prepared_query );

    // all rows without filter
    $sql_select_all = sprintf( "SELECT FOUND_ROWS() as row_all;" );

    $prepared_query_select_all = $wpdb->prepare( $sql_select_all );

    $results_select_all = $wpdb->get_results( $prepared_query_select_all );

    $num_row_all = $results_select_all[0]->row_all;
    // / all rows without filter

    $path_includes_page_admin_tickets  = "admin.php?page=cstickets%2Fincludes%2Fcstickets-pdf.php"

?>
<div class="wrap">
    <h1>Lista de tickets generado</h1>
    
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Fecha de creación</th>
                <th scope="col">Código</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Subtotal</th>
                <th scope="col">IVA</th>
                <th scope="col">Total</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $list_tickets as $key => $value ){
                ?>
                <tr>
                    <td><?php echo $list_tickets[$key]->id; ?></td>
                    <td><?php echo $list_tickets[$key]->create_date; ?></td>
                    <td><?php echo $list_tickets[$key]->code; ?></td>
                    <td><?php echo $list_tickets[$key]->nombre_proveedor; ?></td>
                    <td><?php echo $list_tickets[$key]->subtotal; ?></td>
                    <td><?php echo $list_tickets[$key]->iva; ?></td>
                    <td><?php echo $list_tickets[$key]->total; ?></td>
                    <td>
                        Acciones
                        <a href="<?php echo $link; ?>">pdf</a>
                    </td>
                </tr>
                <?php
                }
            ?>
        </tbody>
    </table>

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
                                    $path_includes_page_admin_int_before = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-acp-page.php&page_num=" . ( $page_current - 1);
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
                                        
                                        $path_includes_page_admin_int = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-acp-page.php&page_num=" . $i;
                                    ?>
                                        <li class=""><a href="<?php echo $path_includes_page_admin_int; ?>"><?php echo $i; ?></a></li>
                                    <?php
                                        
                                    }
                                    
                                }
                            ?>
                            <?php
    
                                if ( $page_current < $num_page ) {
                                    $path_includes_page_admin_int_after = get_site_url() . "/wp-admin/admin.php?page=cstickets%2Fincludes%2Fcstickets-acp-page.php&page_num=" . ( $page_current + 1);
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

</div>

