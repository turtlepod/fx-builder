<?php
/**
 * Utility Function
**/
namespace fx_builder\builder;

/**
 * Render Modal Box Settings HTML
 * @since 1.0.0
 */
function render_settings( $args = array() ){
	$args_default = array(
		'id'        => '',
		'title'     => '',
		'callback'  => '__return_false',
		'width'     => '500px',
		'height'    => 'auto',
	);
	$args = wp_parse_args( $args, $args_default );
?>
	<div class="<?php echo sanitize_title( $args['id'] ); ?> fxb-modal" style="display:none;width:<?php echo esc_attr( $args['width'] ); ?>;height:<?php echo esc_attr( $args['height'] );?>;">
		<div class="fxb-modal-container">
			<div class="fxb-modal-title"><?php echo $args['title']; ?><span class="fxb-modal-close">Done</span></div><!-- .fxb-modal-title -->

			<div class="fxb-modal-content">
				<?php if ( is_callable( $args['callback'] ) ){
					call_user_func( $args['callback'] );
				} ?>
			</div><!-- .fxb-modal-content -->

		</div><!-- .fxb-modal-container -->
	</div><!-- .fxb-modal -->
<?php
}

