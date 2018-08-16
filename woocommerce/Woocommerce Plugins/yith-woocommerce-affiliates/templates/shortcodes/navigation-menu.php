<?php
/**
 * Affiliate Dashboard Menu
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.5
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php if( $show_right_column ): ?>
	<div class="right-column <?php echo ( ! $show_left_column ) ? 'full-width' : '' ?>">
		<!--CLICKS SUMMARY-->
		<?php if( $show_dashboard_links ): ?>
			<div class="dashboard-title">
				<h2><?php _e( 'Menu', 'yith-woocommerce-affiliates' ) ?></h2>
			</div>
			<ul class="dashboard-links">
				<li><a href="<?php echo $dashboard_links['commissions'] ?>"><?php _e( 'Commissions', 'yith-woocommerce-affiliates' ) ?></a></li>
				<li><a href="<?php echo $dashboard_links['clicks'] ?>"><?php _e( 'Clicks', 'yith-woocommerce-affiliates' ) ?></a></li>
				<li><a href="<?php echo $dashboard_links['payments'] ?>"><?php _e( 'Payments', 'yith-woocommerce-affiliates' ) ?></a></li>
				<li><a href="<?php echo $dashboard_links['generate_link'] ?>"><?php _e( 'Generate link', 'yith-woocommerce-affiliates' ) ?></a></li>
				<li><a href="<?php echo $dashboard_links['settings'] ?>"><?php _e( 'Settings', 'yith-woocommerce-affiliates' ) ?></a></li>
				<?php do_action( 'yith_wcaf_after_dashboard_links', $dashboard_links ) ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endif; ?>
