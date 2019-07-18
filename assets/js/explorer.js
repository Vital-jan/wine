function parseIntBack(s) { // возвращает числовую часть в конце строки.
// например, на входе: 'abc123', на выходе: '123'.
  return parseInt(s.split('').reverse().join()).toString().split('').reverse().join();
}

// =====================================================================
function setSlider(
// =====================================================================
  max,
  path,
  prefix,
  delay,
  fade,
  sliderId,
  title = [],
  arrowsVisible = true,
  circlesVisible = true
) {
  // аргументы: ==========================================================
  // использует стиль explorer-slider.
  // в этом стиле описана высота слайдера.
  // ширина слайдера - 100%
  // Пример: setSlider(4, 'assets/img/slider/', 'img', 3, 0.5, 'slider');
  // --------------------------------------------
  // max - максимальный индекс рисунка (к-во изображений)
  // prefix - префикс имени файла изображения
  // delay - время показа изображения в секундах
  // fade - время набора 100% непрозрачности (от 0 до 1 delay)
  // sliderId - идентификатор элемента-родителя;
  // title - подписи к картинкам (массив). если значение не указано, не отображается.
  // arrowsVisible, circlesVisible - видимость стрелок и кружочков
  // ----------------------------------------------------
  // Подключить таблицу стилей. При необходимости, можно дополнительно стилизовать каждый слайдер по его идентификатору.
  // высота слайдера установлена в CSS.

  let slider = document.querySelector(`#${sliderId}`);
  if (slider == null) return;

  const fps = 25; // частота обновления, кадров/сек
  let counter = 1; // индекс текущего рисунка
  let prevCounter = 0; // индекс предыдущего рисунка
  let opacity = 0; // текущая прозрачность рисунка
  let timeNext = 0; // время смены рисунка
  let paused = false;

  // стили для slider
  slider.classList.add("explorer-slider");

  // создаем и стилизуем графический контент
  let img = document.createElement('img');
  slider.appendChild(img);

  let sliderWidth = slider.getBoundingClientRect().width;
  let sliderHeight = img.getBoundingClientRect().height;

  // обработчики для img (пауза в прокрутке)
  img.onmouseenter = () => {
    paused = true;
  };    
  img.onmouseleave = () => {
    paused = false;
  };    

  // создаем и стилизуем контейнер для элементов-кружочков
  let circles = document.createElement('div');
  circles.classList = 'circles';
  slider.appendChild(circles);
  if (!circlesVisible) circles.style.visibility = 'hidden';
  circles.style.width = sliderWidth;
  circles.id = `${sliderId}-circles`;

  circles.addEventListener('click', function(event) {
    if (!isNaN(parseIntBack(event.target.id))) {
      prevCounter = counter;
      counter = parseIntBack(event.target.id);
      refresh();
      timeNext = 0;
    }
  });

  // создаем подпись под слайдером
  let ttl = document.createElement('h3');
  slider.appendChild(ttl);

  // добавляем элементы стрелка влево-вправо
  let arrow = [];
  for (n = 0; n < 2; n++) {
    arrow[n] = document.createElement('div');
    arrow[n].innerHTML =
      '<i style="transform: rotate(180deg)" class="material-icons"> arrow_forward_ios </i>';
    arrow[n].classList.add('arrow');
    if (!arrowsVisible) arrow[n].style.visibility = 'hidden';
    circles.appendChild(arrow[n]);
  }
  arrow[1].style.transform = 'rotate(180deg)'; // поворачиваем правую стрелку вправо

  // обработчики клика по стрелкам
  arrow[0].addEventListener('click', function() {
    if (counter > 1) {
      prevCounter = counter;
      counter--;
      timeNext = 0;
      refresh();
    }
  });
  arrow[1].addEventListener('click', function() {
    if (counter < max) {
      prevCounter = counter;
      counter++;
      timeNext = 0;
      refresh();
    }
  });

  var s = (sliderWidth / max) * 0.05; // вычисляем размер кружочка
  // s = s > (sliderHeight / max) * 0.4 ? (sliderHeight / max) * 0.4 : s;

  // создаем, добавляем и стилизуем элементы-кружочки
  for (var n = 1; n <= max; n++) {
    var el = document.createElement('div');
    circles.insertBefore(el, arrow[1]);
    el.classList = 'circle';
    el.id = `${sliderId}-circle${n}`;
    el.style.width = `${s}px`;
    el.style.height = `${s}px`;
    el.style.borderWidth = `${Math.round(s / 4)}px`;
  }

  function refresh(){

    img.setAttribute('src', `${path}${prefix}${counter}.jpg`); // отрисовка изображения

    if (title[counter - 1] !== undefined) {
      ttl.innerHTML = title[counter - 1];
    } else {
      ttl.innerHTML = title[counter - 1] = '';
    }

    if (prevCounter != 0) {
      let elem = document.querySelector(`#${sliderId}-circle${prevCounter}`); // стираем предыдущий кружочек
      elem.style.backgroundColor = 'white';
    }

    elem = document.querySelector(`#${sliderId}-circle${counter}`); // рисуем текущий кружочек
    elem.style.backgroundColor = 'black';

    if (counter == max) {// активируем/деактивируем стрелки влево/право
      arrow[1].classList.add('no-active');
    } else {
      arrow[1].classList.remove('no-active');
    }
    if (counter == 1) {
      arrow[0].classList.add('no-active');
    } else {
      arrow[0].classList.remove('no-active');
    }
    

  }

  refresh();

  // таймер
  let interval = setInterval(function() {

    if (!slider) {// проверяем наличие элемента slider в DOM
      clearInterval(interval);
      return;
    }
    
    if (timeNext >= fps * delay) { // при достижении времени смены изображения:
      
      timeNext = 0;
      opacity = 0;
      prevCounter = counter;
      counter = counter < max ? Number(counter) + 1 : 1;
      img.setAttribute('src',`${path}${prefix}${counter}.jpg`);
      refresh(); // перерисовка
    }

    if (!paused) timeNext++; // если не наведен курсор - инкрементируем счетчик времени

    opacity = opacity < 1 ? opacity + 1 / (fps * fade) : 1; // увеличиваем яркость, пока не будет достигнута максимальная
    img.style.opacity = opacity;
    ttl.style.opacity = opacity;
  }, 1000 / fps);
}

// ==============================================================================
function setPortfolio (id, arrowColor, arrowBgc) {
  // id передає ідентифікатор елементу класа .explorer-portfolio, який повинен містити наступну структуру:
  // <div class='explorer-portfolio__arrow left'></div>
  // <div class='explorer-portfolio__product-list'>
  //   <div class='explorer-portfolio__product-list__item'>1-й ел-т портфоліо</div>
  //     ........
  //   <div class='explorer-portfolio__product-list__item'>n-й ел-т портфоліо</div>
  // </div>
  // <div class='explorer-portfolio__arrow'></div>

  let productList = document.querySelector(`#${id} .explorer-portfolio__product-list`);
  let blockChain = document.querySelectorAll(`#${id} .explorer-portfolio__product-list__item`); // ланцюжок елементів портфоліо
  let maxProductNumber = blockChain.length; // кількість ел-тів портфоліо
  let left = document.querySelector(`#${id} .explorer-portfolio__arrow.left`);
  let right = document.querySelector(`#${id} .explorer-portfolio__arrow.right`);
  
  let currentProduct = 1; // поточний товар в слайдері товарів

  left.style.backgroundColor = arrowBgc; // колір стрілок
  left.style.color = arrowColor;
  right.style.backgroundColor = arrowBgc;
  right.style.color = arrowColor;

  function productRefresh(parent, blockChain, margin = 10) { // оновлення переліку товарів
  //parent - батьківський ел-т, який містить перелік товарів
  //blockChain - масив елементів-товарів
  //margin - сумарний лівий та правий маржин між товарами (дублюється в productShift)
      currentProduct = 1;
      let x = parent.getBoundingClientRect().width;
      let w = blockChain[0].getBoundingClientRect().width + margin;
      let n = Math.floor(x / w);
      let lm = x;
      if (n > 0) lm = (x - w * n) / (n + 1);
      let left = lm;
      blockChain.forEach((i)=>{
          i.style.left = left+'px';
          left += lm + w;
      })
  }

  function productShift(parent, blockChain, direction, margin = 10) { // зсув переліку товарів
    //parent - батьківський ел-т, який містить перелік товарів
    //blockChain - масив елементів-товарів
    //direction - напрямок зсуву анімації
    //margin - сумарний лівий та правий маржин між товарами (дублюється в productRefresh)
    if (currentProduct == 1 && direction == '+=') return;
    if (currentProduct == maxProductNumber && direction == '-=') return;
    currentProduct = direction == '+=' ? currentProduct - 1 : currentProduct + 1;
    let x = parent.getBoundingClientRect().width;
    let w = blockChain[0].getBoundingClientRect().width + margin;
    let n = Math.floor(x / w);
    let lm = x;
    if (n > 0) lm = (x - w * n) / (n + 1);
    blockChain.forEach((i)=>{
        $(i).animate({left: `${direction}${lm+w}`});
    });
  }

  right.addEventListener('click', (event)=>{ // зсув переліку товарів по кліку стрілки
    productShift(productList, blockChain, '-=');
  });

  left.addEventListener('click', (event)=>{ // зсув переліку товарів по кліку стрілки
    productShift(productList, blockChain, '+=');
  });

  right.addEventListener('mouseenter', (event)=>{ // анімація стрілки по наведенню
    if (currentProduct < maxProductNumber) {
        event.target.style.opacity = 1;
        $(event.target).animate({top: '+=5'}, 100).animate({top: '-=5'}, 100);;
    }
  });

  right.addEventListener('mouseleave', (event)=>{ // анімація стрілки по наведенню
    event.target.style.opacity = 0.7;
  });

  left.addEventListener('mouseenter', (event)=>{ // анімація стрілки по наведенню
    if (currentProduct > 1) {
        event.target.style.opacity = 1;
        $(event.target).animate({top: '+=5'}, 100).animate({top: '-=5'}, 100);;
    }
  });

  left.addEventListener('mouseleave', (event)=>{ // анімація стрілки по наведенню
    event.target.style.opacity = 0.7;
  });

  productRefresh(productList, blockChain); // вивід переліку товарів після завантаження сторінки
                
  window.onresize = ()=> { // оновлення переліку товарів після зміни розміру екрану
    productRefresh(productList, blockChain);
  }

}