<section class="col2">
<?php
    
    //get_template_part('sidebar-countdown');
    
	$sidebars_widgets = get_option('sidebars_widgets');
	
	get_template_part('sidebar-adverts');
	
	?><div class="sa2"><aside style="margin-top:0">
<h3 class="search-site">Search the site</h3>
    <?php
        get_search_form('Search ...');
        ?>
</aside>
<?php
    
    
    get_template_part('sidebar-mailing-list-signup');

    ?><aside>
        <h3 class="about-rosie">About Me</h3>
        <img src="/images/about.png" class="about-img" />
        <p class="about-text"><?php
            
            echo substr(get_the_author_meta('description', 1), 0, 94) . '... <a href="/author/admin/">[read more]</a>';
            
            ?></p>
    </aside>
    <?php
        
        
                
        /*
        if (is_dynamic_sidebar('sidebar-2') &&  count($sidebars_widgets['sidebar-2']) > 0) {
            ?><aside><h3 class="widget-title featuredin">As featured in</h3></aside><?php
            dynamic_sidebar('sidebar-2');                
        } 
        */
        ?>
    <aside id="archives" class="widget">
        <h3 class="widget-title">Monthly Archives</h3>
        <ul class="archives">
            <?php wp_get_archives( array( 'type' => 'monthly', 'show_post_count'  =>  true) ); ?>
        </ul>
    </aside>
    <aside class="widget">
        <h3 class="widget-title">Category Archives</h3>
        <ul class="archives">
            <?php wp_list_categories(
                                     array(
                                           'title_li'   =>  '',
                                           'show_count'      =>  1
                                           )
                                     ); ?>
        </ul>
    </aside>
    <div class="col2-widget-area" role="complementary">
            <?php
                
                rewind_posts();
                
                query_posts(
                            array(
                                  'category__not_in'    =>  array(
                                                                  261
                                                                  ),
                                  'showposts'           =>  6
                                  )
                            );
                
                if (have_posts()) {
           
                    ?><aside id="latest-posts" class="latest-posts"><h3>Latest Posts</h3><?php    
                    
                        $c = (int)0;
                        
                    while (have_posts()) {
                        $c++;
                        the_post();

                        //figure out the title length:
                        
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
                        
                        
                        love_image_cache('small-thumb', 120, 's-tmb', true, ($c%2 == 0) ? 'c' : 'l', $title, get_field('thumbnail'), true);
                    }
                        
                  ?></aside><?php  
                      
                }
                      wp_reset_query();
                ?>
    </div>
</div>
</section>