<?php
get_header(); ?><section class="col1">

<?php if ( have_posts() ) {
					the_post();

    ?><article><header class="article-header"><h1 class="article-title no-link">Author: <span class="vcard"><?php echo get_the_author(); ?></a></span></h1></header><?php
        
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();
                    
                    // If a user has filled out their description, show a bio on their entries.
                    if ( get_the_author_meta( 'description' ) ) {
                        
                    ?>
                    <div id="author-info" class="entry-content">
                        <p id="author-avatar">
                            <?php echo userphoto_the_author_photo();
                                                            
                                the_author_meta( 'description' ); ?>
                        </p>
</div><h2 class="entry-title no-link">Posts by: <?php the_author(); ?></h2>
<div class="author-posts"><?php
                    
                    }
                    
                    
                    
                    while ( have_posts() ) {
                        
                        the_post();
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content-author-posts', get_post_format() );
					
                    } 
                    
?></div></article><?php

                    } else {
                        
                        ?><article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php 
                
                }
                
                ?></section><?php
                
                get_sidebar(); 

                get_footer();