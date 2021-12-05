<?php 
    global $wpdb;
    

    $table_provider      = $wpdb->prefix . "cstickets_provider";
    $table_name_products = $wpdb->prefix . "cstickets_products";
    

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

    $sql_list_tickets = sprintf( "SELECT wp_cstickets_tickets.*, id_wp_cstickets_tickets as id,
                                        wp_cstickets_provider.name_commercial_provider as nombre_proveedor
                                    FROM wp_cstickets_tickets
                                    INNER JOIN wp_cstickets_provider ON wp_cstickets_tickets.fid_wp_cstickets_provider = wp_cstickets_provider.id_wp_cstickets_provider
                                    ORDER BY id_wp_cstickets_tickets DESC;" );

    $prepared_query = $wpdb->prepare( $sql_list_tickets );

    $list_tickets = $wpdb->get_results( $prepared_query );


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
                    $link = sprintf( '%s&id=%s', $path_includes_page_admin_tickets, $list_tickets[$key]->id );
                    echo $link;
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

</div>