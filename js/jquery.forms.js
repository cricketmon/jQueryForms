/* 
//  cricket ( )
//  creado bajo el techo de __digitalperforming__ el 2014-01-16
//  actualizado el xxxx-xx-xx
//  ene punto ramirez arroba digital punto o ere ge punto eme equis
//  habiendo dicho eso, bienvenido a al codigo
*/ 



function showPrompt(field, alert, refer) {
	var prompt = $('<div>'); 
	var field = $(refer + ' .' + field);
	
	focus = function(){ field.focus(); }; 
	$(refer + ' form').append(prompt); 
	prompt.addClass('alerts');
	
	var promptContent = $('<div>').addClass("alertsContent").html(alert).appendTo(prompt);
	var arrow = $('<div>').addClass("alertsArrow");
	
	prompt.find(".alertsContent").after(arrow);
	
	var pos = field.position();
	var alerts = $('.alerts');
	
	prompt.css({ 'top': pos.top - alerts.height(), 'left': pos.left + field.width() - alerts.width() + 40, 'overflow': 'hidden' }); 
	
	$('html,body').animate({ scrollTop : $('.alerts').offset().top - 10 }, 'slow',focus );
	
	return prompt.animate({ 'opacity': 0.87 });
}

function process (lang,refer) { 
	var sending = (lang == 'en') ? 'Sending':'Enviando';
	var sending_error = (lang == 'en') ? '<span class="color_3">*</span> Failed to send your request. Please try again.':'<span class="color_3">*</span> Ha ocurrido un error al enviar su solicitud. Por favor intente de nuevo.'; 
	var dataForm = $(refer + ' form').serialize(); 
	var successID = refer + ' .success';
	
	$(successID).hide(); 
	$(successID).html('<span class="color_3">*</span> ' + sending).fadeIn(); 
	
	$.ajaxSetup ({ cache: false });
	var dataString =  dataForm + '&hungry=1';

	$.ajax({
		type: "POST",
		url: "lib/MailHandler.php", 
		data: dataString, dataType: "json", 
		success: function(msg) { 
			switch(msg.refer){ 
				case '1':
				$('html,body').animate({ scrollTop : $(successID).offset().top - 10 },'slow');
				$(successID).html(msg.alert).fadeIn(1000); 
				$(refer + " form").slideUp(400, function(){ $(this).remove(); }); 
				break; 

				case '0':
				$(successID).hide(); 
				showPrompt(msg.field, msg.alert, refer); 
				break; 

				case 'die': 
				$('html,body').animate({ scrollTop : $(successID).offset().top - 10 },'slow'); 
				$(successID).html(msg.alert).fadeIn(1000);
				break;
			}
		}, 
		error: function(ob,errStr) { 
			$('html,body').animate({ scrollTop : $(successID).offset().top - 10 },'slow'); 
			$(successID).html(sending_error);
		}
	});
}
	
$(document).ready(function(){
	$('#contactForm .submit, #newslettersForm .submit').click(function(e){
		e.preventDefault();

		var refer = '#' + $(this).closest('div').attr('id');
		var lang = $('.lang').val();

		$(".alerts").remove();
		
		process(lang,refer);
	});

	$('.alerts').live("click", function() {
		$(this).fadeOut(150, function(){ $(this).remove(); });
	});
});