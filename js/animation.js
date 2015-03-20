function pulseElement(selector) {
	$(selector).dequeue().transition({scale: 1.1}, 25).transition({scale: 1}, 25);
}
function rubberElement(selector) {
	$(selector).dequeue().transition({scale: [1.25, 0.75]}, 30).transition({scale: [0.75, 1.25]}, 10).transition({scale: [1.15, 0.85]}, 20).transition({scale: [1, 1]}, 40);
}
function shakeElement(selector) {
	$(selector).dequeue().transition({x: '-5px'}, 5).transition({x: '5px'}, 10).transition({x: '-5px'}, 10).transition({x: '5px'}, 10).transition({x: '-5px'}, 10).transition({x: '5px'}, 10).transition({x: '-5px'}, 10).transition({x: '5px'}, 10).transition({x: '-5px'}, 10).transition({x: '0px'}, 5);
}
function wobbleElement(selector) {
	$(selector).dequeue().transition({x: '-25%', rotate: '-5deg'}, 15).transition({x: '20%', rotate: '3deg'}, 15).transition({x: '-15%', rotate: '-3deg'}, 15).transition({x: '10%', rotate: '2deg'}, 15).transition({x: '-5%', rotate: '-1deg'}, 15).transition({x: '0%', rotate: '0deg'}, 25);
}
function alertField(fieldName) {
	$('#'+fieldName+'_form').submit(function() {
		return false;
	});
	$('#'+fieldName+'_submit').removeClass('green').addClass('red');
	$('#'+fieldName+'_form_status').removeClass('restore_'+fieldName).addClass('alert_'+fieldName);
	$('#'+fieldName).focus();
}
function restoreField(fieldName) {
	$('#'+fieldName+'_form').unbind('submit');
	$('#'+fieldName+'_submit').removeClass('red').addClass('green');
	$('#'+fieldName+'_form_status').removeClass('alert_'+fieldName).addClass('restore_'+fieldName);
	$('#'+fieldName).focus();
}
function alertSearchField() {
	alertField('search');
}
function restoreSearchField() {
	restoreField('search');
}
function validateSearch(isSubmitted) {
	if (!isEmpty('#search')) {
		if (isSubmitted === true) {
			$('#search_form').submit();
		} else if (isSubmitted === false) {
			restoreSearchField();
		}
	} else if (isEmpty('#search')) {
		alertSearchField();
		if (isSubmitted === true) {
			shakeElement('#search');
		}
	}
}
function alertDobField() {
	alertField('dob');
	$('#dob').datepicker('show');
}
function restoreDobField() {
	restoreField('dob');
	$('#dob').datepicker('hide');
}
function alertErase() {
	shakeElement('#dob_erase');
}
function alertFullname() {
	shakeElement('#fullname');
}
function enableFields(isErased) {
	$('#dob, #fullname').removeAttr('disabled').removeAttr('readonly');
	if (isErased === true) {
		$('#dob, #fullname').val('');
	}
}
function maskDob() {
	$('#dob').on('keypress', function(e) {
		if (e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40 && e.keyCode != 46 && countChar($('#dob').val(), '-') < 2) {
			maskInput($('#dob').val(),$('#dob'),'4,7','-');
		}
	}).on('keyup', function(e) {
		if (e.which != 8 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 46 && countChar($('#dob').val(), '-') < 2) {
			maskInput($('#dob').val(),$('#dob'),'4,7','-');
		}
	}).on('keydown', function(e) {
		if (e.which != 8 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 46 && countChar($('#dob').val(), '-') < 2) {
			maskInput($('#dob').val(),$('#dob'),'4,7','-');
		}
	});
}
function helpDobForm() {
	if ($('#dob').prop('disabled') === true) {
		$('span#dob_form_status').addClass('disabled_dob');
	} else if ($('#dob').prop('disabled') === false) {
		$('span#dob_form_status').removeClass('disabled_dob');
	}
	if ($('#dob').val() == $('#dob').datepicker('option','defaultDate')) {
		$('#dob_form_status').addClass('default_dob');
	} else if ($('#dob').val() != $('#dob').datepicker('option','defaultDate')) {
		$('#dob_form_status').removeClass('default_dob');
	}
	if ($('#dob_bar').has('#fullname').length) {
		$('span#dob_form_status').addClass('has_fullname').removeClass('no_fullname');
	} else if (!$('#dob_bar').has('#fullname').length) {
		$('span#dob_form_status').removeClass('has_fullname').addClass('no_fullname');
	}
	if (isEmpty('#dob')) {
		$('span#dob_form_status').addClass('empty_dob').removeClass('correct_dob').removeClass('checked_default_dob');
	} else if (!isEmpty('#dob')) {
		$('span#dob_form_status').removeClass('empty_dob');
		if (isDate($('#dob').val())) {
			$('span#dob_form_status').removeClass('wrong_dob').addClass('correct_dob');
			if (($('#dob_bar').has('#name_toggle').length || $('#fullname').prop('disabled') === false) && isEmpty('#fullname')) {
				$('span#dob_form_status').addClass('empty_fullname').removeClass('filled_fullname');
			} else {
				$('span#dob_form_status').removeClass('empty_fullname').addClass('filled_fullname');
			}
		} else if (!isDate($('#dob').val())) {
			$('span#dob_form_status').addClass('wrong_dob').removeClass('correct_dob').removeClass('checked_default_dob');
		}
	}
	$('#dob_form').on({
		focusin: function(){
			$('span#dob_form_status').addClass('focus_dob');
		},
		focusout: function(){
			$('span#dob_form_status').removeClass('focus_dob');
		}
	}, '#dob').on({
		focusin: function(){
			$('span#dob_form_status').addClass('focus_fullname');
		},
		focusout: function(){
			$('span#dob_form_status').removeClass('focus_fullname');
		}
	}, '#fullname');
}
function submitDob() {
	$.cookie('NSH:fullname',$('#fullname').val());
	$.cookie('NSH:dob',$('#dob').val());
	$('#dob_form').submit();
}
function validateDob(isSubmitted) {
	if (!isEmpty('#dob')) {
		if (isDate($('#dob').val())) {
			if (isSubmitted === true) {
				if (($('#dob_bar').has('#name_toggle').length || $('#fullname').prop('disabled') === false) && $('#dob').prop('disabled') === false) {
					if ($('#fullname').prop('disabled') === false && isEmpty('#fullname')) {
						alertFullname();
					} else if ($('span#dob_form_status').hasClass('default_dob') && !$('span#dob_form_status').hasClass('checked_default_dob')) {
						$('span#dob_form_status').addClass('checked_default_dob');
					} else {
						if (!$('span#dob_form_status').hasClass('default_dob') || ($('span#dob_form_status').hasClass('default_dob') && $('span#dob_form_status').hasClass('checked_default_dob'))) {
							$('#dob').val(function(i, val) {
								return convertDate(val);
							});
							submitDob();
						}
					}
				} else {
					alertErase();
				}
			} else if (isSubmitted === false) {
				restoreDobField();
			}
		} else if (!isDate($('#dob').val())) {
			alertDobField();
			if (isSubmitted === true) {
				shakeElement('#dob');
			}
			maskDob();
		}
	} else if (isEmpty('#dob')) {
		alertDobField();
		if (isSubmitted === true) {
			shakeElement('#dob');
		}
	}
}
function eraseDobField() {
	enableFields(true);
	restoreDobField();
}
function showFullname() {
	enableFields(false);
	$('#dob, #help_dob').addClass('has_fullname');
	$('#dob_bar').prepend('<a tabindex="4" id="name_remove" class="m-btn green icn-only"><i class="icon-remove icon-white"></i></a><input tabindex="1" data-lang-ja="フルネーム" data-lang-zh="全名" data-lang-es="Nombre" data-lang-ru="Полное имя" data-lang-en="Full name" data-lang-vi="Họ tên" placeholder="'+fullnameText+'" id="fullname" type="text" name="fullname" size="24" maxlength="128" class="required m-wrap translate" value="'+((isset($('#fullname').val())) ? $('#fullname').val(): '')+'" />');
	$('#name_remove').ripple();
	$('#name_toggle').remove();
	$('#fullname').trigger('focus');
}
function hideFullname() {
	$('#dob, #help_dob').removeClass('has_fullname');
	$('#dob_bar').prepend('<a tabindex="1" class="m-btn" id="name_toggle"><span class="translate" data-lang-ja="フルネーム" data-lang-zh="全名" data-lang-es="Nombre" data-lang-ru="Полное имя" data-lang-en="Full name" data-lang-vi="Họ tên">'+fullnameText+'</span></a>');
	$('#name_remove, #fullname').remove();
}
function helpFullname() {
	$('#help_name').text($('#fullname').val());
	if (isEmpty('#fullname')) {
		$('#help_name').addClass('empty');
	} else if (!isEmpty('#fullname')) {
		$('#help_name').removeClass('empty');
	}
}
function rippleButtons() {
	$('a.button, button, input[type="submit"], input[type="reset"], input[type="button"], a.m-btn, a#logo, .dates-box .m-btn, #explain_source').ripple();
}
// Race functions
function getRandom(min, max) {
	return Math.round(Math.random()*(max-min)+min);
}
function race(playerId) {
	// Time: second unit, 5000 ms
	// Acceleration : pixels/(second*second) unit
	// Velocity : pixels/second unit
	// Distance : pixels unit
	var odometer = $(playerId+' > span.timer');
	var acceleration = 0;
	var distance = 0;
	var velocity = getRandom(4,16);
	for (time = 1; time <= 10; ++time) {
		acceleration = getRandom(-4,8);
		velocity += acceleration*time;
		$(playerId).attrchange(function() {
			distance = parseInt($(playerId).css('left'),10);
			odometer.html('Quãng đường: '+distance);
		}).animate({left: '+='+velocity+'px'}, {duration: 1000, easing: 'linear'});
	}
}
function raceRandom(playerId) {
	var keyTime = 420; // ms
	var laneLength = 800; // px
	var step = 8; // px
	var stepCount = laneLength/step;
	var coreTime = stepCount+getRandom(1,getRandom(1,getRandom(1,getRandom(1,getRandom(1,getRandom(1,getRandom(1,getRandom(1,getRandom(1,keyTime)))))))))/step;
	var players = $('.player');
	var playersCount = players.length;
	var playerRank = 0;
	var odometer = $(playerId+' > span.timer');
	var odometerText = '';
	var distance = 0;
	var randomTimes = new Array();
	// change this to increase gap between player
	for (i = 0; i < stepCount; ++i) {
		randomTimes[i] = getRandom(1,(coreTime-i)*step); // change this to increase gap between player
	}
	$(playerId).attrchange(function() {
		distance = parseInt($(playerId).css('left'),10);
		for (var i = 1; i <= laneLength; ++i) {
			if (distance == i) {
				odometer.addClass(i+'px');
				playerRank = $('.'+i+'px').length;
				if (playerRank == 1) {
					$(playerId).addClass('first').removeClass('last');
				} else if (playerRank == playersCount) {
					$(playerId).addClass('last').removeClass('first');
				} else if (playerRank > 1 && playerRank < playersCount) {
					$(playerId).removeClass('first').removeClass('last');
				}
				odometerText = 'Hạng '+playerRank;
			}
		}
		odometer.text(odometerText);
	});
	for (i = 0; i < stepCount; ++i) {
		$(playerId).animate({left: '+='+step+'px'}, {duration: randomTimes[i], easing: 'linear'});
	}
}
// Change banner ads
function updateBanner() {
	if (!Modernizr.mq('all and (min-width: 0px) and (max-width: 959px)')) {
		$('.banner.right').load('triggers/banner.php', {partner: 'sfi'});
	}
}