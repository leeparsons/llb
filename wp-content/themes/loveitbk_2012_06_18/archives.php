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
    ?>
    <header class="article-header">
        <h1 class="article-title no-link"><span><?php the_title(); ?></span></h1><?php get_template_part('main-search');          ?>
    </header><?php
        


        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        $args = array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged );

        query_posts($args);
        
         if ( have_posts() ) :
                
                while ( have_posts() ) { 
                    
                    the_post();

						get_template_part( 'content-search', get_post_format() );
				

                }
        
        
                twentyeleven_content_nav( 'nav-below' );


         else :


 endif; ?>
</section>
<?php
    get_sidebar(); 
 get_footer();