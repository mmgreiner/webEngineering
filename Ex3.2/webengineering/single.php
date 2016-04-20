<?php
/* @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
/*
   Drawback: We cannot use single pages for the posts anymore
*/

?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 

	 <aside class="blogauthor">
		<br>
		<p><img src="<?php bloginfo('template_url'); ?>/assets/img/team/u1.jpg" width="60px" height="60px"></p>
		<h4><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></h4>
		<h5><?php the_date(); ?></h5>
	</aside>
	<section class="blogtext">
		<h2><?php the_title(); ?></h2>
		<div>
			<?php the_content(); ?>
		</div>
		<br>
	</section> 
				
<?php endwhile; ?>
<?php endif; ?>
