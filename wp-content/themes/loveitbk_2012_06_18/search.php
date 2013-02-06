<?php

get_header();
		?><section class="col1" id="content" role="main"><?php
            


            if ( have_posts() ) {

                ?><header class="article-header"><h1 class="article-title no-link"><span><?php
                    

                    
                    ?>Search Results for: <?php echo get_search_query(); ?></span></h1><?php
                        
                                            get_template_part('main-search');
                        
                        ?></header><?php
    

                    while ( have_posts() ) {
    

                        the_post();
        
                        echo '<div class="spacer"></div>';
                        get_template_part( 'content-search', get_post_format() );
			

                    }
            

               } else {
            ?>
					<header class="article-header">
                    <h1 class="article-title no-link">Search Results for: <?php echo get_search_query(); ?></h1><?php
    
                            get_template_part('main-search');
    
                        ?>
					</header
    <article id="post-0" class="post no-results not-found">
					<div class="entry-content">
						<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
					</div>
        </article><?php

            }

            ?></section><?php

            
                get_sidebar();
                

                get_footer();