<?php

//Theme側で有効化するとFrontに摘要されるCSS　 を有効化　文献上では　C
function mytheme_setup(){

add_theme_support( 'wp-block-styles' );

// 縦横比を維持したResponsiveを有効化するCSS style.min.cssに含まれている　文献上では　B
add_theme_support( 'responsive-embeds' );

// WPのEditor用CSSを有効化させる　更にEditor上に反映させるもの　文献上では E  
// Editorでも見た目がFrontと同一的になる
add_theme_support( 'editor-styles' );
add_editor_style( 'editor-style.css' );

// <head>内のPageのTitleを有効化する指定
add_theme_support('title-tag');

// link style script のHTML5対応を有効化
add_theme_support('html5',array(
    'style',
    'script'
));

// ICatch画像の機能を有効化  最TOP　home.php上に表示するもの
add_theme_support( 'post-thumbnails' );

// 全幅・幅広を有効化
add_theme_support( 'align-wide' );

// MenuのLocationを登録　WP管理画面 の外観→Menu　に反映される　→　'Navigation'　という表示がされる
register_nav_menus( array(
    'primary' => 'Navigation'
));



}

// after_setup_theme　に　対して　関数　mytheme_setup　を実行する　
add_action('after_setup_theme','mytheme_setup');

// Block　Style　独自指定
// 1つ目設定
register_block_style(
    // WP管理画面上の区別ID
    'core/image',
    array(
        'name' => 'mycard',
        'label' => 'Card型',
        'inline_style' =>
        '.is-style-mycard{
            padding:10px;
            border:solid 1px gray;
            box-shadow:5px 5px 5px gray;
        }',
    )
    
);

// 2つ目設定  楕円型　正円には　ならない
// 正円は・・・　　角丸　に　画像の設定　で　Thumbnail 指定をする
register_block_style(
    // WP管理画面上の区別ID
    'core/image',
    array(
        'name' => 'mycircle',
        'label' => 'Circle型',
        'inline_style' =>
        '.is-style-mycircle{
            border-radius:30%;
            width:100%;
        }',
    )

);


// 2列組をON　OFF　する用の設定
// この設定があるときのみ　2列組を　有効にするという、設定事項
// CommentOutで　2列組で無くすことも可能
// header.php内 PHPで別途設定している

// add_theme_support( 'mycols' );


// 自作　Theme関連CSS　自分で制作したTheme　style.css  文献上ではD
function mytheme_enqueue(){

    // GooglFontを読み込み
    wp_enqueue_style(
        'myfonts',
        'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&display=swap',
        array(),
        // ここは本来CashClearだがClearの必要が無いため　null
        null
    );


    // Dashiconsを読み込み  Icon設定用 既定の設定手法    
    wp_enqueue_style(
        'dashicons'
    );

    // ThemeのCSSを読み込み
    wp_enqueue_style(
        'mytheme_style',
        get_stylesheet_uri(),

        // WPのVirsionが変わらなくてもCSS読み直しをする用の設定　何もしないと既存のWPのversion情報のみCashが保存され新しい更新とならない
        // 1970年の時間を中心とした時間で管理して反映するようにする
        array(),
        filemtime(get_theme_file_path('style.css'))
    );

}
// 上の続き　wp_enqueue_scripts　に　対して　関数　mytheme_enqueue　を実行する　
add_action('wp_enqueue_scripts','mytheme_enqueue');


function mytheme_widgets(){
    register_sidebar(
        array(
            'id' => 'sidebar-1',
            'name' => 'Footer Menu',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
        )
     );
}
// 上の続き　widget_init　に　対して　関数　mytheme_widgets　を実行する　
add_action('widgets_init','mytheme_widgets');
