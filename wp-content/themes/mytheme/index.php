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
<!-- 投稿記事　本文 -->

<!-- 前後の記事へのLinkを表示する　HTML側に大量に出力される -->
<?php the_post_navigation(); ?>


</article>


<?php endwhile; endif; ?>
<!--条件処理 終了-->


<!-- Widgetの読み込み TemplateParts = sidebar.phpから読み込み　-->
<?php get_sidebar(); ?>



<!-- Footer　Start -->

<?php get_footer(); ?>


<!-- Footer　END -->













