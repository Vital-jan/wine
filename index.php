<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="description" content="World’s Finest Wines - importer/wholesaler of Georgian wines.">
    <meta name='author' content='Vitalii Kolomiiets, Kyiv, Ukraine, vitaljan@gmail.com viber:+380632209770'>
    <title>World's Finest Wines</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/explorer.js"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/explorer.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Merienda|Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- font-family: 'Merienda', cursive;
    font-family: 'Source Sans Pro', sans-serif; -->
</head>


<?
    require_once "about.php";
    require_once "wines.php";
    require_once "portfolio.php";
    require_once "footer.php";

    $main_content = array ( // масив, що формує контент сайту
        // type = ["", "full-width", "full-width-center", "footer"]
        // "" - звичайний модуль, йому додається клас .main__module
        // "full-width" - модуль на повну ширину екрану, йому додається клас .main__module_full-width
        // "full-width" - модуль на повну ширину екрану відцентрований, йому додається клас .main__module_full-width .center
        // "footer" - розділ <footer>

        array("menu_item"=>"Home", "type"=>"full-width-center", "class"=>"", // блок полной ширины с центрированным текстом
        "header"=>"Welcome to the wonderful world of wines from the county of Georgia!", 
        "text"=>'', "img1"=>"", "img2"=>""),

        array("menu_item"=>"", "type"=>"full-width-center", "class"=>"", // блок полной ширины для слайдера
        "header"=>"", 
        "text"=>"<div id='slider'></div>", "img1"=>"", "img2"=>""),

        array("menu_item"=>"", "type"=>"", "class"=>"", 
        "header"=>"", 
        "text"=>'<p>Georgian wines have become a must-have for the world’s best restaurants and wine merchants. Georgian wines are now among the trendiest in the world.</p>
        <div class="read-more">
        <p>Georgia is the “Cradle of Wine” and is one of the oldest wine regions of the world. In Georgia there is evidence that wine has been made for more than 8,000 years. Georgia has some of the oldest and most distinct grape-growing terroirs on the planet, where they have cultivated not just vines, but a world-class wine culture. Georgia produces wines that are unlike anywhere else. Georgian grapes are unique, indigenous that often cannot be found elsewhere.   They present both unique flavors and aromas. Acid is a lot mellower and not as aggressive. Georgia boasts more than 500 varieties of indigenous grapes—nearly one-sixth of the world’s grape varieties—including endangered vines found nowhere else on Earth.</p>
        
        <p>Georgia is a small mountainous country in the area where Europe and Asia meet. Georgia is on the same latitude as Tuscany and has similar territorial conditions perfect for wine production.  A rich diversity of soil, climate, the angle at which the sun falls on the vineyards and the many indigenous grape varieties creates a huge variety of wine tastes and aromas.</p>
        
        <p>Gradually, Georgian wine is becoming more popular in the U.S. Take advantage and drink these wines. Be adventures with your palate. Drink different!  Are you ready for it?</p>
        </div>
        ', "img1"=>"", "img2"=>""),

        array("menu_item"=>"About us", "type"=>"", "class"=>"", 
        "header"=>"About us", 
        "text"=>$module_about, "img1"=>"assets/img/toast.jpg", "img2"=>""),

        array("menu_item"=>"Georgian Winemaking", "type"=>"", "class"=>"", 
        "header"=>"Georgian Winemaking",
        "text"=>$module_wines, "img1"=>"assets/img/barrel.jpg", "img2"=>""),

        array("menu_item"=>"Explore our wines", "type"=>"", "class"=>"",
        "header"=>"Explore our wines",
        "text"=>"All our wines are natural and organic.

        The rich, intriguing and seductive flavors of Georgian wines will impress even the most sophisticated wine lovers. Try our wine and let the quality and character of the Georgian grapes speak for themselves", "img1"=>"", "img2"=>""),

        array("menu_item"=>"", "type"=>"full-width-center", "class"=>"layer1", // блок полной ширины для портфолио
        "header"=>"",
        "text"=>$portfolio, "img1"=>"", "img2"=>""),

        array("menu_item"=>"Contact us", "type"=>"footer", "class"=>"",
        "header"=>"Our contacts:",
        "text"=>$footer, "img1"=>"", "img2"=>"")
    );
?>
<body>
    <img class='frame_top' src='assets/img/frame.png'>
    <nav>
        <img class='grape' src="assets/img/grape01.png" alt="">

        <div class="nav__logo"> <!-- блок логотип-->
            <img src="assets/img/logo.png" alt="wines of Georgia">
            <div class="nav__logo__text">
                <!-- <span>World's Finest Wines</span>
                <span>Wine is born, not made</span> -->
            </div>
        </div>

        <div class="nav__menu"> <!-- блок меню -->
        <?
            // створюємо головне меню
                $n = 0;
                foreach($main_content as $key=>$value) {
                    $id = ($value['type'] == 'footer') ? "footer" : "module{$n}";
                    $n++;
                    if ($value['menu_item'])
                    echo "
                    <span class='nav__elem' data-id='{$id}'>{$value['menu_item']}</span>
                    ";
                }
            // створюємо смарт-меню
                echo "
                    <div class='nav__smartmenu'>
                    <ul>
                    <li class='nav__smartmenu__close'><span id='nav-smart-menu-close'>&#10006;</span></li>
                    ";
                $n = 0;
                foreach($main_content as $key=>$value) {
                    $id = ($value['type'] == 'footer') ? "footer" : "module{$n}";
                    $n++;
                    if ($value['menu_item'])
                    echo "
                    <li class='nav__smartmenu__elem' data-id='{$id}'>
                    {$value['menu_item']}<br><hr>
                    </li>
                    ";
                }
                    echo "
                </ul>
                </div>
                ";

            ?>
        </div>
    </nav>

    <main>
        <div id="home-arrow" class='hidden-elem'></div>
        <?
        // створюємо розділи сайту
            $n = 0;
            foreach($main_content as $key=>$value) {
                if ($value['type'] == 'footer') continue;
                $id = "module{$n}";
                $class = "main__module";
                if ($value["type"] == 'full-width') $class .= ' main__module_full-width';
                if ($value["type"] == 'full-width-center') $class .= ' main__module_full-width center';
                if ($value['class']) $class .= ' '.$value['class'];

                $h12 = ($n == 0) ? 'h1' : 'h2';
                $sub = $value['menu_item'] ? '' : 'sub-';
                $header = $value['header'] ? "<{$h12} class='main__module__{$sub}header'>{$value['header']}</{$h12}>" : "";
                $img1 = $value['img1'] ? "<div class='main__module__content__img1'><img src='{$value['img1']}'></div>" : '';
                $img2 = $value['img2'] ? "<div class='main__module__content__img2'><img src='{$value['img2']}'></div>" : '';
                echo "
                <div class='{$class}' id='{$id}'>
                    {$header}
                    <div class='main__module__content'>
                        {$img1}
                        {$img2}
                        {$main_content[$n]['text']}
                    </div>
                </div>
                ";
                $n++;
            }
        ?>
        
    </main>

    <footer>
        <?
            foreach($main_content as $value) {
                if ($value['type'] == 'footer') {
                    echo "
                    <div id='footer'>
                        <h2 class='footer__header'>{$value['header']}</h2>
                        <div class='footer__content'>{$value['text']}</div>
                    </div>

                    <div class='footer-copyright'>
                        <hr>
                        <img src = 'assets/img/logo_small.png'>
                        We do not sell directly to the public.  Please find a retailer near you and ask about Georgian Wines.
                        <br><br>
                        All rights reserved.
                    </div>

        
                    ";
                }
            }
        ?>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", ()=>{

        let nav = document.querySelector('nav');
        let main = document.querySelector('main');
        let smartMenu = document.querySelector('.nav__smartmenu');
        let homeArrow = document.querySelector('#home-arrow');
        let homeArrowY = parseInt(getComputedStyle(homeArrow).bottom);
        let homeArrowVisible = false;
        let currentNavElement = document.querySelector('.nav__elem');

        document.querySelectorAll('.read-more').forEach((i)=>{ // створюємо кнопки "Read more" для всіх елементів з відповідним класом
            let btn = document.createElement('button');
            $(btn).insertAfter(i);
            btn.classList.add('read-more-button');
            btn.setAttribute('data-readmore','true');
        })

        document.addEventListener('click', (event)=>{ // клік по Read more - розгортання
            if (event.target.dataset.readmore) {
                $(event.target.previousElementSibling).animate({maxHeight: 100000}, 1000);
                event.target.style.display = 'none';
            }
        })

        let navButton = document.createElement('span'); // створюємо кнопку меню-смартфон
        navButton.innerHTML = "&#9776;";
        navButton.classList.add('nav__button');
        nav.appendChild(navButton);
        navButton.addEventListener('click', (event)=>{
            event.stopPropagation();
            navButton.classList.add('hidden');
            $(smartMenu).show(100);
            smartMenu.classList.add('nav__smartmenu_active');
            })

        function moduleView(id, navItem) { // скролить вікно та показує обраний в меню модуль сайту
            let target = document.querySelector(`#${id}`);
            let y1 = target.getBoundingClientRect().y;
            let y2 = parseInt(getComputedStyle(nav).height) + 100;
            let dy = y2 - y1;
            let delay = 1000/Math.abs(dy);
            let steps = 40;
            let n = 1;
            let offset = 0;
            let scrolled = false;
            let interval = setInterval (()=>{
                if (n >= steps) {
                    clearInterval(interval);
                    if (navItem) setTimeout(()=>{navItem.classList.add('nav__elem_active')}, 500);
                    if (!scrolled) $(`#${id}`).fadeTo(100, .5).fadeTo(200, 1);
                    return;
                }
                n++;
                offset = target.getBoundingClientRect().y;
                window.scrollBy(0, -dy/steps);
                offset -= target.getBoundingClientRect().y;
                if (offset != 0) scrolled = true;
                if (offset == 0) n = steps;
            }, 10);
        }

        nav.addEventListener('click',(event)=>{ // обробник кліку панелі навігації
            if (event.target.dataset.id) {
                if (currentNavElement) currentNavElement.classList.remove('nav__elem_active');
                currentNavElement = event.target;
                moduleView(event.target.dataset.id, currentNavElement);
        }
        });

        smartMenu.addEventListener('mouseleave', (event)=>{ // закриття smartmenu
            $(smartMenu).hide(100);
            smartMenu.classList.remove('nav__smartmenu_active');
        });

        smartMenu.addEventListener('click', (event)=>{ // клік по ел-ту smartmenu
            event.stopPropagation();
            if (event.target.dataset.id) {
                $(smartMenu).hide(100);
                smartMenu.classList.remove('nav__smartmenu_active');
                moduleView(event.target.dataset.id);
            }
            if (event.target.id == 'nav-smart-menu-close') {
                $(smartMenu).hide(100);
                smartMenu.classList.remove('nav__smartmenu_active');
            }
        });

        homeArrow.addEventListener('mouseenter', (event)=>{ // анімація кнопки "додому"
            $(event.target).animate({top: '+=5'}, 100).animate({top: '-=5'}, 100);
        })

        homeArrow.addEventListener('click', ()=>{ // клік кнопки "додому" - повернення до 1-го ел-ту класу main__module
            currentNavElement.classList.remove('nav__elem_active');
            currentNavElement = document.querySelector('.nav__elem');
            moduleView(document.querySelector('.main__module').getAttribute('id'), currentNavElement);
        })

// ---------------------------------------------------------------------------------- кінець шаблону сайту

let windAnimation = false; // чи відбувається анімація в реальному часі

function wind (maxX, maxY, delay){ // анімація картинки виноградна лоза
    if (windAnimation) return;

    let el = document.querySelector('.frame_top');
    let startPosition = el.getBoundingClientRect().y;
    let nav = document.querySelector('nav');

    windAnimation = true;
    let fps = 30;
    let dx, dy;
    let iteration = delay / 1000 * fps;
    dx = maxX / iteration;
    dy = maxY / iteration;
    let time = delay / fps;
    let i = 0;
    let x = 0;
    let y = 0;

    let interval = setInterval(()=>{
        i++;
        if (i >= iteration) {
            clearInterval(interval);
            i = 0;
            interval = setInterval(()=>{
            i++;
            
            if (i >= iteration) {
                clearInterval(interval);
                windAnimation = false;
                el.style.top = nav.getBoundingClientRect().height * 0.8 + 'px';
                return;
            }
            el.style.transform = `skew(${x}deg, ${y}deg)`;
            el.style.top = `${startPosition+y*3}px`;
            x -= dx;
            y -= dy;
        }, time);

        }
        el.style.transform = `skew(${x}deg, ${y}deg)`;
        el.style.top = `${startPosition+y*3}px`;
        x += dx;
        y += dy;
    }, time);

}

setSlider(3, 'assets/img/slider/', 'img', 3, 0.5, 'slider', [], false, false);

setPortfolio('portfolio1', 'white', 'rgb(65, 5, 5)');
// --------------------------------------------------------------

window.onscroll = ()=>{
            wind(1, 3, 800); // анімація картинки виноградна лоза

            if (window.pageYOffset > 300) {// показати/сховати кнопку "додому"
                if (!homeArrowVisible) 
                {
                    homeArrowVisible = true;
                    homeArrow.classList.remove('hidden-elem')
                    homeArrow.style.bottom = homeArrowY + 'px';
                    $(homeArrow).animate({bottom: 25}, 1000);
                }
            } 
            else 
                {
                    if (homeArrowVisible) 
                    {
                        homeArrow.classList.add('hidden-elem');
                        homeArrowVisible = false;
                    }
                };
            if (currentNavElement) currentNavElement.classList.remove('nav__elem_active');

        }

        }); // DOMContentLoaded
    </script>
</body>
</html>