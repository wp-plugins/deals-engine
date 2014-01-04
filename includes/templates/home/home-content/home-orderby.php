<?php
/**
 * Home Loop Template
 * 
 * Handles to Show Order by dropdown
 * Template on home page
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/home/home-content/more-deals.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="wps-deals-ordering">
	<form class="wps-deals-ordering-form" method="get" action="">
		<select name="orderby" class="wps-deals-orderby">
			<?php
				$catalog_orderby = apply_filters( 'wps_deals_catalog_orderby', array(
					'menu_order' => __( 'Default sorting', 'wpsdeals' ),
					'popularity' => __( 'Sort by popularity', 'wpsdeals' ),
					'rating'     => __( 'Sort by average rating', 'wpsdeals' ),
					'date'       => __( 'Sort by newness', 'wpsdeals' ),
					'price'      => __( 'Sort by price: low to high', 'wpsdeals' ),
					'price-desc' => __( 'Sort by price: high to low', 'wpsdeals' )
				) );
				
				$default_orderby = apply_filters( 'wps_deals_catalog_orderby', array(
											'date-asc'		=> __( 'Sort by date (asc)','wpsdeals' ),
											'date-desc'		=> __( 'Sort by date (desc)','wpsdeals' ),
											'price-asc'		=> __( 'Sort by price (asc)','wpsdeals' ),
											'price-desc'	=> __( 'Sort by price (desc)','wpsdeals' )
										) );
				
				foreach ( $default_orderby as $id => $name ) {
					echo '<option value="' . esc_attr( $id ) . '" ' . selected( $orderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
				}
				
			?>
		</select>
		
		<?php
			// Keep query string vars intact
			foreach ( $_GET as $key => $val ) {
				if ( 'orderby' == $key )
					continue;
				
				if (is_array($val)) {
					foreach($val as $innerVal) {
						echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
					}
				
				} else {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
				}
			}
			?>
	</form>
</div>