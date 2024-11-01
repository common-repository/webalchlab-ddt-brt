<?php
/** */


/* Prevenzione da maleintenzionati */
defined('ABSPATH') OR exit;


function waDdtBrt_mittenti_ddt_function() {
  if (!current_user_can('manage_options')) {
      return;
  }
	
  global $wpdb;

  // ----------  ELIMINA MITTENTE ----------------  
  if(isset($_POST['mitt_id_elimina']) && $_POST['mitt_id_elimina'] != '' ) {	
		 if($wpdb->delete(waDdtBrt_TABLE_DDT_BRT_MITT, array('id' => $_POST['mitt_id_elimina'])) > 0 ) {
			echo '<div class="disclamer-no-wa-brt">Mittente Eliminato</div>';
			if(get_option('brt-dtt-mitt_default') == $_POST['mitt_id_elimina']) {
				update_option('brt-dtt-mitt_default', 0);
				echo '<div class="disclamer-no-wa-brt">Nessun Mittente di Default Impostato</div>';
			}
		 }
	 }
  
  if(isset($_POST['submit'])) {
	  
	 // ----------  INSERIMENTO NUOVO MITTENTE ---------------- 
	
	 if(isset($_POST['nuovo_mitt_hidden']) == 1) {		 
	  
	  $mitt_nome = (isset($_POST['mitt_nome_n']) ? sanitize_text_field($_POST['mitt_nome_n']) : '');
	  $mitt_ind_1 = (isset($_POST['mitt_ind_1_n']) ? sanitize_text_field($_POST['mitt_ind_1_n']) : '');
	  $mitt_ind_2 = (isset($_POST['mitt_ind_2_n']) ? sanitize_text_field($_POST['mitt_ind_2_n']) : '');
	  $mitt_cap = (isset($_POST['mitt_cap_n']) ? sanitize_text_field($_POST['mitt_cap_n']) : '');
	  $mitt_loc = (isset($_POST['mitt_loc_n']) ? sanitize_text_field($_POST['mitt_loc_n']) : '');
	  $mitt_prov = (isset($_POST['mitt_prov_n']) ? sanitize_text_field($_POST['mitt_prov_n']) : '');
	  $mitt_ref = (isset($_POST['mitt_ref_n']) ? sanitize_text_field($_POST['mitt_ref_n']) : '');;
	  $mitt_ref_tel = (isset($_POST['mitt_ref_tel_n']) ? sanitize_text_field($_POST['mitt_ref_tel_n']) : '');
	 
		 	  
	  $wpdb->insert(waDdtBrt_TABLE_DDT_BRT_MITT, array('mitt_nome' =>$mitt_nome, 'mitt_ind' => $mitt_ind_1, 'mitt_ind_2' => $mitt_ind_2, 'mitt_cap' => $mitt_cap, 'mitt_loc' => $mitt_loc, 'mitt_prov' => $mitt_prov, 'mitt_ref' => $mitt_ref, 'mitt_ref_tel' => $mitt_ref_tel, 'date' => date("Y-m-d H:i:s"))); 
		
	  $ultimoidmitt = $wpdb->insert_id;
 
	  if(isset($_POST['mitt_def_n'])){
		  update_option('brt-dtt-mitt_default', $ultimoidmitt);
	  }	 
		 
         echo '<div class="disclamer-ok-wa-brt">Mittente salvato</div>';
	 }
	  
	  
	 // ----------  MODIFICA MITTENTE ----------------  
	  
	 if(isset($_POST['modifica_mitt_hidden']) == 1) {	
	  $mitt_id = (isset($_POST['id_modifica_mitt_hidden']) ? sanitize_text_field($_POST['id_modifica_mitt_hidden']) : '');	 
	  $mitt_nome = (isset($_POST['mitt_nome']) ? sanitize_text_field($_POST['mitt_nome']) : '');
	  $mitt_ind_1 = (isset($_POST['mitt_ind_1']) ? sanitize_text_field($_POST['mitt_ind_1']) : '');
	  $mitt_ind_2 = (isset($_POST['mitt_ind_2']) ? sanitize_text_field($_POST['mitt_ind_2']) : '');
	  $mitt_cap = (isset($_POST['mitt_cap']) ? sanitize_text_field($_POST['mitt_cap']) : '');
	  $mitt_loc = (isset($_POST['mitt_loc']) ? sanitize_text_field($_POST['mitt_loc']) : '');
	  $mitt_prov = (isset($_POST['mitt_prov']) ? sanitize_text_field($_POST['mitt_prov']) : '');
	  $mitt_ref = (isset($_POST['mitt_ref']) ? sanitize_text_field($_POST['mitt_ref']) : '');;
	  $mitt_ref_tel = (isset($_POST['mitt_ref_tel']) ? sanitize_text_field($_POST['mitt_ref_tel']) : '');

		 	  
	  $wpdb->update(waDdtBrt_TABLE_DDT_BRT_MITT, array('mitt_nome' =>$mitt_nome, 'mitt_ind' => $mitt_ind_1, 'mitt_ind_2' => $mitt_ind_2, 'mitt_cap' => $mitt_cap, 'mitt_loc' => $mitt_loc, 'mitt_prov' => $mitt_prov, 'mitt_ref' => $mitt_ref, 'mitt_ref_tel' => $mitt_ref_tel, 'date' => date("Y-m-d H:i:s")),  array('id'=>$mitt_id)); 
		 
	 
	  if(isset($_POST['mitt_def'])){
		  update_option('brt-dtt-mitt_default', $mitt_id);
	  }
	  
     
         echo '<div class="disclamer-ok-wa-brt">Mittente aggiornato</div>';
	 }
	  
  }

  ?>
  <div class="options-wrap option-wrap-wabrt">
	  
    <h1>GESTIONE MITTENTI</h1>
	<p>In questa sezione hai la possibilità di salvare il mittente per la generazione dei DDT:</p>
     
	<?php if(waDdtBrt_checkuniformat_unicode()){ ?> 
	             
    <div class="tabella-mittente-nuovo">
     <form id="nuovo-mittente" action="<?php echo admin_url()."admin.php?page=waDdtBrt_brt-ddt-mittenti"; ?>" name="nuovo_mittente" method="post">
     <table class="table-nuovo-mittente" cellpadding="5">
      <tr class="table-nuovo-mittente-riga">	
       <td colspan="2"><label>NOME/RAGIONE SOCIALE</label><br /><input type="text" name="mitt_nome_n" value="" required /></td>
	  </tr>	 
	  <tr class="table-nuovo-mittente-riga">
       <td><label>INDIRIZZO 1</label><br /><input type="text" name="mitt_ind_1_n" value="" required /></td>
       <td><label>INDIRIZZO 2</label><br /><input type="text" name="mitt_ind_2_n" value="" /></td>
	  </tr>
	  <tr class="table-nuovo-mittente-riga">  
		<td colspan="2"><label>LOCALITA'</label><br /><input type="text" name="mitt_loc_n" value="" required /></td> 
      </tr>  
	  <tr class="table-nuovo-mittente-riga"> 
       <td><label>CAP</label><br /><input type="text" name="mitt_cap_n" value="" required /></td>
       <td><label>PROVINCIA</label><br /><input type="text" name="mitt_prov_n" value="" required /></td>
	  </tr>
	  <tr class="table-nuovo-mittente-riga"> 
       <td><label>REFERENTE</label><br /><input type="text" name="mitt_ref_n" value="" required /></td>
       <td><label>TELEFONO</label><br /><input type="text" name="mitt_ref_tel_n" value="" required /></td>
	  </tr>
	  <tr class="table-nuovo-mittente-riga" style="display: none"> 
	   <td colspan="2"><input type="checkbox" name="mitt_def_n" value="predefinito" style="margin-top: -3px" checked/> PREDEFINITO</td>
	  </tr>
      <tr class="table-nuovo-mittente-riga"> 
	   <td colspan="2"><input type="hidden" name="nuovo_mitt_hidden" value="1" /><input class="bottone-verde-wabrt" type="submit" name="submit" value="Salva" /></td>
	  </tr>
     </table>
	 </form>
    </div> 
   
    <?php } ?>
  
	<div class="contenitore-mittenti-brt">
	<?php
	    $predefinitonumero = get_option('brt-dtt-mitt_default');    
	
	     
	    $sqlmitt = 'SELECT * FROM '.waDdtBrt_TABLE_DDT_BRT_MITT;
        $mittenti = $wpdb->get_results($sqlmitt, ARRAY_A);

        foreach($mittenti as $mittente) {
			
     ?>   
	  
     <div class="tabella-mittente-lista">
      <form action="<?php echo admin_url()."admin.php?page=waDdtBrt_brt-ddt-mittenti"; ?>" name="lista_mittenti_ddt_<?php echo $mittente['id']; ?>" method="post">
      <table class="table-lista-mittente" cellpadding="5">
       <tr class="table-lista-mittente-riga">	
        <td colspan="2"><label>NOME/RAGIONE SOCIALE</label><br /><input type="text" name="mitt_nome" value="<?php echo stripslashes($mittente['mitt_nome']) ?>" required /></td>
	   </tr>	 
	   <tr class="table-lista-mittente-riga">
        <td><label>INDIRIZZO 1</label><br /><input type="text" name="mitt_ind_1" value="<?php echo stripslashes($mittente['mitt_ind']) ?>" required /></td>
        <td><label>INDIRIZZO 2</label><br /><input type="text" name="mitt_ind_2" value="<?php echo stripslashes($mittente['mitt_ind_2']) ?>" /></td>
	   </tr>
	   <tr class="table-lista-mittente-riga">  
	 	<td colspan="2"><label>LOCALITA'</label><br /><input type="text" name="mitt_loc" value="<?php echo stripslashes($mittente['mitt_loc']) ?>" required /></td> 
       </tr>  
	   <tr class="table-lista-mittente-riga"> 
        <td><label>CAP</label><br /><input type="text" name="mitt_cap" value="<?php echo $mittente['mitt_cap'] ?>" required /></td>
        <td><label>PROVINCIA</label><br /><input type="text" name="mitt_prov" value="<?php echo $mittente['mitt_prov'] ?>" required /></td>
	   </tr>
	   <tr class="table-lista-mittente-riga"> 
        <td><label>REFERENTE</label><br /><input type="text" name="mitt_ref" value="<?php echo stripslashes($mittente['mitt_ref']) ?>" required /></td>
        <td><label>TELEFONO</label><br /><input type="text" name="mitt_ref_tel" value="<?php echo $mittente['mitt_ref_tel']; ?>" required /></td>
	   </tr>
	   <tr class="table-lista-mittente-riga" style="display: none"> 
	    <td colspan="2"><input type="checkbox" style="margin-top: -3px" name="mitt_def" value="predefinito" <?php echo ($mittente['id'] == $predefinitonumero ? "checked" : ""); ?> /> PREDEFINITO</td>
	   </tr>
       <tr class="table-lista-mittente-riga"> 
	    <td colspan="2">
		  <input type="hidden" name="id_modifica_mitt_hidden" value="<?php echo $mittente['id'] ?>" />
		  <input type="hidden" name="modifica_mitt_hidden" value="1" />
		  <input class="bottone-verde-wabrt" type="submit" name="submit" value="Salva Modifica" />
		</td>
	   </tr>
      </table>
	  </form>
	  <form action="<?php echo admin_url()."admin.php?page=waDdtBrt_brt-ddt-mittenti"; ?>" name="elimina_mittente" method="post" style="display:none;">
			<input type="submit" name="invia_elimina" value="Elimina" />
	  </form>
     </div> 
	    
	<?php  }  ?>  
	  
	</div>  

  </div>
 <?php
}

