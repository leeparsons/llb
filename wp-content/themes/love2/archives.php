<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 *  Template Name: Archives
 */

get_header(); ?>
		<section class="col1">
<?php
    
 the_post();
    ?><div class="entry-content search">
    <header>
        <h1 class="section-title"><span><?php the_title(); ?></span><span class="stripe"></span></h1>
    </header>
    <p>Can&rsquo;t find what you are looking for? Try searching the site. </p><?php get_template_part('main-search');
        
        ?></div><?php
        


        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        $args = array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged );

        query_posts($args);
        
         if ( have_posts() ) :
                
                while ( have_posts() ) { 
                    
                    the_post();
                        
                    ?><h2 class="section-title"><a href="<?php the_permalink() ?>"><span><?php the_title() ?></span></a><span class="stripe"></span></h2><?php
                    
						get_template_part( 'content-search', get_post_format() );
				

                }
        
        
                twentyeleven_content_nav( 'nav-below' );


         else :


 endif; ?>
</section>
<?php
    get_sidebar(); 
 get_footer();