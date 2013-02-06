<?php

get_header(); 
    ?><section class="col1">
<?php
    
    if (is_category('categories')) {

        ?><header class="article-header">
        <h1 class="article-title no-link"><span>Categories</span></h1><?php
            get_template_part('main-search');
            ?>
        </header><div class="entry-content"><?php

        
        
        ?><nav><ul class="f-cats">
        <?php
        
        wp_list_categories( 
                           array(
                                 'title_li'     =>  '',
                                 'show_count'   =>  1
                                 )
                           );
        
        ?></ul>
</nav></div><?php
        
    } else {
    
    ?>
<header class="article-header">
<h1 class="article-title no-link"><span>Category: <?php echo single_cat_title( '', false ) . '</span>';  ?></h1><?php
    get_template_part('main-search');
    ?>
</header><?php
        $category_description = category_description();
        if ( ! empty( $category_description ) )
        echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );


    if ( have_posts() ) {

                    
                    
                    while ( have_posts() ) {
                        
                        
                        the_post();

                        get_template_part('content-excerpt');
                        
                        twentyeleven_content_nav( 'nav-below' );
                    }
                } else {
                        
                        ?>

				<article id="post-0" class="post no-results not-found">
					<div class="entry-content">
						<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
					</div>
				</article>
<?php
    
    
    }
    
    
    }
    
    ?>
</section>
<?php
    get_sidebar();
    get_footer();