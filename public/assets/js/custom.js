function translateCode() {
  var lang = Cookies.get('translate') != undefined && Cookies.get('translate') != 'null'
    ? Cookies.get('translate')
    : 'id';
  return lang.match(/(?!^\/)[^\/]*$/gm).shift();
}

const layerMenuItem = document.querySelector('#layerMenuItem');
const filterMenuItem = document.querySelector('#filterMenuItem');
const layerContent = document.querySelector('#layerContent');
const filterContent = document.querySelector('#filterContent');


function showLayerContent() {
  layerContent.style.display = 'block';
  filterContent.style.display = 'none';
  layerMenuItem.classList.add('active');
  filterMenuItem.classList.remove('active');
}

function showFilterContent() {
  filterContent.style.display = 'block';
  layerContent.style.display = 'none';
  filterMenuItem.classList.add('active');
  layerMenuItem.classList.remove('active');
}

layerMenuItem.addEventListener('click', showLayerContent);
filterMenuItem.addEventListener('click', showFilterContent);

showLayerContent();
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sideLeft");
  const sidebarToggle = document.getElementById("sidebarToggle");
  const toggleIcon = document.getElementById("toggleIcon");

  function toggleSidebar() {
    sidebar.classList.toggle("sidebarHidden");
    toggleIcon.classList.toggle("fa-chevron-right");
    toggleIcon.classList.toggle("fa-chevron-left");
  }

  sidebarToggle.addEventListener("click", toggleSidebar);
}); 
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sideRight");
  const sidebarToggle = document.getElementById("sideToggle");
  const toggleIcon = document.getElementById("toggleIkon");
  const legend = document.getElementById('legend');

  function toggleSidebar() {
    sidebar.classList.toggle("sidebarHide");
    toggleIcon.classList.toggle("fa-chevron-right");
    toggleIcon.classList.toggle("fa-chevron-left");

    
    if (sidebar.classList.contains("sidebarHide")) {
      legend.classList.toggle("sidebarHide"); 
    } else {
      legend.style.right = '260px'; 
    }
  }

  
  if (sidebar.style.display === 'block') {
    legend.style.right = '260px'; 
  } else {
    legend.classList.toggle("sidebarHide");
  }

  sidebarToggle.addEventListener("click", toggleSidebar);
});

const menuItems = document.querySelectorAll('.bg-soft-primary');

menuItems.forEach((menuItem) => {
  menuItem.addEventListener('click', () => {
    const icon = menuItem.querySelector('img');
    if (icon) {
      icon.classList.toggle('rotate180');
    }
  });
});
const menuItemm = document.querySelectorAll('.potensi');

menuItemm.forEach((menuItem) => {
  menuItem.addEventListener('click', () => {
    const icon = menuItem.querySelector('img');
    if (icon) {
      icon.classList.toggle('rotate180');
    }
  });
});

(function () {
  'use strict'
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl)
  })
})()

document.querySelectorAll('.accordion-button').forEach(function (button) {
  button.addEventListener('click', function () {
    
    var icon = button.querySelector('.bi');

    
    if (icon.classList.contains('bi-chevron-right')) {

      icon.classList.replace('bi-chevron-right', 'bi-chevron-down');
    } else {
      
      icon.classList.replace('bi-chevron-down', 'bi-chevron-right');
    }
  });
});
document.querySelectorAll('.reeQ').forEach(function (button) {
  button.addEventListener('click', function () {
    
    var icon = button.querySelector('.bi');

    
    if (icon.classList.contains('bi-chevron-right')) {

      icon.classList.replace('bi-chevron-right', 'bi-chevron-down');
    } else {

      icon.classList.replace('bi-chevron-down', 'bi-chevron-right');
    }
  });
});

function translate() {
  var code = translateCode();
  $('[data-active-lang]').html(code.toUpperCase());

  if (code == 'id') {
    Cookies.set('translate', 'null');
    Cookies.set('translate', 'null', {
      domain: '.' + document.domain
    });
  }

  new google.translate.TranslateElement({
    pageLanguage: 'id'
  });

  $(document).on('click', '[data-switch-lang]', function (evt) {
    evt.preventDefault();

    var code = $(this).data('switchLang');

    Cookies.set('translate', '/id/' + code);
    Cookies.set('translate', '/id/' + code, {
      domain: '.' + document.domain
    });

    window.location.reload();
  });
}

(function ($) {
  $.fn.serializeJSON = function () {
    var json = {};
    var form = $(this);

    form.find('input, select').each(function () {
      var val;
      if (!this.name) return;

      if ('radio' === this.type) {
        if (json[this.name]) return;

        json[this.name] = this.checked ? this.value : '';
      } else if ('checkbox' === this.type) {
        val = json[this.name];

        if (!this.checked) {
          if (!val) json[this.name] = '';
        } else {
          json[this.name] =
            typeof val === 'string' ? [val, this.value] :
              $.isArray(val) ? $.merge(val, [this.value]) :
                this.value;
        }
      } else {
        json[this.name] = this.value;
      }
    });

    return json;
  };

  $('.newsletter-wrapper form').on('submit', function (evt) {
    evt.preventDefault();

    var url = $(this).attr('action');
    var data = $(this).serializeJSON();

    $.ajax({
      method: "POST",
      url,
      data,
      success: function (data) {
        if (data.type == 'success') {
          $('#email-newsletter').val('');
        }

        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
          }
        });

        Toast.fire({
          icon: data.type,
          title: data.message
        });
      }
    });
  });

  (function () {
    var script = document.createElement('script');
    script.src = '//translate.google.com/translate_a/element.js?cb=translate';
    document.getElementsByTagName("head")[0].appendChild(script);
  })();

  function mapDetect() {
    var width = $(window).width();
    if (width < 992) {

      $('#desktop-only').attr('style', 'display:none!important');
      $('#mobile-only').removeAttr('style');
    } else {
      $('#desktop-only').removeAttr('style');
      $('#mobile-only').attr('style', 'display:none!important');
    }
  }

  $(window).on('resize', mapDetect);
  mapDetect();

  const filtering = $('[name="district"]');
  if (!!filtering.length) {
    var backup = $('.levious-filter').html();

    filtering.on('change', function () {
      $('body > .loading').fadeIn();

      var district = $(this).val();

      if (!district) {
        $('.levious-filter').html(backup);
        $('body > .loading').fadeOut();

        return;
      }

      $.ajax({
        method: 'GET',
        url: BASE_URL + '/api/kmz',
        data: { apikey: API_KEY, district },
        success: function ({ data }) {
          var html = '';

          if (Object.keys(data).length) {
            for (var i in Object.keys(data)) {
              html += '<div style="font-size: .9rem;" class="fw-bold mb-1">';
              html += Object.keys(data)[i];
              html += '</div>';

              for (var j in Object.values(data)[i]) {
                var item = Object.values(data)[i][j];

                html += '<div class="form-check">';
                html += '<input class="form-check-input" type="checkbox" value="bumbudapur" id="';
                html += item.filename.split('.')[0];
                html += '" data-filename="';
                html += item.filename;
                html += '"><label class="form-check-label noselect" for="';
                html += item.filename.split('.')[0];
                html += '">' + item.name + '</label>';
                html += '</div>';
              }
            }
          } else {
            html = '<div class="d-flex h-100 justify-content-center align-items-center text-center"><i>Data tidak tersedia.</i></div>';
          }

          $('.levious-filter').html(html);
          $('body > .loading').fadeOut();
        },
      });
    });
  }
})(jQuery);
