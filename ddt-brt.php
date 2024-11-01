<?php
/**
 * Plugin Name:     DDT BRT
 * Description:     Crea documenti di trasporto in PDF per BRT direttamente da un ordine Woocommerce. Con la versione premium non avrai limiti di DDT emessi, mittenti registrati e molto altro...
 * Author:          Web alch Lab
 * Author URI:      https://www.webalchlab.it/
 * Domain Path:     /languages
 * Version:         1.0.1
 * WC requires at least: 3.0.0
 * WC tested up to: 4.1.0
 *
 * @package         WebAlch
 
 * WA Ddt Brt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 
 * WA Ddt Brt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 
 * You should have received a copy of the GNU General Public License
 * along with WA Ddt Brt. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
 */


/* Prevenzione da maleintenzionati */
defined('ABSPATH') OR exit;

global $wpdb;

//--------------------------------------------
define('waDdtBrt_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('waDdtBrt_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


//--------------------------------------------
require_once('asset/define.php');
require_once('asset/generate-ddt.php');
require_once('asset/view-ddt.php');
require_once('asset/mittenti.php');


/* Carico CSS e JS */
function carica_css_js() {
	 
  $url = $_SERVER['REQUEST_URI'];
     
  if (strpos($url, 'modifica-ddt') !== false || strpos($url, 'list-ddt') !== false || strpos($url, 'post_type=shop_order') !== false || strpos($url, 'brt-ddt-impostazioni') !== false || strpos($url, 'view-ddt') !== false || strpos($url, 'brt-ddt') !== false || strpos($url, 'brt-ddt-mittenti') !== false || strpos($url, 'post.php') !== false) {
	  wp_register_script('ddt-brt-script', plugins_url('/js/ddt-brt.js' , __FILE__ ), array( 'jquery' ), NULL, false);
      wp_enqueue_script('ddt-brt-script');
      
      wp_register_style('ddt-brt-style', plugins_url('/css/ddt-brt.css', __FILE__), false, '1.0.0');
      wp_enqueue_style('ddt-brt-style');
     
	  // Load the datepicker script (pre-registered in WordPress).
      wp_enqueue_script( 'jquery-ui-datepicker' );
      wp_register_style('ddt-brt-style-jquery-ui', plugins_url('/css/jquery-ui.css', __FILE__), false, '1.0.0');
      wp_enqueue_style('ddt-brt-style-jquery-ui');
  }
}
add_action('admin_enqueue_scripts', 'carica_css_js');




/* Voci di menu*/
add_action( 'admin_menu', 'add_manager_admin_menu' );

function add_manager_admin_menu() {
  add_menu_page(
      'DDT Brt: Impostazioni', //$page_title
      'DDT Brt', //$menu_title
      'manage_options', //$capability
      'waDdtBrt_brt-ddt-generale', //$menu_slug
      'waDdtBrt_config_ddt_function', //$function = ''
      'dashicons-list-view', //$icon_url = '',
      20
  );
	
	
	add_submenu_page( 
	  'waDdtBrt_brt-ddt-generale', //main page slug
      'DDT Libero', //subpage title
      'DDT Libero', //subpage menu item
      'manage_options', //capabilities
      'waDdtBrt_brt-ddt&order_id=libero', //slug
      'waDdtBrt_generate_ddt_function' //function
    );
	
	
	add_submenu_page( 
	  'waDdtBrt_brt-ddt-generale', //main page slug
      'Mittenti', //subpage title
      'Mittenti', //subpage menu item
      'manage_options', //capabilities
      'waDdtBrt_brt-ddt-mittenti', //slug
      'waDdtBrt_mittenti_ddt_function' //function
    );
	
    add_submenu_page( 
	  'waDdtBrt_brt-ddt-generale', //main page slug
      'Impostazioni', //subpage title
      'Impostazioni', //subpage menu item
      'manage_options', //capabilities
      'waDdtBrt_brt-ddt-impostazioni', //slug
      'waDdtBrt_config_ddt_function' //function
    );
	
	add_submenu_page( 
	  'waDdtBrt_brt-ddt-generale', //main page slug
      'Genera DDT', //subpage title
      'Genera DDT', //subpage menu item
      'manage_options', //capabilities
      'waDdtBrt_brt-ddt', //slug
      'waDdtBrt_generate_ddt_function' //function
    );
	
    add_submenu_page( 
	  'waDdtBrt_brt-ddt-generale', //main page slug
      'View DDT', //subpage title
      'View DDT', //subpage menu item
      'manage_options', //capabilities
      'waDdtBrt_view-ddt', //slug
      'waDdtBrt_view_ddt_function' //function
    );
	
}

add_action( 'admin_head', function() {
    remove_submenu_page( 'waDdtBrt_brt-ddt-generale', 'waDdtBrt_brt-ddt' );  // $menu_slug, $submenu_slug
	remove_submenu_page( 'waDdtBrt_brt-ddt-generale', 'waDdtBrt_view-ddt' );  // $menu_slug, $submenu_slug
	remove_submenu_page( 'waDdtBrt_brt-ddt-generale', 'waDdtBrt_brt-ddt-generale' );  // $menu_slug, $submenu_slug
} );





/* Aggiungo la colonna e il suo pulsante nella lista ordini - Anche il tracking code se attivo*/
function waDdtBrt_aggiungi_colonna_ordini( $columns ) {
   
	$new_columns = array();

    foreach ( $columns as $column_name => $column_info ) {

      $new_columns[ $column_name ] = $column_info;

      if ( 'order_total' === $column_name ) {
        $new_columns['order_ddt'] =  __( 'DDT BRT', 'my-textdomain' );	
	   }
    }
    return $new_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'waDdtBrt_aggiungi_colonna_ordini', 20 );



function waDdtBrt_generaordinbottone( $column ) {
  global $post;
  global $wpdb;
	
  if ( 'order_ddt' === $column ) {
	
	$sqlordine = 'SELECT * FROM '.waDdtBrt_TABLE_DDT_BRT . ' WHERE woocommerce_order = ' . $post->ID;
    $ordine_recuperato1 = $wpdb->get_results($sqlordine, ARRAY_A);	
	
	if(count($ordine_recuperato1) > 0){	
      printf( 'Generato');  	
	}else{	
	  // Prepare the button data
      $url    = admin_url( 'admin.php?page=waDdtBrt_brt-ddt&order_id=' . $post->ID );
      $name   = esc_attr( __('Genera', 'woocommerce' ) );
	  $datatips = "Genera il DDT con procedura passo passo";	
      $action = esc_attr( 'Genera o Carica DDT' ); // keep "view" class for a clean button CSS
      // Set the action button
      printf( '<a class="button tips %s" href="%s" data-tip="%s" target="_blank">%s</a>', $action, $url, $datatips, $name );  	
	}

  }
	
}
add_action( 'manage_shop_order_posts_custom_column', 'waDdtBrt_generaordinbottone' );



function waDdtBrt_generate_admin_button($url, $name, $datatips, $action) {
  printf( '<a class="button tips %s" href="%s" data-tip="%s" target="_blank">%s</a>', $action, $url, $datatips, $name );
}



function waDdtBrt_order_details_buttons($order) {
  global $wpdb;

  $sqlordine = 'SELECT * FROM '.waDdtBrt_TABLE_DDT_BRT . ' WHERE woocommerce_order = ' . $order->ID;
    $ordine_recuperato1 = $wpdb->get_results($sqlordine, ARRAY_A);	

    echo '<p class="azioni-ordine">';
    //PULSANTE GENERA/VISUALIZZA
      $url    = (count($ordine_recuperato1) > 0 ?  admin_url( 'admin.php?page=waDdtBrt_view-ddt&order_id=' . $order->ID ) : admin_url( 'admin.php?page=waDdtBrt_brt-ddt&order_id=' . $order->ID ));
      $name   = (count($ordine_recuperato1) > 0 ? esc_attr( __('Visualizza', 'woocommerce' ) ) : esc_attr( __('Genera', 'woocommerce' ) ));
	    $datatips = (count($ordine_recuperato1) > 0 ? "Visualizza DDT generato precedentemente" : "Genera il DDT con procedura passo passo" );
      $action = (count($ordine_recuperato1) > 0 ? esc_attr( 'visualizza-DDT' ) : esc_attr( 'gen-load-DDT' )); // keep "view" class for a clean button CSS
      // Set the action button
      waDdtBrt_generate_admin_button($url, $name, $datatips, $action);

    echo '</p>';
}

add_action('woocommerce_admin_order_data_after_order_details', 'waDdtBrt_order_details_buttons');



// -------------  SEZIONE IMPOSTAZIONI E CONFIGURAZIONE DEL PLUGINS   ---------------------------------------------


function waDdtBrt_config_ddt_function() {
  if (!current_user_can('manage_options')) {
      return;
  }

    $numDdt = (isset($_POST['numero_ddt']) ? sanitize_text_field($_POST['numero_ddt']) : get_option('brt-dtt-next_number'));
    $tracksino = (isset($_POST['tracking_def']) ? sanitize_text_field($_POST['tracking_def']) : get_option('brt-dtt-tracking_enable'));
    $trackreq = (isset($_POST['tracking_req']) ? sanitize_text_field($_POST['tracking_req']) : get_option('brt-dtt-tracking_required'));
    $tracking_length = (isset($_POST['tracking_length']) ? sanitize_text_field($_POST['tracking_length']) : get_option('brt-dtt-tracking_length'));
  
  if(isset($_POST['submit']) && $_POST['upconfigbrt'] == 1) {
    update_option('brt-dtt-next_number', $numDdt);
    update_option('brt-dtt-tracking_enable', $tracksino);
    update_option('brt-dtt-tracking_required', $trackreq);
    update_option('brt-dtt-tracking_length', $tracking_length);
    
    echo '<div class="disclamer-ok-wa-brt">Opzioni aggiornate con successo</div>';
  }
?>
  
  <div class="options-wrap option-wrap-wabrt">
    <form id="ddt-brt-opzioni" action="<?php echo admin_url()."admin.php?page=waDdtBrt_brt-ddt-impostazioni"; ?>" name="opzioni-ddt-brt" method="post">
	<?php    
		
    ?>  
	  
    <h1>IMPOSTAZIONI DDT BRT</h1>
	  <p>In questa sezione troverai le seguenti impostazioni per il plugin:</p>
    <hr>
    <h3>Prossimo numero DDT</h3>
	  <p>Imposta il PROSSIMO numero di emissione nel DDT:</p>
    <input class="numero-ddt" type="number" name="numero_ddt" value="<?php echo $numDdt; ?>" required />  
		
    <p><input type="hidden" name="upconfigbrt" value="1" />
		<input class="bottone-verde-wabrt" type="submit" name="submit" value="Salva Impostazioni" /></p>
	</form>

    <div class="wabrt-acquistapro">
	 <div class="cont-whitw-wabrt-acquistapro">
	  <h3>Acquista la versione PRO</h3>
	  <p>Con la versione Professional hai i seguenti vantaggi:</p>
	  <ul>
	   <li>Nessun limite giornaliero per i DDT emessi</li>
	   <li>Possibilità di genereare il Tracking Code tramite l’inserimento del numero dell’etichetta rossa BRT</li>
	   <li>Se presente il Tracking Code arriverà all'utente il link nell'email "Ordine Completato"</li>
	   <li>Possibilità di avere più Mittenti inseriti in archivio e selezionare quello opportuno nella fase di creazione DDT</li>
	   <li>Archivio storico dei DDT emessi</li>
	   <li>Possibilità di emettere DDT liberi, senza necessariamente la presenza di un ordine in Woocommerce</li>
	  </ul>
	  <p><a href="https://www.webalchlab.it/prodotto/plugin-wordpress/plugin-ddt-brt-pro-per-woocommerce" class="bottone-blu-wabrt">Acquista la versione PRO</a></p>
     </div>
	</div>
   
	<div class="wabrt-acquistapro">
	 <div class="cont-whitw-wabrt-acquistapro">
	  <h3>Hai bisogno di Aiuto?</h3>
	  <p>Per qualsiasi domanda, suggerimenti o segnalazioni di BUG non<br /> esitare a scriverci oppure consulta la documentazione.</p>
	  <p><a href="https://www.webalchlab.it/prodotto/plugin-wordpress/plugin-ddt-brt-pro-per-woocommerce" class="bottone-blu-wabrt">Documentazione</a> <a href="mailto:info@webalchemy.it" class="bottone-verde-wabrt">Scrivici</a></p>
     </div>	
    </div>

 </div>
  <?php
}

function waDdtBrt_generate_tables_and_defaults(){
  global $wpdb;
  $tod = date('Ymd');	
  $tablesQuery = array();

  $tablesQuery['ddt_brt'] = 'CREATE TABLE NOMETAB (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `n_ddt` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `woocommerce_order` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dest_nome` varchar(255) DEFAULT NULL,
  `dest_ind_1` varchar(255) DEFAULT NULL,
  `dest_ind_2` varchar(255) DEFAULT NULL,
  `dest_cap` varchar(255) DEFAULT NULL,
  `dest_loc` varchar(255) DEFAULT NULL,
  `dest_prov` varchar(255) DEFAULT NULL,
  `dest_ref` varchar(255) DEFAULT NULL,
  `dest_ref_tel` varchar(255) DEFAULT NULL,
  `dest_ref_email` varchar(255) DEFAULT NULL,
  `servizio` varchar(255) DEFAULT NULL,
  `colli` varchar(255) DEFAULT NULL,
  `peso` varchar(255) DEFAULT NULL,
  `volume` varchar(255) DEFAULT NULL,
  `natura` varchar(255) DEFAULT NULL,
  `consegna_rich` varchar(255) DEFAULT NULL,
  `chiusura` varchar(255) DEFAULT NULL,
  `contrassegno` varchar(255) DEFAULT NULL,
  `mod_incasso` varchar(255) DEFAULT NULL,
  `val_assicurato` varchar(255) DEFAULT NULL,
  `note` varchar(400) DEFAULT NULL,
  `mittente_nome` varchar(255) NOT NULL,
  `mittente_ind` varchar(255) NOT NULL,
  `mittente_ind2` varchar(255) NOT NULL,
  `mittente_cap` varchar(255) NOT NULL,
  `mittente_loc` varchar(255) NOT NULL,
  `mittente_prov` varchar(255) NOT NULL,
  `mittente_ref` varchar(255) NOT NULL,
  `mittente_ref_tel` varchar(255) NOT NULL,
  `tracking_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) SETCARATT';

  $tablesQuery['ddt_brt_mittenti'] = 'CREATE TABLE NOMETAB (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mitt_nome` varchar(255) DEFAULT NULL,
  `mitt_ind` varchar(255) DEFAULT NULL,
  `mitt_ind_2` varchar(255) DEFAULT NULL,
  `mitt_cap` varchar(255) DEFAULT NULL,
  `mitt_loc` varchar(255) DEFAULT NULL,
  `mitt_prov` varchar(255) DEFAULT NULL,
  `mitt_ref` varchar(255) DEFAULT NULL,
  `mitt_ref_tel` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (id)
) SETCARATT';

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  add_option('brt-dtt-next_number', 1);
  add_option('brt-dtt-mitt_default', 0);
  add_option('brt-dtt-cod-mitt', "");
  add_option('brt-dtt-checkformat', waDdtBrt_CONTD.$tod);	

  foreach($tablesQuery as $name => $query) {
    $table_name = $wpdb->prefix . $name;

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $charset_collate = $wpdb->get_charset_collate();

      $sql = str_replace(array('NOMETAB', 'SETCARATT'), array($table_name, $charset_collate), $query);

      dbDelta( $sql );
    }
  }
  
  //------------- CANCELLO FILES DI CACHE DEI FONT ---------------------//
  $filesToDelete = array(
    '/lib/font/unifont/dejavusanscondensed.cw.dat',
    '/lib/font/unifont/dejavusanscondensed.cw127.php',
    '/lib/font/unifont/dejavusanscondensed.mtx.php'
  );
  foreach($filesToDelete as $path) {
    if(file_exists(__DIR__.$path)) {
      unlink(__DIR__.$path);
    }
  }
}

register_activation_hook(__FILE__, 'waDdtBrt_generate_tables_and_defaults');


define('waDdtBrt_NOTCONG', ' value="LIMITE GIORNALIERO DDT RAGGIUNTO" />');


