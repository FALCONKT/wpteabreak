<!-- Header　Start -->

<?php get_header(); ?>

<!-- Header　END -->



<?php if(have_posts()): while(have_posts()): the_post(); ?>
<!--条件処理 記事の数を-->


<article <?php post_class('mycontainer');?> >


<!-- 自作Class myposthead　記事のTitleと投稿日をGroup化するもの -->
<div class="myposthead">


    <h1><?php the_title(); ?></h1>
    <!-- 投稿記事　大見出し表示 -->
    <!-- <h1>で囲い、見出しをh1化する -->

    <!-- 既存の index.php　を複製時　投稿日付の情報を消した　-->
    <p>
        <!-- 投稿名=slug を表示する. 各固定Pageの内容が反映される　-->
    <?php echo esc_html( strtoupper( get_post_field( 'post_name' ) ) ); ?>
    </p>

</div>



<?php the_content(); ?>
<!-- 投稿記事　本文 -->

<!-- 既存の index.php　を複製時　前後の記事へのLinkの情報を消した　-->


</article>


<?php endwhile; endif; ?>
<!--条件処理 終了-->


<!-- Widgetの読み込み TemplateParts = sidebar.phpから読み込み　-->
<?php get_sidebar(); ?>



<!-- Footer　Start -->

<?php get_footer(); ?>


<!-- Footer　END -->













