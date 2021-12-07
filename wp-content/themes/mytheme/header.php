<!-- Header　Start -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- WP用　Meta指定 　SNS用-->
    <?php if( is_single() ): ?>
        <!-- Page　Site名出力 -->
        <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" >
        <!-- Page　言語種類指定出力 -->
        <meta property="og:locale" content="ja_JP" >
        <!-- Page　種類の出力 -->
        <meta property="og:type" content="article" >
        <!-- Page　Title出力 -->
        <meta property="og:title" content="<?php the_title(); ?>" >
        <!-- Page　URL -->
        <meta property="og:url" content="<?php the_permalink(); ?>" >
        <!-- 外　escを掛けて出力、　内　概要に含まれるHTMLを除去、　内々　WP管理画面内で設定しているPage概要を出力 -->
        <meta property="og:description" content="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt() ) ); ?>" >


        <!-- SNSに表示する画像関連 property と　esc の綴り-->
        <?php if(has_post_thumbnail()): ?>
        <?php $myimg = get_post_thumbnail_id(); ?>
        <meta property="og:image" content="<?php echo esc_url( wp_get_attachment_url($myimg) ); ?>">
        <meta property="og:image:width" content="<?php echo esc_attr( wp_get_attachment_metadata($myimg)['width'] ); ?>">
        <meta property="og:image:height" content="<?php echo esc_attr( wp_get_attachment_metadata($myimg)['height'] ); ?>">
        <?php endif; ?>


        <!-- TWとFBの設定 NET上に上がっていないと反映確認出来ない-->

        <!-- TW -->
        <!-- 反映確認用　IDが必要　Accountも必須
        https://cards-dev.twitter.com/validator
        -->
        <meta name="twitter:card" content="summary_large_image">


        <!-- FB -->
        <!-- 反映確認用　IDが必要 Accountも必須　2021年現在　会社が変わった
        https://developers.facebook.com/?locale=ja_JP
        　 -->
        <!-- 参考
        https://media.next-stage.biz/facebook/facebook-for-developers.php
        -->
        <meta property="fb:app_id" content="XXXXXXXXXXXXXX">


    <?php endif; ?>







<!-- 頭の定型 Gootenberg用のCSS等読み取り用-->
<?php wp_head(); ?>
</head>


<!-- 記事Pageを区別するClass　 -->
<body <?php body_class(); ?>>

<!-- 体の定型 -->
<?php wp_body_open(); ?>


<!-- Headerの追加 header Tagで-->
<!-- Class　mycontainer は別で指定している横幅のCSSを摘要するため　2つ目として指定 -->
<header class="myhead mycontainer" >

<!-- WP　のEditor　で　幅広の指定の場合・・・ 発生するClass　alignを設定　その場合の　Tag付け　→CSS　Flexが解除されるためそちらも 親の配下に子要素　＞　指定する-->
<div class="alignwide">

    <!-- 無害化して最低限で出力させている -->
    <a href="<?php echo esc_url( home_url('/') ); ?>">
    <?php bloginfo( 'name' ) ?>
    </a>

    <!-- Siteの説明を表示する pTagで-->
    <p><?php bloginfo( 'description' ); ?></p>

</div>


</header>

<!-- Header　END -->


<!-- Header 直下に　Nav Menu　を配置 -->
<!-- function.php で設定したID　をここで指定して区別している -->
<!-- ここで　CSS　用に　<nav> class を付して　装飾出来るようにしている -->
<?php if( has_nav_menu( 'primary' )): ?>

    <nav class="mynav">
    
    <!-- 全体指定Class -->
    <div class="mycontainer">
        <!-- 幅広指定Class -->
        <div class="alignwide">

            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                )
            );
            ?>

        </div>
        <!-- alignwide　END -->
    </div>
    <!-- mycontainer END-->

    </nav>
    
    

<?php endif; ?>


<!-- 2列組みにするための　div増やし　header内では頭の<>のみ　閉じTag　は　sidebar.php -->
<!-- もし、～の場合は・という指定　　の文言
if文　初段は　:　を付す。　endif　の末尾は　;　とする 
front_page　で　なく　!
&&　で　且つ　として
functions.php 内に　最近=cureent に add_theme_support('mycols'); が ある場合にのみ、2列組を設定する　という仕組み -->
<div
<?php if( !is_front_page() && current_theme_supports('mycols') ): ?>
class="mycols"
<?php endif; ?>
>
<div class="mycontent">