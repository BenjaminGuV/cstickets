<?php

if ( !function_exists( 'csts_cstickets_add_my_admin_link' ) ) {

  function csts_cstickets_add_my_admin_link()
  {

    csts_cstickets_callback_scripts();

    //csts_cstickets_load_textdomain();

      $path_includes_page_admin          = plugin_dir_path(__FILE__) . "cstickets-acp-page.php";
      $path_includes_page_admin_provider = plugin_dir_path(__FILE__) . "cstickets-provider.php";
      $path_includes_page_admin_products = plugin_dir_path(__FILE__) . "cstickets-products.php";
      $path_includes_page_admin_tickets  = plugin_dir_path(__FILE__) . "cstickets-tickets.php";
      $path_includes_page_admin_pdf  = plugin_dir_path(__FILE__) . "cstickets-pdf.php";
  
      add_menu_page(
          'CSTICKETS', // Title of the page
          'CSTickets', // Text to show on the menu link
          'manage_options', // Capability requirement to see the link
          $path_includes_page_admin, // The 'slug' - file to display when clicking the link
          '',
          '',
          null
      );

      //submenu
      add_submenu_page( $path_includes_page_admin, 'Proveedores', 'Proveedores', 'manage_options', $path_includes_page_admin_provider, '');
      add_submenu_page( $path_includes_page_admin, 'Productos', 'Productos', 'manage_options', $path_includes_page_admin_products, '');
      add_submenu_page( $path_includes_page_admin, 'Generar tickets', 'Generar tickets', 'manage_options', $path_includes_page_admin_tickets, '');
      add_submenu_page( null, '', '', 'manage_options', $path_includes_page_admin_pdf, 0);

  }

}



if ( !function_exists( 'csts_cstickets_print_html' ) ) {

    function csts_cstickets_print_html ( $content ) {
      global $wpdb;
    
      ob_start();
      
    
      ?>
        <h1>Nuevo</h1>
      <?php
    
      $html_votes = ob_get_contents();
      ob_end_clean();
    
      return $html_votes;
    }
  }


//install tables
if ( !function_exists( 'csts_cstickets_installer' ) ) {

  function csts_cstickets_installer(){
  
    $url_installer = plugin_dir_path(__FILE__) . "cstickets-installer.php";
  
    include( $url_installer );
  
  }
}


//insert styles and js
if ( !function_exists( 'csts_cstickets_callback_scripts' ) ) {

  function csts_cstickets_callback_scripts() {
  
    $url_newmoji = CSTS_CSTICKETS__PLUGIN_URL . 'assets';

    wp_register_style( 'select2', $url_newmoji . "/css/select2.css" );
    wp_enqueue_style( 'select2' );
    wp_register_style( 'namespace', $url_newmoji . "/css/cstickets.css" );
    wp_enqueue_style( 'namespace' );
    wp_enqueue_script( 'namespaceformyscriptselect2', $url_newmoji . "/js/select2.js", array(), false, true );
    wp_enqueue_script( 'namespaceformyscript', $url_newmoji . "/js/cstickets.js", array(), false, true );
    wp_enqueue_script( 'namespaceformyscriptdos', $url_newmoji . "/js/main.js", array(), false, true );

    wp_localize_script( 
      'namespaceformyscriptdos', 
      'localize_vars', 
      array( 
        'url' => site_url('/')
      ) 
    );

    wp_localize_script( 
      'namespaceformyscript', 
      'localize_vars', 
      array( 
        'url' => site_url('/')
      ) 
    );

    wp_localize_script( 
      'namespaceformyscriptdos', 
      'localize_vars', 
      array( 
        'url' => site_url('/')
      ) 
    );

  }
}


// calls AJAX
if ( !function_exists( 'csts_cstickets_save_ajax' ) ) {
  function csts_cstickets_save_ajax(){
    global $wpdb;

    $temp         = array();
    $list_product = array();

    if ( !empty( $_POST["list_product"] ) ) {

      //save tickets
      $table_name_tickets = $wpdb->prefix . "cstickets_tickets";
      $table_name         = $wpdb->prefix . "cstickets_provider";
      $fid_table_tickets = sprintf("fid_%s", $table_name);
        
      $wpdb->insert( $table_name_tickets, 
        array(
          'code'             => 'asdasd',
          'create_date'      => date('Y-m-d H:i:s'),
          'subtotal'         => $_POST["subtotal"],
          'iva'              => $_POST["iva"],
          'total'            => $_POST["total"],
          'status'           => 1,
          $fid_table_tickets => 1
        ),
        array(
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%d',
          '%d'
        ) 
      );

      // all rows without filter
    $sql_select_all = sprintf( "SELECT id_%1\$s as id_last
                                FROM %1\$s
                                ORDER BY id_%1\$s DESC;", $table_name_tickets );

    $prepared_query_select_all = $wpdb->prepare( $sql_select_all );

    $results_select_all = $wpdb->get_results( $prepared_query_select_all );

    $id_last_tickets = $results_select_all[0]->id_last;

      //save products
      foreach( $_POST["list_product"] as $key => $value ){
        
        //$_POST["list_product"][$key] = preg_replace("\\\"", "'", $_POST["list_product"][$key]);
        $_POST["list_product"][$key] = stripslashes( $_POST["list_product"][$key] );
       
        $tmp_index = json_decode( $_POST["list_product"][$key] );

        $temp[] = $tmp_index;

        $table_name_tickets_products = $wpdb->prefix . "cstickets_tickets_products";
        
        $wpdb->insert( $table_name_tickets_products, 
          array(
            'code'                 => $tmp_index->code,
            'name'                 => $tmp_index->nombre,
            'cant'                 => $tmp_index->cantidad,
            'precioxone'           => $tmp_index->pricexunit,
            'precioxtotal'         => $tmp_index->pricexcant,
            'status'               => 1,
            'fid_tickets_products' => $id_last_tickets
          ),
          array(
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
            '%d',
            '%d'
          ) 
        );

      }
    }


    wp_send_json( 
      array(
        'message'   => __('Your reaction has already been captured', 'newmoji'),
        'status'    => 'OK',
        'html'      => '',
        'http_code' => 200,
        "post"      => $_POST,
        "nombre"    => $list_product,
        "temp"      => $temp
      ) 
    );
  }
}

if ( !function_exists( 'csts_cstickets_get_ajax' ) ) {
  function csts_cstickets_get_ajax(){
    global $wpdb;

    $temp         = array();
    $list_product = array();


    $id_product = isset( $_POST['id_product'] ) ? sanitize_text_field( $_POST['id_product'] ) : false;

    
    if ( !empty( $_POST["list_product"] ) ) {
      
    }
    

    $sql_data_products = sprintf("SELECT *
                                  FROM wp_cstickets_products
                                  WHERE fid_wp_cstickets_provider = 1
                                    AND id_wp_cstickets_products = %d;", $id_product);

    $temp_data_products = $wpdb->prepare($sql_data_products);
    $data_products      = $wpdb->get_results( $temp_data_products );

    

    wp_send_json( 
      array(
        'message'   => __('Your reaction has already been captured', 'newmoji'),
        'status'    => 'OK',
        'html'      => '',
        'http_code' => 200,
        'data'      => $data_products,
        'sql'       => $sql_data_products,
        "post"      => $_POST,
        "nombre"    => $list_product,
        "temp" => $temp
      ) 
    );
  }
}

