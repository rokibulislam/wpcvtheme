<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Blank-Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
