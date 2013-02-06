<article id="page-<?php the_ID(); ?>">
    <header class="article-header"><h1 class="article-title no-link"><?php the_title(); ?></h1></header>
	<div class="entry-content">
		<?php the_content(); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
</article>
