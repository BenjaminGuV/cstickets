<?php
    global $wpdb;

    $table_name                  = $wpdb->prefix . "cstickets_provider";
    $table_name_tickets          = $wpdb->prefix . "cstickets_tickets";
    $table_name_products         = $wpdb->prefix . "cstickets_products";
    $table_name_tickets_products = $wpdb->prefix . "cstickets_tickets_products";
    $my_products_db_version      = '1.0.0';
    $charset_collate             = $wpdb->get_charset_collate();

    $ban_create = false;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {

        $sql = "CREATE TABLE $table_name (
                `id_$table_name` INT NOT NULL AUTO_INCREMENT,
                `name_commercial_provider` VARCHAR(200) NULL DEFAULT '',
                `name_provider` VARCHAR(200) NULL DEFAULT '',
                `rfc_provider` VARCHAR(13) NULL DEFAULT '',
                `direction` VARCHAR(200) NULL DEFAULT '',
                `create_date` DATETIME,
                `status` TINYINT(1) NULL DEFAULT 0,
                PRIMARY KEY  (`id_$table_name`)
        ) $charset_collate;";

        //require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);

        $ban_create = true;
    }


    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name_tickets}'") != $table_name_tickets ) {
        $sql = "CREATE TABLE $table_name_tickets (
                `id_$table_name_tickets` INT NOT NULL AUTO_INCREMENT,
                `code` VARCHAR(200) NULL DEFAULT '',
                `create_date` DATETIME,
                `subtotal` DECIMAL(10, 2) NULL DEFAULT 0.00,
                `iva` DECIMAL(10, 2) NULL DEFAULT 0.00,
                `total` DECIMAL(10, 2) NULL DEFAULT 0.00,
                `status` TINYINT(1) NULL DEFAULT 0,
                `fid_$table_name` INT(11) NULL DEFAULT 0,
                PRIMARY KEY  (`id_$table_name_tickets`)
        ) $charset_collate;";

        //require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);

        $ban_create = true;
    }


    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name_products}'") != $table_name_products ) {
        $sql = "CREATE TABLE $table_name_products (
                `id_$table_name_products` INT NOT NULL AUTO_INCREMENT,
                `code` VARCHAR(200) NULL DEFAULT '',
                `name` VARCHAR(200) NULL DEFAULT '',
                `precio` DECIMAL(10, 2) NULL DEFAULT 0.00,
                `status` TINYINT(1) NULL DEFAULT 0,
                `fid_$table_name` INT(11) NULL DEFAULT 0,
                PRIMARY KEY  (`id_$table_name_products`)
        ) $charset_collate;";

        //require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);

        $ban_create = true;
    }


    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name_tickets_products}'") != $table_name_tickets_products ) {
        $sql = "CREATE TABLE $table_name_tickets_products (
                `id_$table_name_tickets_products` INT NOT NULL AUTO_INCREMENT,
                `code` VARCHAR(200) NULL DEFAULT '',
                `name` VARCHAR(200) NULL DEFAULT '',
                `cant` INT(11) NULL DEFAULT 0,
                `precioxone` DECIMAL(10, 2) NULL DEFAULT 0.00,
                `precioxtotal` DECIMAL(10, 2) NULL DEFAULT 0.00,
                `status` TINYINT(1) NULL DEFAULT 0,
                `fid_tickets_products` INT(11) NULL DEFAULT 0,
                PRIMARY KEY  (`id_$table_name_tickets_products`)
        ) $charset_collate;";

        //require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);

        $ban_create = true;
    }