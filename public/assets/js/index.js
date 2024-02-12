
// fancybox в галерее
document.addEventListener('DOMContentLoaded', function() {
  const gallery = document.querySelectorAll('[data-fancybox="gallery"]');

  if (gallery.length > 0) {
    gallery.forEach(item => {
      item.addEventListener('click', function(e) {
        e.preventDefault();

        // Initialize FancyBox
        Fancybox.show([
          {
            src: item.href,
            type: 'image',
            caption: item.getAttribute('data-caption'),
            // Включаем зумирование
            zoom: {
              wheel: "auto", // "auto" - автоматически включить, если изображение большое, "yes" - всегда включено, "no" - отключено
              click: "toggle", // "toggle" - переключение при клике, "close" - закрытие при клике, "zoom", "next", "prev" - действия при клике
              mousewheel: "yes", // Включение/отключение зума колесиком мыши
              pinch: "yes" // Включение/отключение зума мультитачем (на устройствах с сенсорными экранами)
            }
          }
        ]);
      });
    });
  }
});

// скрипты масок (телефон)
document.addEventListener('DOMContentLoaded', function () {
  const phoneInputs = document.querySelectorAll("#phone");
  const button = document.querySelector("button[type='submit']");
  const errorMsg = document.querySelector("#error-msg");
  const validMsg = document.querySelector("#valid-msg");

  const errorMap = ["Неверный номер", "Неверный код страны", "Слишком короткий", "Слишком длинный", "Неверный номер"];

  const reset = () => {
    phoneInputs.forEach(input => {
      input.classList.remove("error");
    });
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
  };

  const initPhoneInput = (input) => {
    const iti = window.intlTelInput(input, {
      initialCountry: "ua",
      geoIpLookup: function (callback) {
        fetch("https://ipinfo.io", {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        })
        .then(response => response.json())
        .then(data => {
          var countryCode = data.country || "";
          callback(countryCode);
        })
        .catch(error => {
          console.error('Error fetching IP info:', error);
        });
      },
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/utils.js",
      useFullscreenPopup: true,
    });

    // Устанавливаем значение и маску при загрузке страницы
    if (iti.getSelectedCountryData().iso2 === "ua") {
      $(input).inputmask({ mask: "+38(0##)##-##-##", showMaskOnHover: false });
    } else {
      input.value = '+' + iti.getSelectedCountryData().dialCode;
      $(input).inputmask({ mask: "+999999999999", showMaskOnHover: false });
    }

    // Устанавливаем плейсхолдер
    input.placeholder = '+' + iti.getSelectedCountryData().dialCode;

    input.addEventListener('input', function () {
      // Оставляем только цифры
      this.value = this.value.replace(/\D/g, '');
    });

    input.addEventListener('countrychange', function () {
      var selectedCountry = iti.getSelectedCountryData();
      var dialCode = selectedCountry.dialCode;

      // Устанавливаем значение и маску при изменении страны
      if (selectedCountry.iso2 === "UA") {
        $(input).inputmask({ mask: "38(999)999-99-99", showMaskOnHover: false });
      } else {
        input.value = '+' + dialCode;
        $(input).inputmask('remove');
        $(input).inputmask({ mask: "+999999999999", showMaskOnHover: false });
      }

      // Устанавливаем плейсхолдер
      input.placeholder = '+' + dialCode;
    });
  };

  button.addEventListener('click', function (e) {
    reset();
    phoneInputs.forEach(input => {
      if (input.value.trim() && !window.intlTelInput(input).isValidNumber()) {
        e.preventDefault();
        input.classList.add("error");
        const errorCode = window.intlTelInput(input).getValidationError();
        errorMsg.innerHTML = errorMap[errorCode] || "Неверный номер";
        errorMsg.classList.remove("hide");
      }
    });
  });

  // Initialize each phone input
  phoneInputs.forEach(input => {
    initPhoneInput(input);
  });
});






document.addEventListener('DOMContentLoaded', function() {
  // Найти все элементы с классом 'services__card' и добавить обработчик для каждой
  var cards = document.querySelectorAll('.free-webinars__card');
  cards.forEach(function(card) {
      card.addEventListener('click', function() {
          replaceWithVideo(card);
      });
  });
});

function replaceWithVideo(card) {
  var image = card.querySelector('.img-fluid');
  var cardInfo = card.querySelector('.card__info');
  var cardArrow = card.querySelector('.card__arrow');
  var cardPlay = card.querySelector('.services-opened__card-play');
  var cardMore = card.querySelector('.card__more');
  var webinarAuthor = card.querySelector('.webinar__author');
  var videoFrame = card.querySelector('.video-frame');

  // Скрыть изображение, информацию, стрелку и элемент "services-opened__card-play"
  image.style.display = 'none';
  cardInfo.style.display = 'none';
  cardArrow.style.display = 'none';
  cardPlay.style.display = 'none';

  // Показать видео
  videoFrame.style.display = 'block';

  // Показать элемент "webinar__author"
  webinarAuthor.style.display = 'block';

  // Получить URL видео из атрибута data-video-url и установить его в iframe
  var videoUrl = card.getAttribute('data-video-url');
  videoFrame.src = videoUrl;


}








// скрипт плавного появления секций
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animated'); // Добавляем класс 'animated' при видимости
            observer.unobserve(entry.target);
        }
        });
    }, { threshold: 0.15 });

    sections.forEach(section => {
        observer.observe(section);
    });
});
// скрипт плавного появления секций
document.addEventListener('DOMContentLoaded', () => {
  const articles = document.querySelectorAll('article');

  const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
      if (entry.isIntersecting) {
          entry.target.classList.add('animated'); // Добавляем класс 'animated' при видимости
          observer.unobserve(entry.target);
      }
      });
  }, { threshold: 0.15 });

  articles.forEach(article => {
      observer.observe(article);
  });
});

// скрипт поведения аккордеона
document.addEventListener('DOMContentLoaded', function() {
    // Выбираем все элементы аккордеона
    const accItems = document.querySelectorAll(".accordion__item");

    // Добавляем событие клика для всех элементов
    accItems.forEach((acc) => acc.addEventListener("click", toggleAcc));

    function toggleAcc() {
    // Удаляем класс "accordion__item--active" у всех элементов, кроме текущего (this)
    accItems.forEach((item) => {
        // Если элемент не текущий (this), убираем класс "accordion__item--active"
        // В противном случае - оставляем без изменений
        item != this ? item.classList.remove("accordion__item--active") : null;
    });

    // Переключаем класс "accordion__item--active" у текущего элемента
    if (this.classList != "accordion__item--active") {
        this.classList.toggle("accordion__item--active");
    }
    }
});
// end


// burger
document.addEventListener('DOMContentLoaded', function() {
  // Получаем необходимые элементы DOM
  const burgerMenu = document.getElementById('header__burger');
  const overlayMenu = document.querySelector('.overlay-menu');
  const body = document.querySelector('body');
  const headerLogo = document.querySelector('.header__logo');
  let overlayBackground = document.createElement('div'); // Создаем элемент подложки overlay
  body.appendChild(overlayBackground); // Добавляем подложку в body

  // Функция для открытия/закрытия меню
  function toggleMenu() {
      overlayMenu.classList.toggle('active'); // Переключаем класс для меню
      body.classList.toggle('fixed'); // Переключаем класс для body

      // Добавляем/удаляем класс для header__logo при активации/деактивации меню
      headerLogo.classList.toggle('logo-active', overlayMenu.classList.contains('active'));

      // Показываем/скрываем подложку overlay background
      overlayBackground.classList.toggle('overlay-background', overlayMenu.classList.contains('active'));

      // Изменение иконки в зависимости от состояния меню
      if (overlayMenu.classList.contains('active')) {
          burgerMenu.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M7.01444 6.29074L0.943922 0L0.223904 0.693955L6.29464 6.98492L0 13.0557L0.694165 13.7755L6.98904 7.70451L13.0597 13.9954L13.7797 13.3014L7.70884 7.01033L13.9993 0.943592L13.3052 0.223777L7.01444 6.29074Z" fill="black" fill-opacity="0.5"/>
          </svg>
          `;
      } else {
          burgerMenu.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" width="29" height="20" viewBox="0 0 29 20" fill="none">
              <g clip-path="url(#clip0_8_98)">
                  <rect width="29" height="3.15797" rx="1.57898" fill="#47C0F4"/>
                  <rect y="8.42139" width="29" height="3.15797" rx="1.57898" fill="#47C0F4"/>
                  <rect y="16.8418" width="29" height="3.15797" rx="1.57898" fill="#47C0F4"/>
              </g>
              <defs>
                  <clipPath id="clip0_8_98">
                      <rect width="29" height="20" fill="white"/>
                  </clipPath>
              </defs>
          </svg>
          `;
      }
  }

  // Обработчик события клика на иконку бургер-меню
  burgerMenu.addEventListener('click', function(event) {
      event.stopPropagation();
      toggleMenu();
  });

  // Обработчик события клика вне меню (закрытие меню)
  document.addEventListener('click', function(event) {
      if (!overlayMenu.contains(event.target) && overlayMenu.classList.contains('active')) {
          toggleMenu();
      }
  });

  // Добавляем обработчики событий клика для ссылок в меню
  const menuLinks = document.querySelectorAll('.overlay-menu a');
  menuLinks.forEach(function(link) {
      link.addEventListener('click', function() {
          toggleMenu(); // Закрываем меню при клике на ссылку
          // Добавьте дополнительный функционал, если необходимо (например, прокрутка к нужному разделу)
      });
  });
});

// burger



  document.addEventListener('DOMContentLoaded', function() {
    // Инициализация WOW.js
    var wow = new WOW({
      boxClass: 'wow',
      animateClass: 'animated',
      offset: 0,
      mobile: true,
      live: false // Отключаем автоматическое обнаружение изменений содержимого
    });

    // Получаем все элементы с классом 'wow'
    var wowElements = document.querySelectorAll('.wow');

    // Создаем Intersection Observer
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          // Если элемент виден, добавляем класс 'animated' и запускаем анимацию
          entry.target.classList.add('animated');
          wow.sync();
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 }); // Мы реагируем на появление элемента хотя бы на 50%

    // Наблюдаем за каждым элементом
    wowElements.forEach(function(element) {
      observer.observe(element);
    });

    // Запуск WOW.js
    wow.init();
  });


// расписание слайдер
document.addEventListener('DOMContentLoaded', function () {
    var mySwiper = new Swiper('.schedule-slider', {
        // Настройки Swiper...
        slidesPerView: 'auto',
        spaceBetween: 10,
        navigation: {
            nextEl: '.schedule-swiper-button-next',
            prevEl: '.schedule-swiper-button-prev',
        },

    });
});


// фотогалерея
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.photo-gallery__swiper', {

        spaceBetween: 20,
        navigation: {
            nextEl: '.photo-gallery-button-next',
            prevEl: '.photo-gallery-button-prev',
        },
        loop: true,
        breakpoints: {
            1024: {
                slidesPerView: 3,
            },
            567: {
                slidesPerView: 2,
            },
            467: {
                slidesPerView: 1,
            },
        },
    });
});





document.getElementById('togglePassword').addEventListener('click', function () {
    var passwordInput = document.getElementById('password');
    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    var icon = document.getElementById('togglePassword').querySelector('svg');
    if (type === 'password') {
        icon.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.5001 0.466309C8.22073 0.466309 4.27964 2.6856 1.5682 6.43269C0.936153 7.30353 0.648254 8.42223 0.648254 9.49447C0.648254 10.5664 0.936041 11.6848 1.5678 12.5556C4.27925 16.3031 8.22052 18.5226 12.5001 18.5226C16.7795 18.5226 20.7206 16.3033 23.4321 12.5562C24.0641 11.6853 24.352 10.5666 24.352 9.49447C24.352 8.42245 24.0642 7.30398 23.4324 6.43325C20.721 2.68581 16.7798 0.466309 12.5001 0.466309ZM9.96891 9.50009C9.96891 8.09947 11.0995 6.96884 12.5001 6.96884C13.9008 6.96884 15.0314 8.09947 15.0314 9.50009C15.0314 10.9007 13.9008 12.0313 12.5001 12.0313C11.0995 12.0313 9.96891 10.9007 9.96891 9.50009ZM12.5001 5.28134C10.1676 5.28134 8.28141 7.16748 8.28141 9.50009C8.28141 11.8327 10.1676 13.7188 12.5001 13.7188C14.8328 13.7188 16.7189 11.8327 16.7189 9.50009C16.7189 7.16748 14.8328 5.28134 12.5001 5.28134Z" fill="#47C0F3" fill-opacity="0.34"/>';
    } else {
        icon.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.5001 0.466309C8.22073 0.466309 4.27964 2.6856 1.5682 6.43269C0.936153 7.30353 0.648254 8.42223 0.648254 9.49447C0.648254 10.5664 0.936041 11.6848 1.5678 12.5556C4.27925 16.3031 8.22052 18.5226 12.5001 18.5226C16.7795 18.5226 20.7206 16.3033 23.4321 12.5562C24.0641 11.6853 24.352 10.5666 24.352 9.49447C24.352 8.42245 24.0642 7.30398 23.4324 6.43325C20.721 2.68581 16.7798 0.466309 12.5001 0.466309ZM9.96891 9.50009C9.96891 8.09947 11.0995 6.96884 12.5001 6.96884C13.9008 6.96884 15.0314 8.09947 15.0314 9.50009C15.0314 10.9007 13.9008 12.0313 12.5001 12.0313C11.0995 12.0313 9.96891 10.9007 9.96891 9.50009ZM12.5001 5.28134C10.1676 5.28134 8.28141 7.16748 8.28141 9.50009C8.28141 11.8327 10.1676 13.7188 12.5001 13.7188C14.8328 13.7188 16.7189 11.8327 16.7189 9.50009C16.7189 7.16748 14.8328 5.28134 12.5001 5.28134Z" fill="#47C0F3" fill-opacity="1"/>';
    }
});



