<?php
    
    get_header(); ?><section class="col1">

<?php
    $u = get_userdata(get_query_var('author'));
    
    

    
    ?><div class="entry-content">
        <article>
            <header><h1 class="section-title"><span>Author: <?php echo $u->display_name; ?></span><span class="stripe"></span></h1></header><?php
        
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();
                    
                    // If a user has filled out their description, show a bio on their entries.
                    if ( get_the_author_meta( 'description', $u->ID ) ) {
                        
                    ?>
                    <div id="author-info">
                        <div id="author-avatar">
                            <?php echo userphoto_the_author_photo(); ?>
                            <p class="meta"><?php the_author_meta( 'description' , $u->ID); ?></p>
                            <p class="author-links-wrap">
                                <span>Connect with the author:<br></span>
<?php if (get_the_author_meta('url', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('url', $u->ID) ?>" class="author-links www"><?php echo get_the_author_meta('url', $u->ID) ?></a>
<?php } ?>
<?php if (get_the_author_meta('blog', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('blog', $u->ID) ?>" class="author-links author-blog"><?php echo get_the_author_meta( 'blog', $u->ID) ?></a>
<?php } ?>
<?php if (get_the_author_meta('twitter', $u->ID)) { ?>
<a href="http://twitter.com/<?php echo get_the_author_meta('twitter', $u->ID) ?>" class="author-links author-twitter">http://twitter.com/<?php echo get_the_author_meta( 'twitter', $u->ID) ?></a>
<?php } ?>
<?php if (get_the_author_meta('facebook', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('facebook', $u->ID) ?>" class="author-links author-facebook"><?php echo get_the_author_meta('facebook', $u->ID) ?></a>  
<?php } ?>  
                            </p>
                        </div>
                    </div>
                    <?php 
                        
                        }
                    ?>
            </article>
        </div>
<?php
    if ( have_posts() ) {

        the_post();
?>
        <h2 class="section-title"><span>Posts by: <?php the_author(); ?></span><span class="stripe"></span></h2>
                    <?php
                    
                    
                    
                    
                    while ( have_posts() ) {
                        
                        the_post();
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
                        
						get_template_part( 'content-author-posts', get_post_format() );
					
                    } 
                    


                                    
                }
                
                ?></section><?php
                
                get_sidebar(); 

                get_footer();