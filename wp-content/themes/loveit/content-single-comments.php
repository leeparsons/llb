<div class="single-comments comments" id="comments">
<h4>Comments:</h4>
<?php
    
    if (!post_password_required()) {
        
    
    ?>
<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyeleven' ); ?></p>
</div><!-- #comments -->
<?php
    /* Stop the rest of comments.php from being processed,
     * but don't kill the script entirely -- we still have
     * to fully load the template.
     */
    return;
    }
	?>
</div>
