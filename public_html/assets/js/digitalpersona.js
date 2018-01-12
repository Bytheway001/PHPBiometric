function Mask(){
	this.show=function(text){
		$('.verifying').attr("src", "/assets/img/finger.gif");
		$('.verifying').css('display','initial');
		$('.mask').fadeIn('slow');
		$('.mask').css('display','flex');
		$('.process_status').text(text);
	}

	this.fade=function(src,txt){

		if(src=='success'){img='success.png'}
		if(src=='failure'){img='failure.png';}
		$('.verifying').fadeOut('fast',function(){
			$('.process_status').text(txt);
			$(this).attr("src", "/assets/img/"+img);
			$(this).fadeIn();
		});
	}

	this.hide=function(){
		$('.verifying').css('display','none');
		$('.verifying').attr('src','');
		$('.process_status').text('');
		$('.mask').fadeOut();
	}
}

function verification_start(){
	a=1;
	mask=new Mask()
	mask.show('Verificando...(0 %)');
	contador=setInterval(function(){
		if(a<10){
			$.get('/employees/could_log',function(data){
				if(data==true){
					clearInterval(contador)
					mask.fade('success','Verificacion Exitosa');
				}
				else{
					a++;
					$('.process_status').text('Verificando...('+a+'0 %)');
				}
			})
		}
		else{
			clearInterval(contador)
			mask.fade('failure','Verificación Fallida');
			setTimeout(function () {mask.hide()}, 2000)
			a=1;
			console.log(a)
		}
	},2000)
}
function user_delete(user_id, user_name) {
	var r = confirm("Delete user "+user_name+" ?");
	if (r == true) {
		push('user.php?action=delete&user_id='+user_id);
	}
}

function user_register(user_id, user_name) {
	regStats = 0; // Si hay una huella registrada
	regCt = -1; // Plantilla actual
	var limit = 4; // Maximo numero de intentos
	var ct = 1; // Numero de intento actual
	var timeout = 7000;
	$('body').ajaxMask();
	mask = new Mask();
	mask.show('Registrando huella... 1/4');
	try{
		timer_register.stop();
	}
	catch(err){
	}

	timer_register = $.timer(timeout, function() {					
		user_checkregister(user_id,$("#user_finger_"+user_id).html());
		$('.process_status').text('Registrando huella... '+ct+'/4');
		if (ct>=limit || regStats==1){
			timer_register.stop();
			if (ct>=limit && regStats==0){
				mask.fade('failure','Registro Fallido');
				setTimeout(function () {mask.hide()}, 2000)
				$('body').ajaxMask({ stop: true });
			}						
			if (regStats==1){
				$("#user_finger_"+user_id).html(regCt);
				mask.fade('success','Registro Exitoso');
				setTimeout(function () {mask.hide()}, 2000)
				$('body').ajaxMask({ stop: true });
				location.reload()
			}
		}
		ct++;
	});
}

function user_checkregister(user_id, current) {

	$.post("/check_registration/"+user_id,{current:current},function(response){
		try{
			if (response.result){
				regStats = 1;
				$.each(res, function(key, value){
					if (key=='current'){
						regCt = value;
					}
				});
			}
		}
		catch(err){
			console.log(err.message);
		}
	},'JSON')
}

// ajaxmask.js
(function($) {
	$.fn.ajaxMask = function(options) {

		return this.each(function() {
			var settings = $.extend({
				stop: false,
			}, options);

			if (!settings.stop) {
				var loadingDiv = $('<div class="ajax-mask"><div class="loading"><img src="/assets/img/loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + 'Please wait...' + '</span></div></div>')
				.css({
					'position': 'absolute',
					'top': 170,
					'left':80,
					'width':'100%',
					'height':'100%',
				});

				$(this).css({ 'position':'relative' }).append(loadingDiv);
			} else {
				$('.ajax-mask').remove();
			}
		});

	}
})(jQuery);

// jquery.timer.js
(function($) {
	jQuery.timer = function(interval, callback, options) {
		// Create options for the default reset value
		var options = jQuery.extend({ reset: 500 }, options);
		var interval = interval || options.reset;

		if(!callback) { return false; }

		var Timer = function(interval, callback, disabled) {
			// Only used by internal code to call the callback
			this.internalCallback = function() { callback(self); };

			// Clears any timers
			this.stop = function() { clearInterval(self.id); };
			// Resets timers to a new time
			this.reset = function(time) {
				if(self.id) { clearInterval(self.id); }
				var time = time || options.reset;

				this.id = setInterval(this.internalCallback, time);
			};

			// Set the interval time again
			this.interval = interval;
			
			// Set the timer, if enabled
			if (!disabled) {
				this.id = setInterval(this.internalCallback, this.interval);
			}

			var self = this;
		};

		// Create a new timer object
		return new Timer(interval, callback, options.disabled);
	};
})(jQuery);

// custom.js
function push(page) {

	$.ajax({
		beforeSend	: function() {
			$('.help-blok').remove();
		},
		type		: 'GET',
		url		: page,
		success	: function(data) {
			try {

				console.log('Data has been pushed..');

				var res = jQuery.parseJSON(data);

				if (res.result) {

					$.each(res, function(key, value) {

						if (key == 'reload') {

							load(value);

							alert('Data saved..');

						}

					});

				} else if (res.result == false) {

					$.each(res, function(key, value) {

						if (key != 'result' && key != 'server' && key != 'notif' ) {

							$('#'+key).after("<span class='help-blok'>"+value+"</span>")

						} else if (key == 'server') {

							alert(value);

						}
					});

				}

			} catch (err) {

				alert(err.message);

			}
		}
	});

}

function load(page) {
	$.ajax({
		type		: 'GET',
		url		: page,
		success	: function(data) {
			try {
				$('#content').html(data);
			} catch (err) {
				alert(err);
			}
		}
	});
}