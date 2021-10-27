<?php

if ( !function_exists( 'csts_cstickets_add_my_admin_link' ) ) {

  function csts_cstickets_add_my_admin_link()
  {

    csts_cstickets_callback_scripts();

    //csts_cstickets_load_textdomain();

      $path_includes_page_admin = plugin_dir_path(__FILE__) . "cstickets-acp-page.php";
  
      add_menu_page(
          'CSTICKETS', // Title of the page
          'CSTickets', // Text to show on the menu link
          'manage_options', // Capability requirement to see the link
          $path_includes_page_admin // The 'slug' - file to display when clicking the link
      );
  }

}

//insert styles and js
if ( !function_exists( 'csts_cstickets_callback_scripts' ) ) {

  function csts_cstickets_callback_scripts() {
    //
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