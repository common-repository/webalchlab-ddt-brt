<?php
/** */


/* Prevenzione da maleintenzionati */
defined('ABSPATH') OR exit;

function waDdtBrt_view_ddt_function() {
  if (!current_user_can('manage_options')) {
      return;
  }

  global $wpdb;
	
  $order_id = (isset($_GET['order_id']) ? sanitize_text_field($_GET['order_id']) : "errore" );
	
  /*---------------------  VISUALIZZO PDF -------------------------------*/
  
  if($order_id != "errore") {
	  
	 if ($order_id != ""){
		  
       $sqlord = 'SELECT * FROM '.waDdtBrt_TABLE_DDT_BRT . ' WHERE woocommerce_order = ' . $order_id;
       $ordine_recuperato = $wpdb->get_results($sqlord, ARRAY_A);	
	
	  
       foreach($ordine_recuperato as $ordinerec) {	
	  
		 $dobvalue3 = DateTime::createFromFormat('Y-m-d H:i:s', $ordinerec['date']);
	     $data_ddt = $dobvalue3->format('d/m/Y');
		   
	     $numero_ddt = (isset($ordinerec['n_ddt']) ? sanitize_text_field($ordinerec['n_ddt']) : '');
	     $idutente = (isset($ordinerec['user_id ']) ? sanitize_text_field($ordinerec['user_id ']) : ''); 
		 
	     $mitt_nome = (isset($ordinerec['mittente_nome']) ? stripslashes(sanitize_text_field($ordinerec['mittente_nome'])) : '');
         $mitt_ind_1 = (isset($ordinerec['mittente_ind']) ? stripslashes(sanitize_text_field($ordinerec['mittente_ind'])) : '');
         $mitt_ind_2 = (isset($ordinerec['mittente_ind2']) ? stripslashes(sanitize_text_field($ordinerec['mittente_ind2'])) : '');
         $mitt_cap = (isset($ordinerec['mittente_cap']) ? sanitize_text_field($ordinerec['mittente_cap']) : '');
         $mitt_loc = (isset($ordinerec['mittente_loc']) ? stripslashes(sanitize_text_field($ordinerec['mittente_loc'])) : '');
         $mitt_prov = (isset($ordinerec['mittente_prov']) ? sanitize_text_field($ordinerec['mittente_prov']) : '');
         $mitt_ref = (isset($ordinerec['mittente_ref']) ? stripslashes(sanitize_text_field($ordinerec['mittente_ref'])) : '');;
         $mitt_ref_tel = (isset($ordinerec['mittente_ref_tel']) ? sanitize_text_field($ordinerec['mittente_ref_tel']) : ''); 
		 
	     $dest_nome = (isset($ordinerec['dest_nome']) ? stripslashes(sanitize_text_field($ordinerec['dest_nome'])) : '');
         $dest_ind_1 = (isset($ordinerec['dest_ind_1']) ? stripslashes(sanitize_text_field($ordinerec['dest_ind_1'])) : '');
         $dest_ind_2 = (isset($ordinerec['dest_ind_2']) ? stripslashes(sanitize_text_field($ordinerec['dest_ind_2'])) : '');
         $dest_cap = (isset($ordinerec['dest_cap']) ? sanitize_text_field($ordinerec['dest_cap']) : '');
         $dest_loc = (isset($ordinerec['dest_loc']) ? stripslashes(sanitize_text_field($ordinerec['dest_loc'])) : '');
         $dest_prov = (isset($ordinerec['dest_prov']) ? sanitize_text_field($ordinerec['dest_prov']) : '');
         $dest_ref = (isset($ordinerec['dest_ref']) ? stripslashes(sanitize_text_field($ordinerec['dest_ref'])) : '');
         $dest_ref_tel = (isset($ordinerec['dest_ref_tel']) ? sanitize_text_field($ordinerec['dest_ref_tel']) : ''); 
         $dest_ref_email = (isset($ordinerec['dest_ref_email']) ? $ordinerec['dest_ref_email'] : "");
		 
         $tipo_servizio = (isset($ordinerec['servizio']) ? sanitize_text_field($ordinerec['servizio']) : '');
	
	     $n_colli = (isset($ordinerec['colli']) ? stripslashes(sanitize_text_field($ordinerec['colli'])) : '');
	     $peso = (isset($ordinerec['peso']) ? stripslashes(sanitize_text_field($ordinerec['peso'])) : '');
	     $volume = (isset($ordinerec['volume']) ? stripslashes(sanitize_text_field($ordinerec['volume'])) : '');
	     $natura_merce = (isset($ordinerec['natura']) ? stripslashes(sanitize_text_field($ordinerec['natura'])) : '');
	     $data_consegna_richiesta = (isset($ordinerec['consegna_rich']) ? sanitize_text_field($ordinerec['consegna_rich']) : '');
	     $turno_chiusura = (isset($ordinerec['chiusura']) ? sanitize_text_field($ordinerec['chiusura']) : '');
         $importo_contrassegno =(isset($ordinerec['contrassegno']) ? sanitize_text_field($ordinerec['contrassegno']) : '');
         $mod_incasso = (isset($ordinerec['mod_incasso']) ? sanitize_text_field($ordinerec['mod_incasso']) : '');
	     $valora_assicurare = (isset($ordinerec['val_assicurato']) ? sanitize_text_field($ordinerec['val_assicurato']) : '');
		 
         $note_cli = (isset($ordinerec['note']) ? stripslashes(sanitize_text_field($ordinerec['note'])) : '');	
		 
	   }
	  
	  
	   $nome_file_finale = $numero_ddt."-ddt-ordine-".$order_id.".pdf";

       // INIZIO IL PDF

       ob_get_clean();
       require_once( waDdtBrt_PLUGIN_PATH.'lib/tfpdf.php');
       $pdf = new tFPDF();
       $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf', true);
 	   $pdf->AddPage();
	   $pdf->Image(waDdtBrt_FILE_DDT_BASE, 0, 0, 210, 297);

	   $pdf->SetFont('DejaVu','',10);
	   $pdf->Text(11,47.3,$numero_ddt);
	   $pdf->Text(122,47.3,$data_ddt);

       $pdf->Text(11,59.5,$mitt_nome);
       $pdf->Text(11,76,$mitt_ind_1);
       $pdf->Text(11,80.5,$mitt_ind_2);
       $pdf->SetFont('DejaVu','',8);
       $pdf->Text(11,90,$mitt_cap);
       $pdf->Text(48.5,90,$mitt_loc);
       $pdf->Text(122,90,$mitt_prov);
       $pdf->Text(48.5,95,$mitt_ref);
       $pdf->Text(138,95,$mitt_ref_tel);

       $pdf->SetFont('DejaVu','',10);
       $pdf->Text(11,108,$dest_nome);
       $pdf->Text(11,123.7,$dest_ind_1);
       $pdf->Text(11,128.3,$dest_ind_2);
       $pdf->SetFont('DejaVu','',8);
       $pdf->Text(11,140.5,$dest_cap);
       $pdf->Text(48.5,140.5,$dest_loc);
       $pdf->Text(122,140.5,$dest_prov);
       $pdf->Text(48.5,146.5,$dest_ref);
       $pdf->Text(138,146,$dest_ref_tel);
       $pdf->Text(48.5,152,$dest_ref_email);

       $pdf->SetFont('DejaVu','',12);
       
	   if($tipo_servizio == "P.TO FRANCO"){
		 $pdf->Text(52.8,163.2,"X");  
	   }
		 
	   if($tipo_servizio == "P.TO ASSEGNATO"){
		 $pdf->Text(52.8,169.8,"X");
	   }
		 
	   if($tipo_servizio == "SERVIZIO PRIORITY"){
		 $pdf->Text(121.7,163.2,"X"); 
	   }
		 
	   if($tipo_servizio == "SERVIZIO 10:30"){
		 $pdf->Text(121.7,169.8,"X");  
	   }
		
	   if($tipo_servizio == "FERMO DEPOSITO"){
		 $pdf->Text(182.2,163.2,"X");  
	   }

       $pdf->SetFont('DejaVu','',9);
       $pdf->Text(14,183,$n_colli);
       $pdf->Text(60,183,$peso);
       $pdf->Text(130,183,$volume);

       $pdf->Text(14,193.5,$natura_merce);

       $pdf->Text(60,193.5, ($data_consegna_richiesta == '01/01/1970' ? "" : $data_consegna_richiesta));
	   $pdf->Text(130,193.5,$turno_chiusura);

       $pdf->Text(14,203.8,$importo_contrassegno);
       $pdf->Text(60,203.8,$mod_incasso);
       $pdf->Text(130,203.8,$valora_assicurare);
      
       $pdf->SetFont('DejaVu','',8);
       if($note_cli != '') {
        $lineLength = 140; //Lunghezza di una riga in Dejavu 8
        $lines = 3; //Numero di righe che stanno nel campo note
        $splitNote = str_split($note_cli, $lineLength);
        $index = 0;
        while($index < count($splitNote) && $index < $lines){
          $pdf->Text(11,(216 + 3 * $index),$splitNote[$index]);
          $index++;
        }
       } else {
        $pdf->Text(11,216,$note_cli);
       }

       $pdf->Output("I",$nome_file_finale,true);

	 }else{
		 echo "Impossibile emettere il DDT per l'ordine: IDOrder = 0";
	 }
	  
  }
 }



function waDdtBrt_checkuniformat() {
  if (!current_user_can('manage_options')) {
      return;
  }
  $tod = date('Ymd');
  $checkformat = get_option('brt-dtt-checkformat');
  $checkformatexp = explode ("-", $checkformat);
  
  if($checkformatexp[1] !==  $tod ){
	   update_option('brt-dtt-checkformat', waDdtBrt_CONTD.$tod );
	   return true;
  }	
	
  if($checkformatexp[0] > 4 ){
    return false;  //false
  }else{
	return true;  
  }
	
}

function waDdtBrt_checkuniformat_agg() {
  if (!current_user_can('manage_options')) {
      return;
  }

  $checkformat = get_option('brt-dtt-checkformat');
  $checkformatexp = explode ("-", $checkformat);
  $x = intval($checkformatexp[0]);
  $x++;
  update_option('brt-dtt-checkformat', $x.'-'.$checkformatexp[1] );	  
	
}


function waDdtBrt_checkuniformat_unicode() {
  if (!current_user_can('manage_options')) {
      return;
  }

  global $wpdb;
	
  $wpdb->get_results(waDdtBrt_MITCONTA, ARRAY_A);	

  if($wpdb->num_rows >= 1){
	  return false;  //false
  }else{
      return true;
  }
}



?>