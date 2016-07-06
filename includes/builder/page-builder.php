<?php
/**
 * The Page Builder
 * @since 1.0.0
 */
namespace fx_builder\builder;


/* PARTS
------------------------------------------ */

/* Row Parts */
require_once( PATH . 'parts-row.php' );

/* Column Parts */
require_once( PATH . 'parts-col.php' );

/* Column Parts */
require_once( PATH . 'parts-item.php' );


/* Add Page Builder Editor
------------------------------------------ */

/* Add it after editor in edit screen */
add_action( 'edit_form_after_editor', __NAMESPACE__ . '\page_builder', 10, 2 );

/**
 * The Page Builder
 * @since 1.0.0
 */
function page_builder( $post ){
	/* TEMP: Only in page post type */
	if( 'page' !== $post->post_type ){ return; }
?>

	<div id="fxb-menu">
		<p><a href="#" class="button button-primary">Add Row</a></p>
	</div><!-- #fxb-menu -->

	<div id="fxb">

		<?php
		/* ROW #1
		stack: r2l, l2r (default)
		*/
		?>
		<div class="fxb-row fxb-clear" data-id="123456789" data-col-num="1" data-col="1" data-stack="l2r">

			<?php row_menu(); ?>

			<div class="fxb-row-content fxb-clear">

				<?php /* COLUMN #1 */ ?>
				<div class="fxb-col fxb-clear">
					<h3 class="fxb-col-title"><span><?php _e( '1st Column', 'fx-builder' ); ?></span></h3>

					<div class="fxb-item">

						<?php item_menu(); ?>

						<div class="fxb-item-content">

							<iframe class="fxb-item-iframe" width="100%" height="100" scrolling="no">
							</iframe>

							<textarea class="fxb-item-textarea" style="display:none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas a tortor quam. Vestibulum aliquet, diam eget dignissim vehicula, sapien sapien tempor velit, a ultrices tellus turpis nec nunc.</textarea>

						</div><!-- .fxb-item-content -->
					</div>

					<?php add_item(); ?>
				</div><!-- .fxb-col -->

				<?php /* COLUMN #2 */ ?>
				<div class="fxb-col fxb-clear">
					<h3 class="fxb-col-title"><span><?php _e( '2nd Column', 'fx-builder' ); ?></span></h3>

					<?php add_item(); ?>
				</div><!-- .fxb-col -->

				<?php /* COLUMN #3 */ ?>
				<div class="fxb-col fxb-clear">
					<h3 class="fxb-col-title"><span><?php _e( '3rd Column', 'fx-builder' ); ?></span></h3>

					<?php add_item(); ?>
				</div><!-- .fxb-col -->

				<?php /* COLUMN #4 */ ?>
				<div class="fxb-col fxb-clear">
					<h3 class="fxb-col-title"><span><?php _e( '4th Column', 'fx-builder' ); ?></span></h3>

					<?php add_item(); ?>
				</div><!-- .fxb-col -->

			</div><!-- .fxb-row-content -->

		</div><!-- .fxb-row -->


	</div><!-- #fxb -->

<?php
}

























