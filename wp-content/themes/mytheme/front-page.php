<!-- Header　Start -->

<?php get_header(); ?>

<!-- Header　END -->


<?php if(have_posts()): while(have_posts()):	
the_post(); ?>

<!-- 元page.php のFile それを変更した内容 -->
<!-- 元　<article></article> が合ったものを変更している -->
<!-- <main></main> を新規で入れて　その中に　PHP　を吐き出す -->
<main <?php post_class('mycontainer'); ?>>
<?php the_content(); ?>
</main>

<?php endwhile; endif; ?>	

<!-- Widgetの読み込み TemplateParts = sidebar.phpから読み込み　-->
<?php get_sidebar(); ?>

<!-- Footer　Start -->

<?php get_footer(); ?>


<!-- Footer　END -->













