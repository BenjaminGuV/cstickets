<?php
    $path = preg_replace('/wp-content.*$/','',__DIR__); 

    require_once( $path . 'wp-load.php' );

    global $wpdb;

    if ( empty( $_POST ) ) {
        die("ERROR #0001");
    }

    if ( $_POST["function"] === "save-provider" ) {
        $name_commercial_provider = $_POST["name_commercial_provider"];
        $name_provider            = $_POST["name_provider"];
        $rfc_provider             = $_POST["rfc_provider"];
        $direction                = $_POST["direction"];

        $data_save = array(
            'name_commercial_provider' => $name_commercial_provider,
            'name_provider'            => $name_provider,
            'rfc_provider'             => $rfc_provider,
            'direction'                => $direction,
            'status'                   => 1,
            'create_date'              => date('Y-m-d H:i:s')
        );

        $temp_result = $wpdb->insert( $wpdb->prefix . 'cstickets_provider', 
            $data_save,
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ) 
        );

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        
    }

    if ( $_POST["function"] === "save-productos" ) {
        $code        = $_POST["code"];
        $name        = $_POST["name"];
        $precio      = $_POST["precio"];
        $id_provider = $_POST["id_provider"];

        $name_column_provider = sprintf( "fid_%s", $wpdb->prefix . "cstickets_provider" );

        $data_save = array(
            'code'                => $code,
            'name'                => $name,
            'precio'              => $precio,
            'status'              => 1,
            $name_column_provider => $id_provider,
        );


        $temp_result = $wpdb->insert( $wpdb->prefix . 'cstickets_products', 
            $data_save,
            array(
                '%s',
                '%s',
                '%f',
                '%d',
                '%d'
            ) 
        );

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    if ( $_POST["function"] === "save-tickets-productos" ) {
        echo "<pre>";
        echo var_dump( $_POST );
        echo "</pre>";
    }

?>