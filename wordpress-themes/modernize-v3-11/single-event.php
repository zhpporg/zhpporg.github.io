<?php
/**
 * Template Name: Single Event
 */

get_header();

?>

<div class="content-wrapper sidebar-included right-sidebar">
<div class="clear"></div>

<div class="gdl-page-float-left">

   <div class="gdl-page-item">

		<?php
			if ( have_posts() ){
				while (have_posts()){
					the_post();

					echo '<div class="sixteen columns mt0">';

					// Single header
					echo '<h1 class="single-thumbnail-title post-title-color gdl-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
					the_tags('<div class="single-thumbnail-tag">', ', ', '</div>');

					echo '<div class="single-thumbnail-comment">';
					comments_popup_link( __('0 Comment','gdl_front_end'),
						__('1 Comment','gdl_front_end'),
						__('% Comments','gdl_front_end'), '',
						__('Comments are off','gdl_front_end') );
					echo '</div>';
					echo '<div class="clear"></div>';
					echo '</div>';

					// Inside Thumbnail
					if( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
						$item_size = "630x200";
					}else if( $sidebar == "both-sidebar" ){
						$item_size = "450x140";
					}else{
						$item_size = "930x300";
					}

					$inside_thumbnail_type = get_post_meta($post->ID, 'post-option-inside-thumbnail-types', true);

					switch($inside_thumbnail_type){

						case "Image" :

							$thumbnail_id = get_post_meta($post->ID,'post-option-inside-thumbnial-image', true);
							$thumbnail = wp_get_attachment_image_src( $thumbnail_id , $item_size );
							$thumbnail_full = wp_get_attachment_image_src( $thumbnail_id , 'full' );
							$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);

							if( !empty($thumbnail) ){
								echo '<div class="blog-thumbnail-image">';
								echo '<a href="' . $thumbnail_full[0] . '" data-rel="prettyPhoto" title="' . get_the_title() . '" ><img src="' . $thumbnail[0] .'" alt="'. $alt_text .'"/></a>';
								echo '</div>';
							}
							break;

						case "Video" :

							$video_link = get_post_meta($post->ID,'post-option-inside-thumbnail-video', true);
							echo '<div class="blog-thumbnail-video">';
							echo get_video($video_link, gdl_get_width($item_size), gdl_get_height($item_size));
							echo '</div>';
							break;

						case "Slider" :

							$slider_xml = get_post_meta( $post->ID, 'post-option-inside-thumbnail-xml', true);
							$slider_xml_dom = new DOMDocument();
							$slider_xml_dom->loadXML($slider_xml);

							echo '<div class="blog-thumbnail-slider">';
							echo print_flex_slider($slider_xml_dom->documentElement, $item_size);
							echo '</div>';
							break;

					}

					echo "<div class='clear'></div>";

					echo "<div class='single-content sixteen columns mt0'>";
					echo the_content();
                                        echo "<div class='single-port-prev-nav'><div class='left-arrow'></div><a href='/parents/calendar/'>View full parents' calendar</a></div>";
					wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'gdl_front_end' ) . '</span>', 'after' => '</div>' ) );
					echo "</div>";

					echo '<div class="clear"></div>';


					echo "</div>"; // sixteen-columns
				}
			}
		?>

		</div> <!-- gdl-page-item -->

</div> <!-- end gdl-page-float-left -->

		<div class="five columns mt0 gdl-right-sidebar">
			<div class="right-sidebar-wrapper gdl-divider" style="height: 906px;">
				<?php dynamic_sidebar( 'events-sidebar' ); ?>
			</div>
		</div>

		<div class="clear"></div>

	</div> <!-- content-wrapper -->


</div></div>

<?php get_footer(); ?>