<?php
    $path = preg_replace('/wp-content.*$/','',__DIR__); 

    require_once( $path . 'wp-load.php' );

    global $wpdb;

    if ( empty( $_POST ) ) {
        die("ERROR #0001");
    }

    $data_json = array(
        'msg' => '',
        'html' => '',
        'http_status' => 200,
        'status' => 'OK',
        'data' => array()
    );

    if ( $_POST["function"] === "save-provider" ) {
        $name_commercial_provider = '';
        $name_provider            = '';
        $rfc_provider             = '';
        $direction                = '';

        if ( !empty( $_POST["name_commercial_provider"] ) ) {
            $name_commercial_provider = $_POST["name_commercial_provider"];
        }else{
            $data_json = array(
                'msg' => 'Falta nombre comercial de proveedor',
                'html' => '',
                'http_status' => 200,
                'status' => 'FAIL',
                'data' => array()
            );

            echo json_encode( $data_json );

            die();
        }

        if ( !empty( $_POST["name_provider"] ) ) {
            $name_provider = $_POST["name_provider"];
        }else{
            $data_json = array(
                'msg' => 'Falta nombre de proveedor',
                'html' => '',
                'http_status' => 200,
                'status' => 'FAIL',
                'data' => array()
            );

            echo json_encode( $data_json );

            die();

        }

        if ( !empty( $_POST["rfc_provider"] ) ) {
            $rfc_provider = $_POST["rfc_provider"];
        }else{
            $data_json = array(
                'msg' => 'Falta el rfc',
                'html' => '',
                'http_status' => 200,
                'status' => 'FAIL',
                'data' => array()
            );

            echo json_encode( $data_json );

            die();

        }
        
        if ( !empty( $_POST["direction"] ) ) {
            $direction = $_POST["direction"];
        }else{
            $data_json = array(
                'msg' => 'Falta la dirección',
                'html' => '',
                'http_status' => 200,
                'status' => 'FAIL',
                'data' => array()
            );

            echo json_encode( $data_json );

            die();

        }

        $sql_exist_provider = sprintf( "SELECT *
                                        FROM wp_cstickets_provider
                                        WHERE name_commercial_provider = '%s' OR name_provider = '%s' OR rfc_provider = '%s';",
                                        $name_commercial_provider, $name_provider, $rfc_provider );

        $prepared_query = $wpdb->prepare( $sql_exist_provider );

        $results_exist_provider = $wpdb->get_results( $prepared_query );

        if ( !empty( $results_exist_provider ) ) {
            $data_json = array(
                'msg' => 'Duplicate',
                'html' => '',
                'http_status' => 200,
                'status' => 'OK',
                'data' => array()
            );

            echo json_encode( $data_json );

            die();
            
        }

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