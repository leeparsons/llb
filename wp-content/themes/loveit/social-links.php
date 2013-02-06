<div class="share-links">
<span class='share-this'>share this:</span>
<?php/*
<span class='st_twitter_custom st_custom' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText=''></span>
<span class='st_facebook_custom st_custom' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText=''></span>
<span class='st_email_custom st_custom' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText=''></span>
<span class='st_plusone_custom st_custom st_plusone_vcount' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span>
<span class='st_fblike_hcount' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span>
*/ ?>
<span class='st_fblike_hcount' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span>
<span class='st_twitter_hcount' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span>
<span class='st_plusone_hcount' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span>
<?php
    
    if (!is_page()) {
    
    ?><div class="pin-it">
<a href="http://pinterest.com/pin/create/button/?url=<?php

echo urlencode(get_permalink());

?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id())); ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div><?php

}

?>
</div>