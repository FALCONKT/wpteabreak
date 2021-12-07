</div> 
<!-- mycontent  閉じ　END -->


<!-- Profile 出力-->
<!-- CSS用 -->
<aside class="mymenu">

    <!-- CSS用 -->
    <div class="mycontainer">
    
    <!-- CSS用　WPで　幅広　を設定したときのみ出てくる　alignwide　で出てくるCSS -->
    <!-- mymenu-columns は　ColumnLayout　用 で追加指定-->
    <div class="alignwide mymenu-columns">




    <!-- 各種Widget -->
    <!-- if文が入っているため　最初の箇所は　:　で停める -->
    <?php if( is_active_sidebar('sidebar-1') ): ?>

    <?php dynamic_sidebar('sidebar-1'); ?>

    <?php endif; ?>



    <section class="myprofile">

<h2>PROFILE</h2>

<!-- 自己写真の参照 ThemeFolder内に指定している　-->
<figure>
    <img src = "<?php echo esc_url(get_theme_file_uri( 'profile.jpg' )); ?>" alt = ""> 
</figure>

<!-- WP管理画面からの自己紹介内容の表示 -->
<strong><?php the_author_meta('display_name'); ?></strong>
<p><?php the_author_meta('description'); ?></p>

</section>


    </div>
    <!-- alignwide END -->

    </div>
    <!-- mycontainer　END -->

</aside>

<!-- 2列組みにするための　div増やし　header内では頭の<>のみ　閉じTag　はここ　sidebar.php 内-->
<!-- 最外の親要素 -->
</div> 
<!-- mycols 閉じ　END -->