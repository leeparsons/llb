<?php

get_header();
		?><section class="col1" id="content" role="main"><?php
            


            if ( have_posts() ) {

                ?><div class="entry-content search"><header><h1 class="section-title"><span><?php
                    

                    
                    ?>Search Results for: <?php echo get_search_query(); ?></span><span class="stripe"></span></h1>
                    <p>Can&lsquo;t find what you are searching for? Try a different search term.</p><?php
                        
                                            get_template_part('main-search');
                        
                        ?></header></div><?php
    

                    while ( have_posts() ) {
    

                        the_post();
        
                        ?><h2 class="section-title"><a href="<? the_permalink() ?>"><span><?php the_title() ?></span></a><span class="stripe"></span></h2><?php
                        
                        get_template_part( 'content-search', get_post_format() );

                    }
              twentyeleven_content_nav( 'nav-below' );

               } else {
            ?><div class="entry-content">
					<header class="article-header">
                    <h1 class="article-title no-link">Search Results for: <?php echo get_search_query(); ?></h1><?php
    
                            get_template_part('main-search');
    
                        ?>
					</header>
                    <article class="post no-results not-found">
                        <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
                    </article>
            </div><?php

            }

            ?></section><?php

            
                get_sidebar();
                

                get_footer();