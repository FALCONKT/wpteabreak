<!-- Header　Start -->

<?php get_header(); ?>

<!-- Header　END -->


<!-- index.php に関して　mycontainerのClassを流用する →　左右幅が摘要される-->
<main class='mycontainer'>

    <!-- WP　のEditor　で　幅広の指定の場合・・・ 発生するClass　alignを設定　その場合の　Tag付け-->
    <div class="alignwide">

        <!-- home.php作成時　新規で見出しのdivを設定 -->
        <div class="myposthead">
            <h1>最新情報</h1>
            <p>RECENT</p>

  
        </div>

        <!-- 記事一覧を2列にするClass -->
        <div class="mypostlist">
        
            <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <!--条件処理 記事の数を-->

            <article <?php post_class();?> >
                
                <!-- 画像と見出しにLinkを設定 -->
                <a href="<?php the_permalink(); ?>">
                
                <!-- ICatch画像表示用 もしthumbnailを持っていたら・・・:= Coron　そうでなければ・・・終わる;=SemiCoron　-->
                <?php if( has_post_thumbnail() ): ?>
                <figure>
                    <?php the_post_thumbnail(); ?>
                </figure>
                <?php endif; ?>


                <!-- 記事のTitleのみを連続表示する -->
                <h2><?php the_title(); ?></h2>
                
                </a>

            </article>
            <!-- →　連続表記される数はWP側で自由に設定出来る -->

            <?php endwhile; endif; ?>
            <!--条件処理 終了-->

        </div>  

    <!-- PageNationを表示 -->
    <!-- →HRMLで出力され、出来たClassでCSS指定する -->
    <!-- array() で内部のDataを指定し、それに値を設定 'prev_text'　'next_text'　はUnderBar-->
    <!-- 前へを隠す　次へを隠す -->
    <!-- DashIconも追加出来る　CopyHTML　からとってくる　ここで指定するのはCSSではない -->
    <?php the_posts_pagination(
        array(
        'prev_text' => '<span class="dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text">前へ</span>',
        'next_text' => '<span class="screen-reader-text">次へ</span><span class="dashicons dashicons-arrow-right-alt2"></span>'
        )
    );
    ?>

    </div>
    <!-- <div class="alignwide"> END-->

</main>


<?php get_sidebar(); ?>



<!-- Footer　Start -->

<?php get_footer(); ?>


<!-- Footer　END -->













