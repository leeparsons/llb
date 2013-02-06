<article>
	<div class="entry-content">
        <header><h1 class="section-title"><span><?php the_title(); ?></span><span class="stripe"></span></h1></header>
        <div class="meta-wrap"></div>
		<?php the_content(); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
</article>
