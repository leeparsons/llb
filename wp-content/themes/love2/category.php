<?php

get_header(); 
    
    
    
    
    ?><section class="col1"><div class="entry-content"><?php
    
    if (is_category('categories')) {

        ?><header>
        <h1 class="section-title"><span>Categories</span><span class="stripe"></span></h1>
        </header><nav><ul class="f-cats">
        <?php
        
        wp_list_categories( 
                           array(
                                 'title_li'     =>  '',
                                 'show_count'   =>  1
                                 )
                           );
        
        ?></ul>
</nav><?php
        
    } else {
    
    ?>
<header>
<h1 class="section-title"><span>Category: <?php echo single_cat_title( '', false ) . '</span>';  ?><span class="stripe"></span></h1><?php

    ?>
</header><?php
        $category_description = category_description();
        if ( ! empty( $category_description ) )
        echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
?></div><?php

    if ( have_posts() ) {

                    
                    
                    while ( have_posts() ) {
                        
                        
                        the_post();

                        ?><h2 class="section-title"><a href="<?php the_permalink() ?>"><span><?php the_title() ?></span></a><span class="stripe"></span></h2><?php
                        
                        ?><div class="entry-content"><?php
    
                            get_template_part('post-header-image');
                            
                            get_template_part('post-by');
                            
                        the_excerpt()
                        
                            
                            
                            
                        ?></div><?php

                    }
                            
                            twentyeleven_content_nav( 'nav-below' );

                            
                } else {
                        
                        ?>

				<article class="post no-results not-found">

						<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>

				</article>
<?php
    
    
    }
    
    
    }
    
    ?>
</div></section>
<?php
    get_sidebar();
    get_footer();