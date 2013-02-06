<?php
get_header();
    
    ?><section class="col1">


			<article id="post-0" class="post error404 not-found">
				<header class="article-header">
					<h1 class="article-title no-link">Sorry, page not found</h1><?php
                        
                        get_template_part('main-search'); 

                        ?>
				</header>

				<div class="entry-content">
					<p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.</p>

<?php

rewind_posts();
    query_posts(
                array(
                      'category__not_in'    =>  array(
                                                      261
                                                      ),
                      'showposts'           =>  8
                      )
                );

if (have_posts()) {
    
    ?><div class="widget latest-posts latest-posts-widget"><h2 class="article-title no-link">Latest Posts</h2><?php
    
    $c = (int)0;
    
    while (have_posts()) {
        $c++;
        the_post();
        
        
        $title = get_the_title();
        
        if (strlen($title) > 30) {
            
            $title = substr($title, 0, 27);
            
            //now figure out if the title is broken... 
            
            $titleRev = strrev($title);
            if ((int)strpos($titleRev, ' ') > 0) {
                $title = strrev(substr($titleRev, strpos($titleRev, ' ')));
            }
            $titleRev = '';
            $title .= '...';
            
        }
        
        love_image_cache('small-thumb', 120, 's-tmb', true, ($c%5 == 0) ? 'c l' : 'l', $title, get_field('post-thumbnail'), true);
    }
    
    ?></div><?php  
    
}
        wp_reset_query();

?>


					<div class="widget">
						<h2 class="article-title no-link">Most Used Categories</h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
						</ul>
					</div>

					<?php


                        the_widget( 'WP_Widget_Archives',
                                   array(
                                         'count' =>  1
                                         ),
                                   array(              
                                         'before_title'  =>  '<h2 class="article-title no-link">', 
                                         'after_title'   =>  '</h2>'                                
                                         )
                                   );
?><div class="widget"><h2 class="article-title no-link">Tags</h2><?php

    
    wp_tag_cloud(array('format' => 'list'));
    
    ?></div>
                </div>
			</article>
	</section><?php
    
    get_sidebar();
    get_footer();