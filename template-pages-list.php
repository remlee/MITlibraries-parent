<?php
/**
 * Template Name: Template Page List
 *
 * This page outputs a list of pages 
 * using the specified template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */


$pageRoot = getRoot($post);
$section = get_post($pageRoot);
$isRoot = $section->ID == $post->ID;


 
get_header(); ?>

	<?php

	$template_page_args = array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'page-full-no.php',
	    'depth' => -1,
      'hierarchical' => 0
	);

	$template_pages = get_pages($template_page_args);
	
	$template_query_args = array (
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-full.php'
	);
	
	$template_queries = get_pages($template_query_args);

	?>

	<?php

		if(!current_user_can('manage_options')) {
			include( get_query_template( '404' ) );
			exit();
		}

		else {
			?>
			<div class="title"><h1>Template Page List</h1></div>
			<div class="mainContent">
				<div class="entry-content">
					<h2>Pages using the template: <span style="color:#d5632a;"><?php echo $template_page_args['meta_value']; ?></span></h2>
					<ul>
						<?php
						foreach ( $template_pages as $template_page ) {
						    echo '<li><a href="' . get_permalink( $template_page->ID ) . '">' . $template_page->post_title  . '</a></li>';
						}
						?>
					</ul>
				</div>
			</div>
			

		<?php } ?>

	<?php get_footer(); ?>