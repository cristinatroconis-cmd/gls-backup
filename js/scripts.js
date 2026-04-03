jQuery(function ($) {
  /* ===============================
     CONTADOR AL HACER SCROLL
  =============================== */
  let viewed = false;

  function isScrolledIntoView(elem) {
    const docViewTop = $(window).scrollTop();
    const docViewBottom = docViewTop + $(window).height();
    const elemTop = $(elem).offset().top;
    const elemBottom = elemTop + $(elem).outerHeight();
    return elemBottom <= docViewBottom && elemTop >= docViewTop;
  }

  function testScroll() {
    if (!$('.banner-datos').length || viewed) return;

    if (isScrolledIntoView($('.banner-datos'))) {
      viewed = true;
      $('.count').each(function () {
        $(this).prop('Counter', 0).animate(
          { Counter: $(this).text() },
          {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
              $(this).text(Math.ceil(now));
            },
          }
        );
      });
    }
  }

  $(window).on('scroll', testScroll);

/* ===============================
   HEADER STICKY + COLOR 04/02/26
=============================== */
const header = $('#page-header');

if (header.length) {
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 60) {
      header.addClass('is-scrolled');
    } else {
      header.removeClass('is-scrolled');
    }
  });
}

/* ===============================
   HAMBURGER MENU (OVERLAY)
=============================== */

const $burger = $('.header__burger');
const $overlay = $('.header__wrapper-overlay-menu');
const $body = $('body');

function openMenu() {
  $overlay.addClass('is-open');
  $body.addClass('menu-open');
  $burger.addClass('is-open');
}

function closeMenu() {
  $overlay.removeClass('is-open');
  $body.removeClass('menu-open');
  $burger.removeClass('is-open');
}

if ($burger.length && $overlay.length) {

  // Toggle burger
  $burger.on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    if ($overlay.hasClass('is-open')) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  // Cerrar al clicar un link del menú
  $overlay.on('click', 'a', function () {
    closeMenu();
  });

  // Cerrar al clicar el fondo del overlay (no el menú)
  $overlay.on('click', function (e) {
    if (e.target === this) {
      closeMenu();
    }
  });

  // Cerrar con ESC
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $overlay.hasClass('is-open')) {
      closeMenu();
    }
  });
}
	
	// Botón cerrar (X)
$('.overlay-close').on('click', function (e) {
  e.preventDefault();
  closeMenu();
});

  /* ===============================
     SOPORTE TOUCH EN CARROUSEL (Bootstrap)
  =============================== */
  $('.carousel').on('touchstart', function (event) {
    const xClick = event.originalEvent.touches[0].pageX;

    $(this).one('touchmove', function (event) {
      const xMove = event.originalEvent.touches[0].pageX;
      const sensitivity = 5;

      if (Math.floor(xClick - xMove) > sensitivity) {
        $(this).carousel('next');
      } else if (Math.floor(xClick - xMove) < -sensitivity) {
        $(this).carousel('prev');
      }
    });

    $(this).one('touchend', function () {
      $(this).off('touchmove');
    });
  });
/* =========================================================
   GLS – Hover autoplay para cards apartamentos
   Fecha: 13/02/2026
   ========================================================= */

$('.apartamento-carousel').each(function () {

  const el = this;

  // Solo si tiene más de 1 imagen
  const items = el.querySelectorAll('.carousel-item');
  if (items.length < 2) return;

  // Crear instancia manualmente
  const instance = new bootstrap.Carousel(el, {
    interval: 2500,
    ride: false,
    pause: false,
    wrap: true
  });

  // Hover desktop
  $(el).on('mouseenter', function () {
    if (window.innerWidth > 991) {
      instance.cycle();
    }
  });

  $(el).on('mouseleave', function () {
    instance.pause();
  });

});


  /* ===============================
     SLIDER DE EXPERIENCIAS Y TABS
  =============================== */
  $('.experiencias-category').slick({
    lazyLoad: 'ondemand',
    centerMode: true,
    speed: 750,
    slidesToShow: 1,
    dots: true,
    arrows: true,
    centerPadding: '400px',
    responsive: [
      { breakpoint: 1400, settings: { centerPadding: '350px' } },
      { breakpoint: 1200, settings: { centerPadding: '250px' } },
      { breakpoint: 992, settings: { centerPadding: '100px' } },
      { breakpoint: 769, settings: { centerPadding: '75px' } },
      { breakpoint: 576, settings: { centerPadding: '30px' } },
    ],
  });

  function updateExperienciasBackground() {
    const targetId = $('.tabs-child.active').data('target');
    if (!targetId) return;

    const imgSrc = $('#' + targetId)
      .find('.slick-current img')
      .attr('src');

    if (!imgSrc) return;

    const $bg = $('#experiencias-background');
    $bg.css('opacity', 0);
    setTimeout(() => {
      $bg.attr('src', imgSrc).css('opacity', 1);
    }, 400);
  }

  function centerActiveTab() {
    const $active = $('.tabs-child.active');
    const $container = $('#experiencias-tabs');
    if (!$active.length) return;

    const center = $container.width() / 2;
    const tabCenter = $active.position().left + $active.outerWidth() / 2;
    $container.css('transform', `translateX(${center - tabCenter}px)`);

    $('.tabs-underline').css({
      width: $active.outerWidth(),
      left: $active.position().left,
    });

    updateExperienciasBackground();
  }

  if ($('.tabs-child').length) {
    $('.tabs-child').on('click', function () {
      const target = $(this).data('target');

      $('.tabs-child').removeClass('active');
      $(this).addClass('active');

      $('.experiencias-category').hide().removeClass('active');
      $('#' + target).show().addClass('active').slick('refresh');

      $('.experiencias-description').removeClass('active');
      $('.experiencias-description-' + target).addClass('active');

      centerActiveTab();
    });

    setTimeout(() => $('.tabs-child').first().trigger('click'), 1200);
  }

  /* ===============================
     FORMULARIOS - EFECTO AL HACER FOCUS
  =============================== */
  $('input[type="text"], input[type="email"]').on('focus', function () {
    $(this).closest('.form-group, .field').addClass('focusin');
  });

  $('input[type="text"], input[type="email"]').on('blur', function () {
    if (!$(this).val()) {
      $(this).closest('.form-group, .field').removeClass('focusin');
    }
  });

  /* ===============================
     TARJETAS CLICKABLES
  =============================== */
  $('article.card').on('click', function () {
    const link = $(this).find('a.read_more').attr('href');
    if (link) window.location.href = link;
  });
});

/* =========================================================
   GLS – Buscador de disponibilidad | Inicializar calendario
   Fecha: 09/02/2026
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const datesInput = document.getElementById('gls-dates');

    // Seguridad: solo inicializa si el input existe
    if (!datesInput || typeof Litepicker === 'undefined') return;

    const picker = new Litepicker({
        element: datesInput,

        singleMode: false,            // rango de fechas
        numberOfMonths: 2,
        numberOfColumns: 2,

        format: 'DD/MM/YYYY',
        lang: 'es-ES',

        autoApply: true,              // no botón "Apply"
        allowRepick: true,

        minDate: new Date(),          // no permitir fechas pasadas

        tooltipText: {
            one: 'noche',
            other: 'noches'
        },

        tooltipNumber: (totalDays) => {
            return totalDays - 1;     // noches reales
        },

        setup: (picker) => {
            picker.on('selected', (date1, date2) => {
                if (!date1 || !date2) return;

                // Guardamos las fechas en data-attributes
                datesInput.dataset.checkin  = date1.format('YYYY-MM-DD');
                datesInput.dataset.checkout = date2.format('YYYY-MM-DD');

                console.log('Check-in:', datesInput.dataset.checkin);
                console.log('Check-out:', datesInput.dataset.checkout);
            });
        }
    });

});

/* =========================================================
   GLS – Buscador de disponibilidad | Submit home-search
   Fecha: 09/02/2026
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const form      = document.getElementById('gls-search-form');
    const dates     = document.getElementById('gls-dates');
    const guests    = document.getElementById('gls-guests');
    const submitBtn = document.getElementById('gls-search-submit');

    if (!form || !dates || !guests || !submitBtn) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const checkin  = dates.dataset.checkin;
        const checkout = dates.dataset.checkout;
        const persons  = guests.value;

        if (!checkin || !checkout) {
            dates.classList.add('gls-error');
            dates.focus();
            return;
        }

        if (!persons || persons < 1) {
            guests.classList.add('gls-error');
            guests.focus();
            return;
        }

        dates.classList.remove('gls-error');
        guests.classList.remove('gls-error');

        const baseUrl = '/apartamentos/';

        const params = new URLSearchParams({
            arrival:   checkin,
            departure: checkout,
            guests:    persons
        });

        const finalUrl = `${baseUrl}?${params.toString()}`;

        console.log('Redirect →', finalUrl);
        window.location.href = finalUrl;
    });

});

/* =========================================================
   GLS – Buscador disponibilidad | Placeholder UX 
   Fecha: 09/02/2026
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const datesInput = document.getElementById('gls-dates');
    if (!datesInput) return;

    /* Estado inicial */
    datesInput.value = '';
    datesInput.setAttribute('placeholder', 'Check-in – Check-out');

    /* Al enfocar */
    datesInput.addEventListener('focus', function () {
        if (!datesInput.dataset.checkin) {
            datesInput.setAttribute('placeholder', 'Selecciona fechas');
        }
    });

    /* Al salir sin fechas */
    datesInput.addEventListener('blur', function () {
        if (!datesInput.dataset.checkin) {
            datesInput.setAttribute('placeholder', 'Check-in - Check-out');
        }
    });

});

/* =========================================
   INICIALIZACIÓN SLICK – PUBLICS HOME
   Fecha: 12-02-2026
========================================= */

jQuery(window).on('load', function () {
    if (jQuery('.publics-home-slides').length) {
        jQuery('.publics-home-slides').not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            infinite: true
        });
    }
});
