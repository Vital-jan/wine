<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>World's Finest Wines</title>
    <meta name="description" content="World's Finest Wines. Wine is born, not made">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/slider.js"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/expand.css">
    <link rel="stylesheet" href="assets/css/slider.css">
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

    $main_content = array ( // контент сайту
        array("menu_item"=>"Home", "id"=>"home", "class"=>"", 
        "header"=>"Home header text ..... ", 
        "text"=>'Home text.... Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa eligendi dignissimos obcaecati quibusdam sed odit porro, nobis perferendis praesentium iusto vel similique pariatur cumque reprehenderit error nesciunt optio dolore debitis dolores ut iure nihil totam. Dolor et facere est suscipit.', "img1"=>"", "img2"=>""),

        array("menu_item"=>"About us", "id"=>"about", "class"=>"", 
        "header"=>"Welcome to the wonderful world of Georgian wines! We have created our company “World’s Finest Wines” with the aim of publicizing delicious, elegant and genuinely unique wines from the country of Georgia.", 
        "text"=>$module_about, "img1"=>"", "img2"=>""),

        array("menu_item"=>"Georgian Winemaking", "id"=>"gwines", "class"=>"", 
        "header"=>"Georgian Winemaking",
        "text"=>$module_wines, "img1"=>"", "img2"=>""),

        array("menu_item"=>"Our portfolio", "id"=>"products", "class"=>"main__module__portfolio",
        "header"=>"Our portfolio",
        "text"=>$portfolio, "img1"=>"", "img2"=>""),

        array("menu_item"=>"Contact us", "id"=>"contacts", "class"=>"main__module__footer",
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
                    $id = ($value['id'] == '' ? "module{$n}" : "{$value["id"]}");
                    $n++;
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
                    $id = ($value['id'] == '' ? "module{$n}" : "{$value["id"]}");
                    $n++;
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
                $attr = $value['id'] == '' ? "module{$n}" : "{$value['id']}";
                $header = ($n == 0) ? 'h1' : 'h2';
                echo "
                <div class='main__module {$value['class']}' id='{$attr}'>
                    <{$header} class='main__module__header'>{$main_content[$n]['header']}</{$header}>
                    <div class='main__module__text'>{$main_content[$n]['text']}</div>
                </div>
                ";
                $n++;
            }
        ?>
        
    </main>

    <footer>
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

        document.querySelectorAll('.read-more').forEach((i)=>{ // створюємо кнопки "Read more" після всіх елементів з відповідним класом
            let btn = document.createElement('button');
            $(btn).insertAfter(i);
            btn.classList.add('read-more-button');
            btn.setAttribute('data-readmore','true');
        })

        document.addEventListener('click', (event)=>{
            if (event.target.dataset.readmore) {
                $(event.target.previousElementSibling).animate({maxHeight: 10000}, 1000);
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
// ---------------------------------------------------------------------------------- шаблон
let windAnimation = false;
        function wind (maxX, maxY, delay){ // анімація картинки виноградна лоза
            if (windAnimation) return;

            let el = document.querySelector('.frame_top');
            let startPosition = el.getBoundingClientRect().y;

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

let slider = document.createElement('div'); // формуємо слайдер
document.querySelector('main').insertBefore(slider, document.querySelector('#about'));
slider.setAttribute('id', 'slider');
setSlider(5, 'assets/img/slider/', 'img', 3, 0.5, 'slider', 500, 300, ['','','','','']);

function productRefresh(parent, blockChain) {
    let x = parent.getBoundingClientRect().width;
    let w = blockChain[0].getBoundingClientRect().width;
    let n = Math.floor(x / w);
    let lm = x;
    if (n > 0) lm = (x - w * n) / (n + 1) - n;
    blockChain.forEach((i)=>{
        i.style.marginLeft = lm+'px';
    })
}
function productShift(parent, blockChain) {
    let x = parent.getBoundingClientRect().width;
    let w = blockChain[0].getBoundingClientRect().width;
    let n = Math.floor(x / w);
    let lm = x;
    if (n > 0) lm = (x - w * n) / (n + 1) - n;
    blockChain.forEach((i)=>{
        $(i).animate({left: `-=${lm+w}`});
        i.style.display='inline-block';
        i.style.visibility='visible';
        console.log(i.style)
    });
}

document.querySelector('#product-right-arrow').addEventListener('click', (event)=>{
    productShift(document.querySelector('.main__module_portfolio__content__product'),
                document.querySelectorAll('.main__module_portfolio__content__product__item'));
});

productRefresh(document.querySelector('.main__module_portfolio__content__product'),
                document.querySelectorAll('.main__module_portfolio__content__product__item'));

window.onresize = ()=> {
    productRefresh(document.querySelector('.main__module_portfolio__content__product'),
                document.querySelectorAll('.main__module_portfolio__content__product__item'));
}

window.onscroll = ()=>{
            wind(1, 3, 800); // анімація картинки виноградна лоза

            if (window.pageYOffset > 300) {// показати/сховати кнопку "додому"
                if (!homeArrowVisible) 
                {
                    homeArrowVisible = true;
                    homeArrow.classList.remove('hidden-elem')
                    homeArrow.style.bottom = homeArrowY + 'px';
                    $(homeArrow).animate({bottom: 40}, 1000);
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