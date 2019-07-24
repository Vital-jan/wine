<?
    $product_list = array(
        array(
            'name'=>'Mukuzani',
            'img'=>'wine1.png',
            'alt'=>'Mukuzani Georgian wine by World Finest Wines',
            'year'=>'2017',
            'class'=>'dry red',
            'description'=>'Mukuzani wine is .... is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit.',
            'country_icon'=>'flag_georgia.png',
            'country_name'=>'Georgia',
            'grape'=>'',
            'region'=>'',
            'shugar'=>'3%',
            'spirit'=>'9%'
        ),
        array(
            'name'=>'Khvanchkara',
            'img'=>'wine1.png',
            'alt'=>'Khvanchkara Georgian wine by World Finest Wines',
            'year'=>'2016',
            'class'=>'dry red',
            'description'=>'Khvanchkara wine is .... is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit.',
            'country_icon'=>'flag_georgia.png',
            'country_name'=>'Georgia',
            'grape'=>'',
            'region'=>'',
            'shugar'=>'3%',
            'spirit'=>'9%'
        ),
        array(
            'name'=>'Tsinandali',
            'img'=>'wine1.png',
            'alt'=>'Tsinandali Georgian wine by World Finest Wines',
            'year'=>'2015',
            'class'=>'half-dry white',
            'description'=>'<p>Tsinandali wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Tsinandali wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Tsinandali wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p>',
            'country_icon'=>'flag_georgia.png',
            'country_name'=>'Georgia',
            'grape'=>'',
            'region'=>'',
            'shugar'=>'3%',
            'spirit'=>'9%'
        ),
        array(
            'name'=>'Saperavi',
            'img'=>'wine1.png',
            'alt'=>'Saperavi Georgian wine by World Finest Wines',
            'year'=>'2015',
            'class'=>'dry red',
            'description'=>'<p>Saperavi wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Saperavi wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Saperavi wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p>',
            'country_icon'=>'flag_georgia.png',
            'country_name'=>'Georgia',
            'grape'=>'',
            'region'=>'',
            'shugar'=>'3%',
            'spirit'=>'9%'
        ),
        array(
            'name'=>'Kindzmarauli',
            'img'=>'wine1.png',
            'alt'=>'Kindzmarauli Georgian wine by World Finest Wines',
            'year'=>'2015',
            'class'=>'half-sweet red',
            'description'=>'<p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p><p>Kindzmarauli wine is Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores dignissimos beatae dolorum eveniet ab nostrum placeat alias impedit provident harum.</p>',
            'country_icon'=>'flag_georgia.png',
            'country_name'=>'Georgia',
            'grape'=>'',
            'region'=>'',
            'shugar'=>'3%',
            'spirit'=>'9%'
        )
    );

    $portfolio="<div id='portfolio1'>";

    $counter = 1;
    foreach($product_list as $value) {
        $portfolio .="
        <div class='explorer-portfolio__product-list__item wine'>
            <img src='assets/img/product/{$value['img']}' alt='{$value['alt']}'>
            <h2 class='wine__name'> {$value['name']}</h2>
            <h2 class='wine__year'> {$value['year']}</h2>
            <h2 class='wine__class'>{$value['class']}</h2>
        </div>
        ";
        $portfolio .= "
        <div id = 'scroll{$counter}' class='explorer-portfolio__product-list__item__description wine-description'>
        {$value['description']}
        </div>
        ";

        $counter++;
    }
    

    $portfolio .= "</div>";
    ?>
