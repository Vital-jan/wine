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
  height,
  title = [],
  arrowsVisible = false,
  circlesVisible = false) {
  // аргументы: ==========================================================
  // слайдер будет растянут по всей ширине родителя
  // высота - авто, если не задан аргумент height. В противном случае, низ изображение будет обрезан по высоте height.
  // Пример: setSlider(4, 'assets/img/slider/', 'img', 3, 0.5, 'slider');
  // --------------------------------------------
  // max - к-во изображений
  // path - папка с изображениями для слайдера
  // prefix - префикс имени файла изображения
  // delay - время показа изображения в секундах
  // fade - время набора 100% непрозрачности (от 0 до 1 delay)
  // sliderId - идентификатор контейнера-родителя;
  // height - высота слайдера. Нижняя часть изображения будет обрезана. Если не задано - auto
  // title - подписи к картинкам (массив). если значение не указано, не отображается.
  // arrowsVisible, circlesVisible - наличие стрелок и кружочков
  // ----------------------------------------------------

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
  if (height) slider.style.height = height + 'px';

  // создаем и стилизуем графический контент
  let img = document.createElement('img');
  slider.appendChild(img);
  img.setAttribute('src', `${path}${prefix}${counter}.jpg`);

  let sliderWidth = slider.getBoundingClientRect().width;

  const buttonMargin = 5; // отступ между кнопками
  let buttonWidth = sliderWidth * 0.03;
  let buttonContainerWidth = 0;

  if (arrowsVisible) buttonContainerWidth += buttonWidth * max + buttonMargin * (max - 1); // вычисляем размеры кнопок и их контейнера
  if (circlesVisible) buttonContainerWidth += buttonWidth * 2 + buttonMargin;
  if (buttonContainerWidth > sliderWidth * 0.8) {
    buttonContainerWidth = sliderWidth * 0.8;
    buttonWidth = buttonContainerWidth / (max + 2 + buttonMargin);
  }

  // обработчики для img (пауза в прокрутке)
  img.onmouseenter = () => {
    paused = true;
  };    
  img.onmouseleave = () => {
    paused = false;
  };    

  // создаем подпись под слайдером
  let ttl;
  if (title) {
    ttl = document.createElement('div');
    slider.appendChild(ttl);
    ttl.classList.add('explorer-slider__title');
  }

  // создаем и стилизуем контейнер для элементов-кружочков и стрелок
  let buttonContainer;
  if (circlesVisible || arrowsVisible) {
    buttonContainer = document.createElement('div');
    buttonContainer.classList = 'button-container';
    slider.appendChild(buttonContainer);
    buttonContainer.style.width = buttonContainerWidth + 'px';

    buttonContainer.addEventListener('click', function(event) {
      if (!isNaN(parseIntBack(event.target.id))) {
        prevCounter = counter;
        counter = parseIntBack(event.target.id);
        refresh();
        timeNext = 0;
      }  
    });  
  }  

  // добавляем элементы стрелка влево-вправо
  let arrow = [];
  if (arrowsVisible) {
    for (n = 0; n < 2; n++) {
      arrow[n] = document.createElement('div');
      arrow[n].classList.add('arrow');
      arrow[n].style.width = 0;
      arrow[n].style.height = 0;
      arrow[n].style.borderWidth = `${buttonWidth / 2}px`; // отрисовка стрелки
      arrow[n].style.left = `${buttonWidth / 2 * (n * 2 - 1)}px`; // отрисовка стрелки
      buttonContainer.appendChild(arrow[n]);
    }
    arrow[0].style.transform = 'rotate(180deg)'; // поворачиваем левую стрелку влево
    arrow[0].style.marginRight = buttonMargin + 'px';// задаем margin
  }
  
  // обработчики клика по стрелкам
    if (arrowsVisible) {
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
  }

  // создаем, добавляем и стилизуем элементы-кружочки
  if (circlesVisible) {
    for (var n = 1; n <= max; n++) {
      var el = document.createElement('div');
      buttonContainer.insertBefore(el, arrow[1]);
      el.classList = 'circle';
      el.id = `${sliderId}-circle${n}`;
      el.style.width = `${buttonWidth}px`;
      el.style.height = `${buttonWidth}px`;
      el.style.borderWidth = `${Math.round(buttonWidth / 4)}px`;
      el.style.marginRight = buttonMargin + 'px';
    }
  }

  function refresh(arrowVisible){

    img.setAttribute('src', `${path}${prefix}${counter}.jpg`); // отрисовка изображения

    if (title) {
      if (title[counter - 1]) {
        ttl.innerHTML = title[counter - 1];
      } else {ttl.innerHTML = ''};
    }

    if (prevCounter != 0) {
      let elem = document.querySelector(`#${sliderId}-circle${prevCounter}`); // стираем предыдущий кружочек
      if (elem) elem.style.backgroundColor = 'white';
    }

    elem = document.querySelector(`#${sliderId}-circle${counter}`); // рисуем текущий кружочек
    if (elem) elem.style.backgroundColor = 'black';

    if (arrowsVisible) {
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

  }

  refresh(arrowsVisible);

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
    if (ttl) ttl.style.opacity = opacity;
  }, 1000 / fps);
}

// ==============================================================================
function setPortfolio (id, arrowColor, arrowBgc, width = 300, minMargin = 10, height = 400) {

  // id передає ідентифікатор елементу без класу, який повинен містити елементи портфоліо.
  // кожен з елементів портфоліо повинен бути класу .explorer-portfolio__product-list__item.
  // <div id="portfolio1">
  //   <div class='explorer-portfolio__product-list__item'>1-й ел-т портфоліо</div>
  //   <div class='explorer-portfolio__product-list__item__description wine-description'>1-й ел-т портфоліо, зворотній бік </div>
  //     ........
  //   <div class='explorer-portfolio__product-list__item'>n-й ел-т портфоліо</div>
  //   <div class='explorer-portfolio__product-list__item__description wine-description'>n-й ел-т портфоліо, зворотній бік </div>
  // </div>
  // setPortfolio('portfolio1', 'red', 'white')
  // width, minMargin, height - ширина, мінімальний margin, висота ел-тів портфоліо

  let parent = document.querySelector(`#${id}`);
  parent.classList.add('explorer-portfolio');
  parent.style.height = height + 'px';
  let parentHTML = parent.innerHTML;
  parent.innerHTML = `
    <div class='explorer-portfolio__arrow left'></div>
    <div class='explorer-portfolio__product-list'>
        ${parentHTML}
    </div>
    <div class='explorer-portfolio__arrow right'></div>
  `;

  let productList = document.querySelector(`#${id} .explorer-portfolio__product-list`); // блок з переліком ел-тів портфоліо

  let blockChain = document.querySelectorAll(`#${id} .explorer-portfolio__product-list__item`); // ланцюжок елементів портфоліо

  let maxProductNumber = blockChain.length; // кількість ел-тів портфоліо
  let currentProductNumber = 1; // поточна кількість видимих ел-тів
  
  let currentProduct = 1; // поточний ел-т портфоліо
  let openElement = null; // розгорнутий ел-т портфоліо
  
  let productWidth; // поточна ширина ел-ту портфоліо
  let margin = minMargin; // поточний margin


  const left = document.querySelector(`#${id} .explorer-portfolio__arrow.left`); // стрілки вліво-право
  const right = document.querySelector(`#${id} .explorer-portfolio__arrow.right`);

  left.style.backgroundColor = arrowBgc; // колір стрілок
  left.style.color = arrowColor;
  right.style.backgroundColor = arrowBgc;
  right.style.color = arrowColor;

  // ------------------------------------------------------------------------------------
  function productRefresh() { // оновлення переліку товарів
  
  currentProduct = 1; // скидаємо вказівник поточного ел-ту

  productListWidth = productList.getBoundingClientRect().width; // визначення поточної ширини батьківського ел.
  productWidth = width; // скидання ширини ел-тів
  margin = minMargin; // скидання значення margin
  currentProductNumber = Math.floor(productListWidth / (productWidth + margin) ); // скільки ел-тів вміщується на екрані
  currentProductNumber = currentProductNumber > maxProductNumber ? maxProductNumber : currentProductNumber;
  currentProductNumber = currentProductNumber < 1 ? 1 : currentProductNumber;
  
  if (productWidth + margin >= productListWidth) margin = 5; // вкладений елемент + margin ширший батьківського
  if (productWidth >= productListWidth) productWidth = productListWidth * 0.95; // вкладений елемент без margin ширший батьківського
  
  // currentProductNumber = Math.floor(productListWidth / (productWidth + margin) );
  if (productWidth < 0) return;
  
  let next; // елемент "зворотній бік" елементу портфоліо
  
  blockChain.forEach((i)=>{ // привласнення значень ширини блоків
    i.style.width = productWidth + 'px';
    next = i.nextElementSibling;
    if (next.classList.contains('explorer-portfolio__product-list__item__description')) next.style.width = productWidth + 'px';
    
  });
  
  let field = productListWidth - (productWidth + margin) * currentProductNumber; // додатковий margin якщо батьківський ел-т ширший, ніж треба для розміщення усіх ел-тів
  field = field < 0 ? 0 : field;
  margin += field / currentProductNumber;
  
  if (currentProductNumber < maxProductNumber) { // видимість стрілок вліво-право якщо всі елементі не вміщуються
    if (currentProduct > 1) {left.style.visibility = 'visible'} else left.style.visibility = 'hidden';
    right.style.visibility = 'visible';
  } else {
    left.style.visibility = 'hidden';
    right.style.visibility = 'hidden';
  }
  let shift = productWidth + margin; // вирахування координат елементів портфоліо

  let leftPos = margin / 2; // привласнення координат елементів портфоліо
  
  blockChain.forEach((i)=>{
      i.style.left = leftPos + 'px';
      next = i.nextElementSibling;
      if (next.classList.contains('explorer-portfolio__product-list__item__description')) next.style.left = leftPos + 'px'; // зворотній бік елементу
  
      leftPos += shift;
  })
}

//----------------------------------------------------------------------------------------------------------------------------------
  function productShift(direction) { // зсув переліку товарів
    //direction - напрямок зсуву анімації

    currentProduct = direction == '+=' ? currentProduct - 1 : currentProduct + 1; // змінюємо значення вказівника поточного ел-ту

    if (currentProduct + currentProductNumber > maxProductNumber) {right.style.visibility = 'hidden'} else right.style.visibility='visible';
    if (currentProduct <= 1) {left.style.visibility = 'hidden'} else left.style.visibility='visible';
  
    let shift = productWidth + margin;

    let next;
    blockChain.forEach((i)=>{
        $(i).animate({left: `${direction}${shift}`});
        next = i.nextElementSibling;
        if (next.classList.contains('explorer-portfolio__product-list__item__description')) $(next).animate({left: `${direction}${shift}`});
    });
  } // productShift -----------------------------------------------------------------------------

  right.addEventListener('click', (event)=>{ // зсув переліку товарів по кліку стрілки
    productShift('-=');
  });
  
  left.addEventListener('click', (event)=>{ // зсув переліку товарів по кліку стрілки
    productShift('+=');
  });

  right.addEventListener('mouseenter', (event)=>{ // анімація стрілки по наведенню
    if (currentProduct < maxProductNumber) {
        $(event.target).animate({top: '+=5'}, 100).animate({top: '-=5'}, 100);;
    }
  });

  left.addEventListener('mouseenter', (event)=>{ // анімація стрілки по наведенню
    if (currentProduct > 1) {
        $(event.target).animate({top: '+=5'}, 100).animate({top: '-=5'}, 100);;
    }
  });

  productRefresh(); // первинний вивід переліку елементів
                
  window.onresize = ()=> { // оновлення переліку елементів після зміни розміру екрану
    productRefresh();
  }

  // ---------------------------------------------------------------------------------
  function rotate (el, back) { // повертання елементів портфоліо
      if (!el || !back) return; // якщо відсутній один з елементів

      let el2Scroll = back.querySelector('.explorer-scroll__block'); // Знаходимо елемент зі скроллом
      let el2ScrollArrow = back.querySelector('.arrow_top'); // знаходимо ел-т стрілка вгору
      let top = 0;
      if (el2ScrollArrow) top = el2ScrollArrow.style.height;
      if (el2Scroll) el2Scroll.style.top = top; // початкове значення скролу після відображення

      let w = 1;
      let interval = setInterval(()=>{
        if (w <= 0) {
          clearInterval(interval);
          el.classList.toggle('explorer-portfolio__product-list__item_hidden');
          back.classList.toggle('explorer-portfolio__product-list__item_visible');
          el.classList.toggle('explorer-portfolio__product-list__item_visible');
          back.classList.toggle('explorer-portfolio__product-list__item_hidden');
          w = 0;
          interval = setInterval(()=>{
            if (w >= 1) clearInterval(interval);
            back.style.transform = `scaleX(${w})`;
            w += 0.05;
          }, 10)
        }

        el.style.transform = `scaleX(${w})`;
        w -= 0.05;
        
      }, 10)
    }; // ------------------  rotate

  productList.addEventListener('click', (event)=> {// обробник кліку на списку елементів портфоліо
    let back;
    let el = event.target.closest('.explorer-portfolio__product-list__item');
    if (el) {
      if (openElement) rotate(openElement, openElement.previousElementSibling);
      back = el.nextElementSibling;
      openElement = back;
    } 
    else {
      el = event.target.closest('.explorer-portfolio__product-list__item__description');
      if (!el) return;
      back = el.previousElementSibling;
      openElement = null;
    }
    
    rotate (el, back);
  });

  parent.addEventListener ('click', (event)=>{ // обробник кліку по стрілках на предмет згортання розгорнутого ел-та
    if (event.target == left || event.target == right) {
      if (openElement) {
        rotate(openElement, openElement.previousElementSibling);
        openElement = null;
      }
    }
  });

  } // setPortfolio

  // ==========================================================================================================================
  function setScroll(id, arrowHeight = 30, background = null, arrowColor = 0, step = null, duration = 500, buttonLayer = 2) {
  // ==========================================================================================================================
    // id - ідентифікатор елементу, зміст якого повинен скролитись
    // arrowHeight - висота едементів стрілок
    // background - значення відповідної властивості css (якщо порожній, використовується фон батьківського контейнеру)
    // arrowColor - колір стрілок
    // step - крок скролінгу на 1 клік в px
    // duration - тривалість скролінгу на step px
    // buttonLayer - властивість css z-index для кнопок-стрілок
    // на сенсорних екранах скроллінг відбувається по click, на desktop - наведення.
    // якщо весь контент вміщується в контейнер, кнопки не відображаються та ніяких дій не відбувається.

    let el = document.querySelector(`#${id}`); // елемент, який мусить скролитись
    if (!el) return;

    let scrolling = false; // чи відбувається скрол-анімація
    let noScroll = false; // заборона скролінгу по наведенню для смартфона (смартфон генерує mouseover+click)

    el.classList.add("explorer-scroll"); // додаєм клас
    let html = el.innerHTML; // додаєм вкладені ел-ти
    el.innerHTML = `  
        <div class='explorer-scroll__block'>${html}</div>
        `;

    let overflow = el.scrollHeight - el.clientHeight; // розмір прокрутки
    if (overflow <= 0)  return;
    
    // додаєм стрілки
    el.innerHTML += `
      <div class='explorer-scroll__arrow arrow_top'><span>&#10148;</span></div>
      <div class='explorer-scroll__arrow arrow_bottom'><span>&#10148;</span></div>`;
    
    let up = document.querySelector(`#${id} .arrow_top`); // стрілки
    let down = document.querySelector(`#${id} .arrow_bottom`);
    let scroll = document.querySelector(`#${id} .explorer-scroll__block`); // блок, який переміщується
    if (!step) step = el.getBoundingClientRect().height / 3;

    if (!background) { // встановлюємо фон кнопок
      up.style.background = getComputedStyle(el).background;
      down.style.background = getComputedStyle(el).background;
    }

    up.style.height = arrowHeight + 'px'; // стилізуємо кнопки
    down.style.height = arrowHeight + 'px';
    up.style.color = arrowColor;
    down.style.color = arrowColor;
    up.style.zIndex = buttonLayer;
    down.style.zIndex = buttonLayer;

    scroll.style.top = arrowHeight + 'px';

  // обробники стрілок
    up.addEventListener('mouseover', (event)=>{
      if (noScroll){
        noScroll = false;
        return;
      }

      event.stopPropagation();
      if (parseInt(scroll.style.top) >= arrowHeight) return;

      scrolling = true;
      down.style.opacity = 1;
      down.style.cursor = 'pointer';

      $(scroll).animate({top: arrowHeight}, overflow * 10, ()=>{
        scrolling = false;
        up.style.opacity = .5;
        up.style.cursor = 'default';
      });
    });

    up.addEventListener('mouseout', (event)=>{
      if (scrolling) $(scroll).stop();
      scrolling = false;
    });

    up.addEventListener('click', (event)=>{
      event.stopPropagation();
    });

    up.addEventListener('touchstart', (event)=>{
      event.stopPropagation();
      noScroll = true;
      if (scrolling) return;

      if (parseInt(scroll.style.top) < arrowHeight) {

          $(scroll).animate({top: `+=${step}px`}, duration);
          down.style.opacity = 1;
          down.style.cursor = 'pointer';
      }
      else {
          $(scroll).animate({top: '+=10px'}, 100).animate({top: '-=10px'}, 100);
          up.style.opacity = .5;
          up.style.cursor = 'default';
      }
    })
    
    down.addEventListener('mouseover', (event)=>{
      if (noScroll){
        noScroll = false;
        return;
      }
      event.stopPropagation();
      if (parseInt(scroll.style.top) <= -(overflow + arrowHeight)) return;

      scrolling = true;
      up.style.opacity = 1;
      up.style.cursor = 'pointer';

      $(scroll).animate({top: `-=${overflow + arrowHeight * 2 + parseInt(scroll.style.top)}px`}, overflow * 10, ()=>{
        scrolling = false;
        down.style.opacity = .5;
        down.style.cursor = 'default';
      });
    });

    down.addEventListener('mouseout', (event)=>{
      if (scrolling) $(scroll).stop();
      scrolling = false;
    });
    
    down.addEventListener('click', (event)=>{
      event.stopPropagation();
    });

    down.addEventListener('touchstart', (event)=>{
      noScroll = true;
      event.stopPropagation();
      if (scrolling) return;

        if (parseInt(scroll.style.top) > -overflow)
        {
            $(scroll).animate({top: `-=${step}px`}, duration);
            up.style.opacity = 1;
            up.style.cursor = 'pointer';
        }
        else {
            $(scroll).animate({top: '-=10px'}, 100).animate({top: '+=10px'}, 100);
            down.style.opacity = .5;
            down.style.cursor = 'default';
        }
    })
}
