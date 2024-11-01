/* ------- Copyright 2020 Web Alch LAB ------------------*/

 jQuery(document).ready(function($) {

	$('input[name="numero_ddt"]').on('change', function() {
      $('.cont-form-ddt-brt-fake .n-ddt').html($(this).val());
    }); 
	$('input[name="numero_ddt"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .n-ddt').html($(this).val());
	});   
	$('input[name="data_ddt"]').on('change', function() {
		var backway = $(this).val().split("-").reverse().join("/");
		$('.cont-form-ddt-brt-fake .data-ddt').html(backway);
	});   
	 
	$( function() {
      $( ".wa-brt-datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
    } ); 
	 
	$('input[name="mitt_nome"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-nome').html($(this).val());
	});
	$('input[name="mitt_ind_1"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-ind-1').html($(this).val());
	});
	$('input[name="mitt_ind_2"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-ind-2').html($(this).val());
	});
	$('input[name="mitt_cap"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-cap').html($(this).val());
	});
	$('input[name="mitt_loc"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-loc').html($(this).val());
	});
	$('input[name="mitt_prov"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-prov').html($(this).val());
	});
	$('input[name="mitt_ref"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-ref').html($(this).val());
	}); 
	$('input[name="mitt_ref_tel"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .mitt-ref-tel').html($(this).val());
	});	 
	$('input[name="dest_nome"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-nome').html($(this).val());
	});
	$('input[name="dest_ind_1"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-ind-1').html($(this).val());
	});
	$('input[name="dest_ind_2"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-ind-2').html($(this).val());
	});
	$('input[name="dest_cap"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-cap').html($(this).val());
	});
	$('input[name="dest_loc"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-loc').html($(this).val());
	});
	$('input[name="dest_prov"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-prov').html($(this).val());
	});
	$('input[name="dest_ref"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-ref').html($(this).val());
	});
	$('input[name="dest_ref_tel"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-ref-tel').html($(this).val());
	});
	$('input[name="dest_ref_email"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .dest-ref-email').html($(this).val());
	});  
    $('input[name="colli"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .colli').html($(this).val());
	});
	$('input[name="peso"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .peso').html($(this).val());
	});
	$('input[name="volume"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .volume').html($(this).val());
	});
	$('input[name="natura"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .natura').html($(this).val());
	}); 	 
	$('input[name="consegna_rich"]').on('change', function() {
		var backway = $(this).val().split("-").reverse().join("/");
		$('.cont-form-ddt-brt-fake .consegna-rich').html(backway);
	}); 
	$('input[name="chiusura"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .chiusura').html($(this).val());
	});
	$('input[name="contrassegno"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .contrassegno').html($(this).val());
	});
	$('select[name="incasso"]').on('change', function() {
      $('.cont-form-ddt-brt-fake .incasso').html($(this).val());
    });
	$('input[name="valore_ass"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .valore-ass').html($(this).val());
	}); 
	$('textarea[name="note_cli"]').keyup(function() {	
		$('.cont-form-ddt-brt-fake .note-cli').html($(this).val());
	}); 
	 
	$('select[name="tipo_servizio"]').on('change', function() {
		if ($(this).val() == "P.TO FRANCO") {
		  $(".servizio-pa, .servizio-prio, .servizio-1030, .servizio-fdep").css("display", "none");
		  $(".servizio-pf").css("display", "block");
		}
		
		if ($(this).val() == "P.TO ASSEGNATO") {
		  $(".servizio-pf, .servizio-prio, .servizio-1030, .servizio-fdep").css("display", "none");
		  $(".servizio-pa").css("display", "block");
		}
		
		if ($(this).val() == "SERVIZIO PRIORITY") {
		  $(".servizio-pf, .servizio-pa, .servizio-1030, .servizio-fdep").css("display", "none");
		  $(".servizio-prio").css("display", "block");
		}
		
		if ($(this).val() == "SERVIZIO 10:30") {
		  $(".servizio-pf, .servizio-prio, .servizio-pa, .servizio-fdep").css("display", "none");
		  $(".servizio-1030").css("display", "block");
		}
		
		if ($(this).val() == "FERMO DEPOSITO") {
		  $(".servizio-pf, .servizio-prio, .servizio-1030, .servizio-pa").css("display", "none");
		  $(".servizio-fdep").css("display", "block");
		}
		
	}); 

  
 });
 
