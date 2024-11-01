<?php
/** */


/* Prevenzione da maleintenzionati */
defined('ABSPATH') OR exit;



function waDdtBrt_generate_ddt_function() {
  if (!current_user_can('manage_options')) {
      return;
  }

  global $wpdb;
	
  if(isset($_GET['order_id'])){
	  
	if($_GET['order_id'] != "libero" ){  
	    $order_id = sanitize_text_field($_GET['order_id']);  // Se genererato da normale funzionamento
	}else{
		$order_id = "libero";  // Se generare DDT Libero no legato a woocommerce
	}	  
	  
   }else{
 	 $order_id = "errore"; 
   }
	
	
  /*---------------------  GENERO PDF -------------------------------*/
  
  if(isset($_POST['submit']) && $order_id != "errore") {
	  
	 if ($order_id != ""){
		 
	   $dobvalue3 = DateTime::createFromFormat('d/m/Y', $_POST['data_ddt']);
	   $data_ddt = $dobvalue3->format('d/m/Y');
	   $dataappoggioscrittura = $dobvalue3->format('Y-m-d');	 
		 
       $numero_ddt = isset($_POST['numero_ddt']) ? sanitize_text_field($_POST['numero_ddt']) : '';
	   $idutente = isset($_POST['idutente']) ? sanitize_text_field($_POST['idutente']) : ''; 
		 
	   $mitt_nome = isset($_POST['mitt_nome']) ? stripslashes(sanitize_text_field($_POST['mitt_nome'])) : '';
       $mitt_ind_1 = isset($_POST['mitt_ind_1']) ? stripslashes(sanitize_text_field($_POST['mitt_ind_1'])) : '';
       $mitt_ind_2 = isset($_POST['mitt_ind_2']) ? stripslashes(sanitize_text_field($_POST['mitt_ind_2'])) : '';
       $mitt_cap = isset($_POST['mitt_cap']) ? sanitize_text_field($_POST['mitt_cap']) : '';
       $mitt_loc = isset($_POST['mitt_loc']) ? stripslashes(sanitize_text_field($_POST['mitt_loc'])) : '';
       $mitt_prov = isset($_POST['mitt_prov']) ? sanitize_text_field($_POST['mitt_prov']) : '';
       $mitt_ref = isset($_POST['mitt_ref']) ? stripslashes(sanitize_text_field($_POST['mitt_ref'])) : '';
       $mitt_ref_tel = isset($_POST['mitt_ref_tel']) ? sanitize_text_field($_POST['mitt_ref_tel']) : ''; 
		 
	   $dest_nome = isset($_POST['dest_nome']) ? stripslashes(sanitize_text_field($_POST['dest_nome'])) : '';
       $dest_ind_1 = isset($_POST['dest_ind_1']) ? stripslashes(sanitize_text_field($_POST['dest_ind_1'])) : '';
       $dest_ind_2 = isset($_POST['dest_ind_2']) ? stripslashes(sanitize_text_field($_POST['dest_ind_2'])) : '';
       $dest_cap = isset($_POST['dest_cap']) ? sanitize_text_field($_POST['dest_cap']) : '';
       $dest_loc = isset($_POST['dest_loc']) ? stripslashes(sanitize_text_field($_POST['dest_loc'])) : '';
       $dest_prov = isset($_POST['dest_prov']) ? sanitize_text_field($_POST['dest_prov']) : '';
       $dest_ref = isset($_POST['dest_ref']) ? stripslashes(sanitize_text_field($_POST['dest_ref'])) : '';
       $dest_ref_tel = isset($_POST['dest_ref_tel']) ? sanitize_text_field($_POST['dest_ref_tel']) : ''; 
       $dest_ref_email = isset($_POST['dest_ref_email']) ? $_POST['dest_ref_email'] : "";
		 
       $tipo_servizio = isset($_POST['tipo_servizio']) ? sanitize_text_field($_POST['tipo_servizio']) : '';
	
	   $n_colli = isset($_POST['colli']) ? stripslashes(sanitize_text_field($_POST['colli'])) : '';
	   $peso = isset($_POST['peso']) ? stripslashes(sanitize_text_field($_POST['peso'])) : '';
	   $volume = isset($_POST['volume']) ? stripslashes(sanitize_text_field($_POST['volume'])) : '';
	   $natura_merce = isset($_POST['natura']) ? stripslashes(sanitize_text_field($_POST['natura'])) : '';
	   $data_consegna_richiesta = isset($_POST['consegna_rich']) ? sanitize_text_field($_POST['consegna_rich']) : '';
	   $turno_chiusura = isset($_POST['chiusura']) ? sanitize_text_field($_POST['chiusura']) : '';
       $importo_contrassegno = isset($_POST['contrassegno']) ? sanitize_text_field($_POST['contrassegno']) : '';
       $mod_incasso = isset($_POST['incasso']) ? sanitize_text_field($_POST['incasso']) : '';
	   $valora_assicurare = isset($_POST['valore_ass']) ? sanitize_text_field($_POST['valore_ass']) : '';
		 
       $note_cli = isset($_POST['note_cli']) ? stripslashes(sanitize_text_field($_POST['note_cli'])) : '';	 
		 
	   $tracking_code = isset($_POST['tracking_number']) ? stripslashes(sanitize_text_field($_POST['tracking_number'])) : '';		
		
	   if($order_id == "libero"){
		  $order_id_scrittura = 0;
	   }else{
		  $order_id_scrittura = $order_id;
	   }
		 
		 
	   $wpdb->insert(waDdtBrt_TABLE_DDT_BRT, array('date' => $dataappoggioscrittura.' '.date("H:i:s"), 'n_ddt' => $numero_ddt, 'woocommerce_order' => $order_id_scrittura, 'user_id' => $idutente, 'dest_nome' =>$dest_nome, 'dest_ind_1' => $dest_ind_1, 'dest_ind_2' => $dest_ind_2, 'dest_cap' => $dest_cap, 'dest_loc' => $dest_loc, 'dest_prov' => $dest_prov, 'dest_ref' => $dest_ref, 'dest_ref_tel' => $dest_ref_tel, 'dest_ref_email' => $dest_ref_email, 'servizio' => $tipo_servizio, 'colli' => $n_colli, 'peso' => $peso, 'volume' => $volume, 'natura' => $natura_merce, 'consegna_rich' => $data_consegna_richiesta, 'chiusura' => $turno_chiusura, 'contrassegno' => $importo_contrassegno, 'mod_incasso' => $mod_incasso, 'val_assicurato' => $valora_assicurare, 'mittente_nome' =>$mitt_nome, 'mittente_ind' => $mitt_ind_1, 'mittente_ind2' => $mitt_ind_2, 'mittente_cap' => $mitt_cap, 'mittente_loc' => $mitt_loc, 'mittente_prov' => $mitt_prov, 'mittente_ref' => $mitt_ref, 'mittente_ref_tel' => $mitt_ref_tel, 'note' => $note_cli, 'tracking_code' => $tracking_code ));
		
	   $prossimoddt = $numero_ddt+1; 	 
	   waDdtBrt_checkuniformat_agg();
	   update_option('brt-dtt-next_number', $prossimoddt);

	   $nome_file_finale = $numero_ddt."-ddt-ordine-".$order_id.".pdf";

       // INIZIO IL PDF
       ob_get_clean();
       require_once( waDdtBrt_PLUGIN_PATH.'lib/tfpdf.php');
       $pdf = new tFPDF();
 	   $pdf->AddPage();
	   $pdf->Image(waDdtBrt_FILE_DDT_BASE, 0, 0, 210, 297);

	   $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf', true);
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

       $pdf->SetFont('Arial','',9);
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
	  
  }else{	
		  
  $data_ddt = date ("d/m/Y");
	  
  $sqlmitt = 'SELECT * FROM '.waDdtBrt_TABLE_DDT_BRT_MITT;
  
  $numero_ddt = get_option('brt-dtt-next_number');
  $idmittdef = get_option('brt-dtt-mitt_default');
  $tracking = get_option('brt-dtt-tracking_enable'); // tracking = 1 Abilitato | 0 Disabilitato
  $tracking_req = get_option('brt-dtt-tracking_required');
  $tracking_length = get_option('brt-dtt-tracking_length');
  
  $mittente = $wpdb->get_results($sqlmitt, ARRAY_A);

  $sqlmittdef = 'SELECT * FROM '.waDdtBrt_TABLE_DDT_BRT_MITT . ' WHERE id = ' . $idmittdef;
 	  
  $mittentedef = $wpdb->get_results($sqlmittdef, ARRAY_A);	
	  
  foreach($mittentedef as $mitt) {	
    $mitt_nome = (isset($mitt['mitt_nome']) ? stripslashes(sanitize_text_field($mitt['mitt_nome'])) : '');
    $mitt_ind_1 = (isset($mitt['mitt_ind']) ? stripslashes(sanitize_text_field($mitt['mitt_ind'])) : '');
    $mitt_ind_2 = (isset($mitt['mitt_ind_2']) ? stripslashes(sanitize_text_field($mitt['mitt_ind_2'])) : '');
    $mitt_cap = (isset($mitt['mitt_cap']) ? sanitize_text_field($mitt['mitt_cap']) : '');
    $mitt_loc = (isset($mitt['mitt_loc']) ? stripslashes(sanitize_text_field($mitt['mitt_loc'])) : '');
    $mitt_prov = (isset($mitt['mitt_prov']) ? sanitize_text_field($mitt['mitt_prov']) : '');
    $mitt_ref = (isset($mitt['mitt_ref']) ? stripslashes(sanitize_text_field($mitt['mitt_ref'])) : '');
    $mitt_ref_tel = (isset($mitt['mitt_ref_tel']) ? sanitize_text_field($mitt['mitt_ref_tel']) : '');
  }
	  
  if($order_id !== "libero"){
	  $order = wc_get_order( $order_id );
      $order_data = $order->get_data();	 
  
      $dest_nomeprovv = (isset($order_data['shipping']['first_name']) && $order_data['shipping']['first_name'] != "" ? ucfirst(strtolower($order_data['shipping']['first_name'])) : ucfirst(strtolower($order_data['billing']['first_name'])));
	  $dest_cognomeprovv = (isset($order_data['shipping']['last_name']) && $order_data['shipping']['last_name'] != "" ? ucfirst(strtolower($order_data['shipping']['last_name'])) : ucfirst(strtolower($order_data['billing']['last_name'])));
	  $dest_nome = $dest_nomeprovv. " ".$dest_cognomeprovv;
	  
      $dest_ind = (isset($order_data['shipping']['address_1']) && $order_data['shipping']['address_1'] != "" ? $order_data['shipping']['address_1'] : $order_data['billing']['address_1']);
      $dest_ind2 = (isset($order_data['shipping']['address_2']) && $order_data['shipping']['address_2'] != "" ? $order_data['shipping']['address_2'] : $order_data['billing']['address_2']);
      $dest_cap = (isset($order_data['shipping']['postcode']) && $order_data['shipping']['postcode'] != "" ? $order_data['shipping']['postcode'] : $order_data['billing']['postcode']);
      $dest_loc = (isset($order_data['shipping']['city']) && $order_data['shipping']['city'] != "" ? $order_data['shipping']['city'] : $order_data['billing']['city']);
      $dest_prov = (isset($order_data['shipping']['state']) && $order_data['shipping']['state'] != "" ? $order_data['shipping']['state'] : $order_data['billing']['state']);
      $dest_ref = $dest_nome;
      $dest_ref_tel = (isset($order_data['billing']['phone']) ? $order_data['billing']['phone'] : "");
      $dest_ref_email = (isset($order_data['billing']['email']) ? $order_data['billing']['email'] : "");
	
      $contrassegno = ($order_data['payment_method'] == "cod" ? $order_data['total'] : "");
      $incasso = ($order_data['payment_method'] == "cod" ? "Contanti" : "");
	  
	   $note_cli = $order->get_customer_note();
	  
   }
	  
   $porto ="Porto Franco";	    


  }
?>
 

<div class="options-wrap option-wrap-wabrt">
 <h1 style="text-transform: uppercase">Genera il "DOCUMENTO DI RITIRO" per il corriere BRT</h1> 
 <hr>
 <div class="ddt-generate-totale">
   <div class ="ddt-generate-sx">
	 <div class="cont-form-ddt-brt-vera">
	  <form action="<?php echo admin_url()."admin.php?page=waDdtBrt_brt-ddt&order_id=".$order_id; ?>" name="form_ddt" method="post">
      <h2 style="text-transform: uppercase; margin-top: 0px;">ORDINE <?php echo($order_id !== "libero" ? "#" : ""); echo $order_id; ?></h2>
	  <div class="cont-form-ddt-brt-vera-dati">
	  <h4>DATA E NUMERO DDT</h4>
	  <table width="100%" callpadding="5">
	   <tr>
		<td>
		  <label>Numero documento (*)</label><br />
	      <input type="number" name="numero_ddt" value="<?php echo $numero_ddt; ?>" min="<?php echo $numero_ddt; ?>" required />
		</td>
		<td>
		  <label>Data Documento (*)</label><br />
          <input class="wa-brt-datepicker" type="text" name="data_ddt" value="<?php echo $data_ddt ?>" required />
		</td>
	   </tr>
	  </table>
	  </div>  
		  
	  <div class="cont-form-ddt-brt-vera-mitt">
	  <h4>MITTENTE</h4>
	  <table width="100%" callpadding="5">	  
	   <tr>
		<td colspan="2"> 
		 <label>Mittente Nome (*)</label><br />
         <input type="text" name="mitt_nome" value="<?php echo $mitt_nome; ?>" required />
		</td>
	   </tr>
	   <tr>
		<td>
		  <label>Indirizzo (*)</label><br />
	      <input type="text" name="mitt_ind_1" value="<?php echo $mitt_ind_1; ?>" required />
		</td>
		<td>
		  <label>Indirizzo 2</label><br />
          <input type="text" name="mitt_ind_2" value="<?php echo $mitt_ind_2; ?>" />
		</td>
	   </tr>
	   <tr>
		<td>
		  <label>CAP (*)</label><br />
          <input type="text" name="mitt_cap" value="<?php echo $mitt_cap; ?>" required />
		</td>
		<td>
		  <label>Località (*)</label><br />
          <input type="text" name="mitt_loc" value="<?php echo $mitt_loc; ?>" required />
		</td>
	   </tr>
	   <tr>
	    <td colspan="2">
		  <label>Provincia (*)</label><br />
          <input type="text" name="mitt_prov" value="<?php echo $mitt_prov; ?>" required />
		</td>
	   </tr>
	   <tr>
		<td>
		 <label>Referente (Nome)</label><br />
         <input type="text" name="mitt_ref" value="<?php echo $mitt_ref; ?>" />
		</td>
		<td>
		 <label>Referente (Telefono)</label><br />
         <input type="text" name="mitt_ref_tel" value="<?php echo $mitt_ref_tel; ?>" />
		</td>
	   </tr>   
      </table>
	   </div>
	   <div class="cont-form-ddt-brt-vera-dest">
	  <h4>DESTINATARIO</h4>
	  <table width="100%" callpadding="5">
	   <tr>
		<td colspan="2"> 
		 <label>Destinatario Nome (*)</label><br />
         <input type="text" name="dest_nome" value="<?php echo $dest_nome; ?>" required />
		</td>
	   </tr>
	   <tr>
		<td>
		  <label>Indirizzo (*)</label><br />
	      <input type="text" name="dest_ind_1" value="<?php echo $dest_ind; ?>" required />
		</td>
		<td>
		  <label>Indirizzo 2</label><br />
          <input type="text" name="dest_ind_2" value="<?php echo $dest_ind2; ?>" />
		</td>
	   </tr>
	   <tr>
		<td>
		  <label>CAP (*)</label><br />
          <input type="text" name="dest_cap" value="<?php echo $dest_cap; ?>" required />
		</td>
		<td>
		  <label>Località (*)</label><br />
          <input type="text" name="dest_loc" value="<?php echo $dest_loc; ?>" required />
		</td>
	   </tr>
	   <tr>
	    <td colspan="2">
		  <label>Provincia (*)</label><br />
          <input type="text" name="dest_prov" value="<?php echo $dest_prov; ?>" required />
		</td>
	   </tr>
	   <tr>
		<td>
		 <label>Referente (Nome)</label><br />
         <input type="text" name="dest_ref" value="<?php echo $dest_ref; ?>" />
		</td>
		<td>
		 <label>Referente (Telefono)</label><br />
         <input type="text" name="dest_ref_tel" value="<?php echo $dest_ref_tel; ?>" />
		</td>
	   </tr>  
       <tr>
	    <td colspan="2">
		  <label>Referente (Email)</label><br />
          <input type="email" name="dest_ref_email" value="<?php echo $dest_ref_email; ?>" />
		</td>
	   </tr>
      </table>
	  </div>
	   <div class="cont-form-ddt-brt-vera-dett">
	  <h4>DETTAGLI ORDINE</h4>
	  <table width="100%" callpadding="5">
	   <tr>
		<td colspan="3"> 
		 <label>Tipo di Servizio (*)</label><br />
         <select name="tipo_servizio" required />
			<option value="P.TO FRANCO">P.TO FRANCO</option>
            <option value="P.TO ASSEGNATO">P.TO ASSEGNATO</option>
			<option value="SERVIZIO PRIORITY">SERVIZIO PRIORITY</option>
			<option value="SERVIZIO 10:30">SERVIZIO 10:30</option>
			<option value="FERMO DEPOSITO">FERMO DEPOSITO</option>
		 </select>
		</td>
	   </tr>
	   <tr>
		<td>
		  <label>Numero Colli (*)</label><br />
	      <input type="text" name="colli" value="" required />
		</td>
		<td>
		  <label>Peso Kg (*)</label><br />
          <input type="text" name="peso" value="" required/>
		</td>
		<td>
		  <label>Volume m3</label><br />
          <input type="text" name="volume" value=""  />
		</td>
       </tr>
	   <tr>
		<td>
		  <label>Natura Merce (*)</label><br />
          <input type="text" name="natura" value="" required/>
		</td>
	    <td>
		  <label>Data Consegna Ric.</label><br />
          <input class="wa-brt-datepicker" placeholder="gg/mm/aaaa" type="text" name="consegna_rich" value="" />
		</td>
		<td>
		  <label>Turno di Chiusura</label><br />
          <input type="text" name="chiusura" value="" />
		</td>
	   </tr>
	   <tr>
		<td>
		 <label>Importo Contrassegno &euro;</label><br />
         <input type="text" name="contrassegno" value="<?php echo $contrassegno; ?>" />
		</td>
		<td>
		 <label>Modalità Incasso</label><br />
         <select name="incasso" />
			<option value="">---</option>
			<option value="Contanti" <?php if($contrassegno != ""){ echo "selected";} ?> >Contanti</option>
            <option value="Assegno">Assegno</option>
			<option value="Pos/Carta Credito">Pos/Carta Credito</option>
		  </select>
		</td>
	    <td>
		  <label>Valore da Assicurare &euro;</label><br />
          <input type="text" name="valore_ass" value="" />
	   </td>
	   </tr>
	   <tr>
	    <td colspan="3">
		  <label>Note del Cliente</label><br />
          <textarea name="note_cli" style="resize:none" /><?php echo $note_cli; ?></textarea>
	   </td>
	   </tr>
      </table>
	  <hr>
	  <p>  
       <input type="hidden" name="order" value="<?php echo $order_data['id']; ?>" />
	   <input type="hidden" name="idutente" value="<?php echo $order_data['customer_id']; ?>" />
       <?php echo(waDdtBrt_checkuniformat() ? waDdtBrt_GENPR.' '.waDdtBrt_CLASSBUTTONBLU.'" '.waDdtBrt_GENSEC.waDdtBrt_GENTER : waDdtBrt_GENPR.' '.waDdtBrt_CLASSBUTTONBLU.'" '.waDdtBrt_GENSEC.' '.waDdtBrt_BASID.waDdtBrt_NOTCONG); ?>
	  </p>
	  </form>
      </div>
      </div>
   </div>
   <div class ="ddt-generate-dx">
	 <div id="lightbox-ddt-brt">
     <div class="content-lightbox-ddt-brt">
      <img src="<?php echo waDdtBrt_IMG_DDT_BASE ?>"/>
      <div class="cont-form-ddt-brt cont-form-ddt-brt-fake">
       
	   <div class="n-ddt"><?php echo $numero_ddt; ?></div>
	   <div class="data-ddt"><?php echo $data_ddt; ?></div>
		  
       <div class="mitt-nome"><?php echo $mitt_nome; ?></div>
       <div class="mitt-ind-1"><?php echo $mitt_ind_1; ?></div>
       <div class="mitt-ind-2"><?php echo $mitt_ind_2; ?></div>
       <div class="mitt-cap"><?php echo $mitt_cap; ?></div>
       <div class="mitt-loc"><?php echo $mitt_loc; ?></div>
       <div class="mitt-prov"><?php echo $mitt_prov; ?></div>
       <div class="mitt-ref"><?php echo $mitt_ref; ?></div>
       <div class="mitt-ref-tel"><?php echo $mitt_ref_tel; ?></div>
        
       <div class="dest-nome"><?php echo $dest_nome; ?></div>
       <div class="dest-ind-1"><?php echo $dest_ind; ?></div>
       <div class="dest-ind-2"><?php echo $dest_ind2; ?></div>
       <div class="dest-cap"><?php echo $dest_cap; ?></div>
       <div class="dest-loc"><?php echo $dest_loc; ?></div>
       <div class="dest-prov"><?php echo $dest_prov; ?></div>
       <div class="dest-ref"><?php echo $dest_ref; ?></div>
       <div class="dest-ref-tel"><?php echo $dest_ref_tel; ?></div>
       <div class="dest-ref-email"><?php echo $dest_ref_email; ?></div>
       
	   <div class="tipo-servizio servizio-pf">X</div>	  
	   <div class="tipo-servizio servizio-pa">X</div>
	   <div class="tipo-servizio servizio-prio">X</div>
	   <div class="tipo-servizio servizio-1030">X</div>
	   <div class="tipo-servizio servizio-fdep">X</div>
		  
       <div class="colli"></div>
       <div class="peso"></div>
       <div class="volume"></div>
       <div class="natura"></div>
       <div class="consegna-rich"></div>
       <div class="chiusura"></div>
       <div class="contrassegno"><?php echo $contrassegno; ?></div>
       <div class="incasso"><?php echo $incasso; ?></div>
       <div class="valore-ass"></div>
        
       <div  class="note-cli"><?php echo $note_cli; ?></div>
          
      </div>
     </div>
    </div>
   </div>
  </div>
</div>	
	
<?php
 }
?>