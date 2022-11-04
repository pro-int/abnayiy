/*=========================================================================================
	File Name: form-number-input.js
	Description: Number Input
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function (window, document, $) {
  'use strict';

  // Default Spin
  var touchspin = $('.touchspin');
  touchspin.TouchSpin({
    step: touchspin.data('step') ?? 1,
    min: touchspin.data('min') ?? 0,
    max: touchspin.data('max') ?? 100,
    buttondown_class: 'btn btn-primary',
    buttonup_class: 'btn btn-primary',
    buttondown_txt: feather.icons['minus'].toSvg(),
    buttonup_txt: feather.icons['plus'].toSvg()
  });

  // Icon Change
  var touchspinIcon = $('.touchspin-icon');
  touchspinIcon.TouchSpin({
    step: touchspinIcon.data('step') ?? 1,
    min: touchspinIcon.data('min') ?? 0,
    max: touchspinIcon.data('max') ?? 100,
    buttondown_txt: feather.icons['chevron-down'].toSvg(),
    buttonup_txt: feather.icons['chevron-up'].toSvg()
  });

  // Min - Max

  var touchspinValue = $('.touchspin-min-max'),counterMin,counterMax;
  if (touchspinValue.length > 0) {
    
    counterMin = touchspinValue.data('min') ?? 0
    counterMax = touchspinValue.data('max') ?? 100

    touchspinValue
      .TouchSpin({
        step: touchspinValue.data('step') ?? 1,
        min: counterMin,
        max: counterMax,
        buttondown_txt: feather.icons['minus'].toSvg(),
        buttonup_txt: feather.icons['plus'].toSvg()
      })
      .on('touchspin.on.startdownspin', function () {
        var $this = $(this);
        $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
        if ($this.val() == counterMin) {
          $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
        }
      })
      .on('touchspin.on.startupspin', function () {
        var $this = $(this);
        $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
        if ($this.val() == counterMax) {
          $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
        }
      });
  }

  // Step
  var touchspinStep =$('.touchspin-step');
  touchspinStep.TouchSpin({
    step: touchspinStep.data('step') ?? 5,
    min: touchspinStep.data('min') ?? 0,
    max: touchspinStep.data('max') ?? 100,
        buttondown_txt: feather.icons['minus'].toSvg(),
    buttonup_txt: feather.icons['plus'].toSvg()
  });

  // Color Options
  $('.touchspin-color').each(function (index) {
    var down = 'btn btn-primary',
      up = 'btn btn-primary',
      $this = $(this);
    if ($this.data('bts-button-down-class')) {
      down = $this.data('bts-button-down-class');
    }
    if ($this.data('bts-button-up-class')) {
      up = $this.data('bts-button-up-class');
    }
    $this.TouchSpin({
      mousewheel: false,
      buttondown_class: down,
      buttonup_class: up,
      buttondown_txt: feather.icons['minus'].toSvg(),
      buttonup_txt: feather.icons['plus'].toSvg()
    });
  });
})(window, document, jQuery);
