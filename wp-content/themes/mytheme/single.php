<!-- Header　Start -->

<?php get_header(); ?>

<!-- Header　END -->



<?php if(have_posts()): while(have_posts()): the_post(); ?>
<!--条件処理 記事の数を-->


<article <?php post_class('mycontainer');?> >


<!-- 自作Class myposthead　記事のTitleと投稿日をGroup化するもの -->
<div class="myposthead">

    <!-- categoryを表示するPHP -->
    <?php the_category(); ?>


    <h1><?php the_title(); ?></h1>
    <!-- 投稿記事　大見出し表示 -->
    <!-- <h1>で囲い、見出しをh1化する -->

    <!-- <time></time>内は日付情報として取得する 実際は表示されない -->
    <!-- 属性に2021-11-20T16:32:00+00:00のような形で時間が入る -->
    <time datetime="<?php echo esc_attr( get_the_date(DATE_W3C) ); ?>">

    <!-- 記事の投稿日を表示する -->
    <!-- esc_html() は無害化処理のこと Escapeの意味-->
    <!-- ここでは日付で不適切な文字列を除いたもの 念のため入れている-->
    <?php echo esc_html(get_the_date()); ?>

    </time>
</div>



<?php the_content(); ?>
<!-- 投稿記事　 -->

<!-- SNSButton配置 -->
<!-- SNSButton　見出し -->
<aside class="myshare">

    <!-- Shareの記号 -->
    <!-- https://developer.wordpress.org/resource/dashicons/#share -->
    <h2><span class="dashicons dashicons-share"></span>SHARE</h2>


    <!-- SNSButton　配置 -->
    <div class="mypostlist">
        <a 
        href="https://twitter.com/share?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>"
        class="mytwitter" onclick="window.open(this.href,'new', 'width=500,height=400'); return false;">
            <span class="dashicons dashicons-twitter"></span>
            <!-- 文字は隠す -->
            <span class="screen-reader-text">Twitter</span>
        </a>

        <a
        href="https://www.facebook.com/share.php?u=<?php echo urlencode( get_permalink() ); ?>"
        class="myfacebook"
        onclick="window.open(this.href,'new', 'width=500,height=400'); return false;">
            <span class="dashicons dashicons-facebook"></span>
            <!-- 文字は隠す -->
            <span class="screen-reader-text">Facebook</span>
        </a>
    </div>


</aside>




<!-- 前後の記事へのLinkを表示する　HTML側に大量に出力される -->
<?php the_post_navigation(); ?>


    <!--single.php作成時設定!! 関連記事=同じCategoryの記事の表示　箇所設定 -->
    <aside class="myrelated">
        <h2>RELATED</h2>

        <!-- 2列に並列させるためのCSS用のClass設定 -->
        <div class="mypostlist">

            <!-- 記事に関するDataを取得する -->
            <!-- PHPの変数　を設定している！！ その中身を指定している-->
            <!-- PHPの変数内容もarray() で更に詳細に設定出来る get_post() の　()内で更に詳細指定が可能-->

            <?php $myposts = get_posts(
                array(
                
                // 件数指定で表示
                'posts_per_page' => '4',
                // 既に表示中の内容は表示しない指定　
                'post__not_in' => array( get_the_ID() ),
                // 同じCategoryの内容を表示するもの
                'category__in' => wp_get_post_categories( get_the_ID() ),
                'orderby' => 'rand'

                )
                );
            ?>

            <!-- 前のPHPの変数を用い、　もし投稿があれば：その投稿ごとに：投稿内容を表示する;　　その内容 ここでは<h3>含む内部!!のarticle -->
            <?php
            if( $myposts):
            foreach($myposts as $post):
            setup_postdata($post);
            ?>

            <article>
    
                <!-- a要素は　Link -->
                <a href="<?php the_permalink(); ?>" >

                <!-- もし　投稿　thumbnail　があれば・・・それを表示する -->
                <?php if(has_post_thumbnail() ): ?>
                    <figure class="relatefigure">
                        <?php the_post_thumbnail(); ?>
                    </figure>
                <?php endif; ?>

                <h3><?php the_title(); ?></h3>
                    
                </a>

            </article>

            <!-- 投稿ごとの表示を終え;　投稿Dataの参照を初期化し;　ここでの全体if文終了する; -->
            <?php 
            endforeach;
            wp_reset_postdata();
            endif;
            ?>

        </div>


    </aside>
    <!--single.php作成時設定!! END-->


</article>


<?php endwhile; endif; ?>
<!--条件処理 終了-->


<!-- Widgetの読み込み TemplateParts = sidebar.phpから読み込み　-->
<?php get_sidebar(); ?>



<!-- Footer　Start -->

<?php get_footer(); ?>


<!-- Footer　END -->













