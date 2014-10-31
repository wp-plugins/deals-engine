<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Deal Sales List Page
 *
 * The html markup for the product list
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
	
class Wps_Deals_Reports_List extends WP_List_Table {

	public $model,$currency,$render;
	
	function __construct(){
	
        global $wps_deals_model, $page,$wps_deals_currency,$wps_deals_render;
                
        //Set parent defaults
        parent::__construct( array(
							            'singular'  => 'dealreport',     //singular name of the listed records
							            'plural'    => 'dealreports',    //plural name of the listed records
							            'ajax'      => false        //does this table support ajax?
							        ) );   
		
		$this->model = $wps_deals_model;
		$this->currency = $wps_deals_currency;
		$this->render = $wps_deals_render;
		
    }
    
    /**
	 * Displaying Prodcuts
	 *
	 * Does prepare the data for displaying the products in the table.
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function display_deals_reports() {
	
		//if search is call then pass searching value to function for displaying searching values
		$args = array();
		
		//get deals sale data from database
		$data = $this->model->wps_deals_get_data( $args );
		
		foreach ($data as $key => $value){
			
			//this line should be on start of loop
			$data[$key]	= apply_filters('wps_deals_reports_column_data',$value,$value['ID']);
			
			$sales_data = $this->model->wps_deals_get_post_sale_count_earning($value['ID']);
			$data[$key]['salescount'] = $sales_data['salescount'];
			$data[$key]['earnings'] = $this->currency->wps_deals_formatted_value($sales_data['earnings']);
			
			$monthly_sales_data = $this->model->wps_deals_get_monthly_sales_earning($value['ID']);
			$data[$key]['monthly_avg_sales'] = number_format( $monthly_sales_data['salescount'], 2 );
			$data[$key]['monthly_avg_earnings'] = $this->currency->wps_deals_formatted_value($monthly_sales_data['earnings']);
		}
		
		return $data;
	}
	
	/**
	 * Mange column data
	 *
	 * Default Column for listing table
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function column_default( $item, $column_name ){
		
        switch( $column_name ){
            case 'post_title' :
            case 'salescount' :
            case 'earnings' :
            case 'monthly_avg_sales' :
            case 'monthly_avg_earnings' :
            	return $item[ $column_name ];
            default:
				return $item[ $column_name ];
        }
    }
	
    /**
     * Display Columns
     *
     * Handles which columns to show in table
     * 
	 * @package Social Deals Engine
	 * @since 1.0.0
     */
	function get_columns(){
	
        $columns = array(
					            'post_title'			=>	__(	'Deals', 'wpsdeals' ),
					            'salescount'			=>	__(	'Sales', 'wpsdeals' ),
					            'earnings'				=>	__(	'Earnings', 'wpsdeals' ),
					            'monthly_avg_sales'		=>	__(	'Monthly Average Sales', 'wpsdeals' ),
					            'monthly_avg_earnings'	=>	__(	'Monthly Average Earnings', 'wpsdeals' ),
					        );
        return apply_filters('wps_deals_reports_column',$columns);
    }
	
    /**
     * Sortable Columns
     *
     * Handles soratable columns of the table
     * 
	 * @package Social Deals Engine
	 * @since 1.0.0
     */
	function get_sortable_columns() {
		
        $sortable_columns = array(
        								'post_title'	=>	array( 'post_title', true ),
        								'salescount'	=>	array( 'salescount', true ),
        								'earnings'		=>	array( 'earnings', true ),
							        );
        return apply_filters('wps_deals_reports_sortable_column',$sortable_columns);
    }
	
	function no_items() {
		//message to show when no records in database table
		_e( 'No reports found.', 'wpsdeals' );
	}
	
	function prepare_items() {
        
		global $wps_deals_options;
        
		/**
         * First, lets decide how many records per page to show
         */
        $per_page = isset($wps_deals_options['per_page']) && !empty($wps_deals_options['per_page']) ? $wps_deals_options['per_page'] : '10';
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
         /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        //$this->process_bulk_action();
        
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
		$data = $this->display_deals_reports();
		
        
        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         * 
         * In a real-world situation involving a database, you would probably want 
         * to handle sorting by passing the 'orderby' and 'order' values directly 
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'ID'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
       
                
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
									            'total_items' => $total_items,                  //WE have to calculate the total number of items
									            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
									            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
									        ) );
    }
    
}

//Create an instance of our package class...
$DealsReportsListTable = new Wps_Deals_Reports_List(); 
	
//Fetch, prepare, sort, and filter our data...
$DealsReportsListTable->prepare_items();

	//add something before report deals
	do_action( 'wps_deals_reports_before' );

?>
	<form action="" method="POST">
		<?php
			//add something before report deals export to csv button
			do_action( 'wps_deals_reports_export_csv_btn_before' );
		?>
		<input type="submit" class="button" id="wps-deals-report-exports" name="wps-deals-report-exports" value="<?php _e('Export to CSV','wpsdeals');?>" />
		<?php
			//add something after report deals export to csv button
			do_action( 'wps_deals_reports_export_csv_btn_after' );
		?>
	</form>
<!-- Now we can render the completed list table -->
<?php 

	// display reports list
	$DealsReportsListTable->display(); 
	
	//add something after report deals
	do_action( 'wps_deals_reports_after' );

?>