<?php if ( ! defined('EVENT_ESPRESSO_VERSION')) exit('No direct script access allowed');
/**
 * Event Espresso
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package			Event Espresso
 * @ author				Seth Shoultes
 * @ copyright		(c) 2008-2011 Event Espresso  All Rights Reserved.
 * @ license			{@link http://eventespresso.com/support/terms-conditions/}   * see Plugin Licensing *
 * @ link					{@link http://www.eventespresso.com}
 * @ since		 		4.0
 *
 * ------------------------------------------------------------------------
 *
 * EE_Registration class
 *
 * @package			Event Espresso
 * @subpackage		includes/classes/EE_Registration.class.php
 * @author				Brent Christensen 
 *
 * ------------------------------------------------------------------------
 */
require_once ( EE_CLASSES . 'EE_Base_Class.class.php' );
class EE_Registration extends EE_Base_Class {
	
    /**
    *	Registration ID
	* 
	* 	primary key
	*	
	* 	@access	protected
    *	@var int	
    */
	protected $_REG_ID = FALSE;

	
	
	
    /**
    *	Event ID
	* 
	*	foreign key from event table
	*  
	*	@access	protected
    *	@var int	
    */
	protected $_EVT_ID = NULL;
	
	
	
    /**
    *	Attendee ID
	* 
	* 	foreign key from attendee table
	*
	*	@access	protected
    *	@var int	
    */
	protected $_ATT_ID = NULL;	
	
	
    /**
    *	Transaction ID
	*
	*	foreign key from transaction table
	* 
	*	@access	protected
    *	@var int	
    */
	protected $_TXN_ID = NULL;
	
	
    /**
    *	Datetime Ticket ID
	* 
    *	foreign key from Datetime_Ticket table
	* 
	*	@access	protected
    *	@var int	
    */
	protected $_DTK_ID = NULL;	
	
	
	
	
    /**
    *	Status ID
	* 
    *	registration status code - Pending, Complete, Incomplete
	* 
	*	@access	protected
    *	@var string	
    */
	protected $_STS_ID = NULL;	
	
	
    /**
    *	Registration Date
	* 
    *	Unix timestamp
	* 
	*	@access	protected
    *	@var int	
    */
	protected $_REG_date = NULL;	
	
	
    /**
    *	Final Price
	* 
    *	Final Price for ticket after all modifications
	* 
	*	@access	protected
    *	@var float	
    */
	protected $_REG_final_price = NULL;	
	
	
	
    /**
    *	PHP Session ID
	*  
	*	@access	protected
    *	@var string	
    */
	protected $_REG_session = NULL;	
	
	
	
    /**
    *	Registration Code
	* 
    *	a unique string for public identification ( = existing registration_id )
	* 
	*	@access	protected
    *	@var string	
    */
	protected $_REG_code = NULL;	
	
	
	
    /**
    *	Registration URL Link
	* 
    *	a unique string for use in email links, etc
	* 
	*	@access	protected
    *	@var string	
    */
	protected $_REG_url_link = NULL;	
	
	
	
    /**
    *	Attendee Number
	* 
    *	Simple attendee counter where the Primary Registrant is always #1
	* 
	*	@access	protected
    *	@var int	
    */
	protected $_REG_count = 1;		
	
	
    /**
    *	Group Size
	* 
    *	total number of registrations that were performed in the same session
	* 
	*	@access	protected
    *	@var int	
    */
	protected $_REG_group_size = 1;	
	
	
    /**
    *	Attendee Is Going
	* 
    *	whether or not the attendee has confirmed they will be going to the event
	* 
	*	@access	protected
    *	@var boolean	
    */
	protected $_REG_att_is_going = 0;	
	
	
    /**
    *	Attendee Checked In
	* 
    *	whether or not the attendee checked in at the event
	* 
	*	@access	protected
    *	@var boolean	
    */
	protected $_REG_att_checked_in = NULL;	

	
	/**
	 * Event for which this registration is for
	 * 
	 * @access protected
	 * @var EE_Event
	 */
	protected $_Event = NULL;
	
	
	/**
	 * Attendee data for this registration
	 * 
	 * @access protected
	 * @var EE_Attendee
	 */
	protected $_Attendee = NULL;
	
	
	/**
	 * Transaction of this Registration
	 * @access protected
	 * @var EE_Tranaction
	 */
	protected $_Transaction = NULL;
	
	
	/**
	 * Datetime_Ticket object of the Event this registration is for
	 * @access protected
	 * @var EE_Datetime
	 */
	protected $_Datetime_Ticket = NULL;
	

	
	
	/**
	 * Status of the registration
	 * @access protected
	 * @var EE_Status (looks unfinished right now)
	 */
	protected $_Status = NULL;
	
	/**
	 * Answers made to questions for this registration
	 * @access protected 
	 * @var EE_Answer[]
	 */
	protected $_Answer = NULL;





	public static function new_instance( $props_n_values = array(), $timezone = NULL ) {
		$classname = __CLASS__;
		$has_object = parent::_check_for_object( $props_n_values, $classname );
		return $has_object ? $has_object : new self( $props_n_values, FALSE, $timezone );
	}




	public static function new_instance_from_db ( $props_n_values = array(), $timezone = NULL ) {
		return new self( $props_n_values, TRUE, $timezone );
	}





	/**
	*		Set Event ID
	* 
	* 		@access		public		
	*		@param		int		$EVT_ID 		Event ID
	*/	
	public function set_event( $EVT_ID = FALSE ) {		
		$this->set('EVT_ID',$EVT_ID);
	}



	/**
	*		Set Attendee ID
	* 
	* 		@access		public		
	*		@param		int		$ATT_ID 		Attendee ID
	*/	
	public function set_attendee_id( $ATT_ID = FALSE ) {		
		$this->set('ATT_ID',$ATT_ID);
	}



	/**
	*		Set Transaction ID
	* 
	* 		@access		public		
	*		@param		int		$TXN_ID 		Transaction ID
	*/	
	public function set_transaction_id( $TXN_ID = FALSE ) {		
		$this->set('TXN_ID',$TXN_ID);
	}



	/**
	*		Set Session 
	* 
	* 		@access		public		
	*		@param		string		$REG_session 		PHP Session ID
	*/	
	public function set_session( $REG_session = FALSE ) {		
		$this->set('REG_session',$REG_session);
	}



	/**
	*		Set Registration Code 
	* 
	* 		@access		public		
	*		@param		string		$REG_code 		Registration Code
	*/	
	public function set_reg_code( $REG_code = FALSE ) {		
		$this->set('REG_code',$REG_code);
	}



	/**
	*		Set Registration URL Link 
	* 
	* 		@access		public		
	*		@param		string		$REG_url_link 		Registration URL Link 
	*/	
	public function set_reg_url_link( $REG_url_link = FALSE ) {		
		$this->set('REG_url_link',$REG_url_link);
	}



	/**
	*		Set Attendee Counter
	* 
	* 		@access		public		
	*		@param		boolean		$REG_count 		Primary Attendee
	*/	
	public function set_count( $REG_count = FALSE ) {		
		$this->set('REG_count',$REG_count);
	}



	/**
	*		Set Group Size
	* 
	* 		@access		public		
	*		@param		boolean		$REG_group_size 		Group Registration
	*/	
	public function set_group_size( $REG_group_size = FALSE ) {		
		$this->set('REG_group_size',$REG_group_size);
	}



	/**
	*		Set Status ID
	* 
	* 		@access		public		
	*		@param		int		$STS_ID 		Status ID
	*/	
	public function set_status( $STS_ID = FALSE ) {		
		if ( ! $this->_check_for( $STS_ID, 'Status ID' )) { 
			return FALSE; 
		}
		//make sure related TXN is set
		$this->get_first_related('Transaction');
		// if status is ANYTHING other than approved, OR if it IS approved AND the TXN is paid in full (or free)
		if ( $STS_ID != EEM_Registration::status_id_approved || ( $STS_ID == EEM_Registration::status_id_approved && $this->_Transaction->is_completed() )) {
			$this->set('STS_ID',$STS_ID);
			return TRUE;
		} else {
			//@tod: this looks awfully like controller or business logic, not model code, imho; Mike
			$txn_url = EE_Admin_Page::add_query_args_and_nonce( array( 'action'=>'view_transaction', 'TXN_ID'=>$this->_TXN_ID ), TXN_ADMIN_URL );
			$txn_link = '
			<a id="reg-admin-sts-error-txn-lnk" href="' . $txn_url . '" title="' . __( 'View transaction #', 'event_espresso' ) . $this->_TXN_ID . '">
				' . __( 'View the Transaction for this Registration', 'event_espresso' ) . '
			</a>';			
			$msg =  __( 'Registrations can only be approved if the corresponding transaction is completed and has no monies owing.', 'event_espresso' ) . $txn_link;
			EE_Error::add_error( $msg, __FILE__, __FUNCTION__, __LINE__ );
			return FALSE;
		}	
		
	}



	/**
	*		Set Registration Date
	* 
	* 		@access		public		
	*		@param		mixed ( int or string )		$REG_date 		Registration Date - Unix timestamp or string representation of Date
	*/	
	public function set_reg_date( $REG_date = FALSE ) {		
		$this->set('REG_date',$REG_date);
	}



	/**
	*		Set final Price Paid for ticket after all modifications
	* 
	* 		@access		public		
	*		@param		float		$REG_final_price 		Price Paid
	*/	
	public function set_price_paid( $REG_final_price = FALSE ) {		
		$this->set('REG_final_price',$REG_final_price);
	}
	
	/**
	 * @return string of price, with correct decimal places and currency symbol
	 */
	public function pretty_price_paid(){
		return $this->get_pretty('REG_final_price');
	}





	/**
	*		Attendee Is Going
	* 
	* 		@access		public		
	*		@param		boolean		$REG_att_is_going 		Attendee Is Going
	*/	
	public function set_att_is_going( $REG_att_is_going = NULL ) {		
		$this->set('REG_att_is_going',$REG_att_is_going);
	}



	/**
	*		Attendee Checked In
	* 
	* 		@access		public		
	*		@param		boolean		$REG_att_checked_in 		Attendee Checked In
	*/	
	public function set_att_checked_in( $REG_att_checked_in = NULL ) {		
		$this->set('REG_att_checked_in',$REG_att_checked_in);
	}


	
	/**
	 * Returns the related EE_Transaction to this registration
	 * @return EE_Transaction	 
	 */
	public function transaction(){
		return $this->get_first_related('Transaction');
	}
	
	
	/**
	 * Gets the reltaed attendee
	 * @return EE_Attendee
	 */
	public function attendee(){
		return $this->get_first_related('Attendee');
	}




	/**
	*		get Event ID
	* 		@access		public
	*/	
	public function event_ID() {
		return $this->get('EVT_ID');
	}



	/**
	*		get Event ID
	* 		@access		public
	*/	
	public function event_name() {
		if ( empty( $this->_EVT_ID )) {
			return FALSE;
		}
		global $wpdb;
		$SQL = 'SELECT event_name, slug FROM ' . $wpdb->prefix . 'events_detail WHERE id = %d';
		return stripslashes( trim( $wpdb->get_var( $wpdb->prepare( $SQL, $this->_EVT_ID ))));
	}



	/**
	 * get Event daytime id
	 *
	 * @access public
	 * @return int
	 */
	public function event_daytime_id() {
		if ( empty( $this->_EVT_ID ) ) {
			return FALSE;
		}

		global $wpdb;
		$SQL = "SELECT DTT_ID FROM " . EE_DATETIME_TABLE . " WHERE EVT_ID = %s";
		return $wpdb->get_var( $wpdb->prepare( $SQL, $this->_EVT_ID ) );
	}


	/**
	 * just get the entire event
	 * @todo eventually this will change when events are in a proper model/class and can be retrieved with `get_first_related()`
	 *
	 * @access public
	 * @return object
	 */
	public function event() {
		if ( empty ( $this->_EVT_ID ) ) {
			return FALSE;
		}

		global $wpdb;
		$SQL = "SELECT * FROM " . EVENTS_DETAIL_TABLE . " WHERE id = %s";
		$event = $wpdb->get_row( $wpdb->prepare( $SQL, $this->_EVT_ID ) );
		return $event;
	}

	/**
	 * Fetches teh event this registration is for
	 * @return EE_Event
	 */
	public function event_obj(){
		return $this->get_first_related('Event');
	}


	/**
	*		get Attendee ID
	* 		@access		public
	*/	
	public function attendee_ID() {
		return $this->get('ATT_ID');
	}



	/**
	*		get Transaction ID
	* 		@access		public
	*/	
	public function transaction_ID() {
		return $this->get('TXN_ID');
	}



	/**
	*		get PHP Session ID
	* 		@access		public
	*/	
	public function session_ID() {
		return $this->get('REG_session');
	}



	/**
	*		get Registration Code
	* 		@access		public
	*/	
	public function reg_code() {
		return $this->get('REG_code');
	}



	/**
	*		get Registration URL Link
	* 		@access		public
	*/	
	public function reg_url_link() {
		return $this->get('REG_url_link');
	}
	
	
	
	
	
	/**
	 * Echoes out invoice_url()
	 * @return void
	 */
	public function e_invoice_url(){
		echo $this->invoice_url();
	}
	
	
	
	
	
	/**
	 * Gets the string which represents the URL for the invoice PDF for this registration.
	 * Dependant on code in ee/includes/functions/init espresso_export_invoice
	 * @return string
	 */
	public function invoice_url(){
		return home_url() . '/?invoice_launch=true&amp;id=' . $this->reg_url_link();
	}

	
	
	
	
	
	/**
	 * Echoes out payment_overview_url
	 */
	public function e_payment_overview_url(){
		echo $this->payment_overview_url();
	}
	
	
	
	
	
	/**
	 * Gets the URL of the thank you page with this registraiton REG_url_link added as
	 * a query parameter
	 * @return string
	 */
	public function payment_overview_url(){
		global $org_options;
		return add_query_arg(array('e_reg_url_link'=>$this->reg_url_link()),get_permalink($org_options['return_url']));
	}


	
	
	/**
	*		get  Attendee Number
	* 		@access		public
	*/	
	public function count() {
		return $this->get('REG_count');
	}



	/**
	*		get Group Size
	* 		@access		public
	*/	
	public function group_size() {
		return $this->get('REG_group_size');
	}



	/**
	*		get Status ID
	* 		@access		public
	*/	
	public function status_ID() {
		return $this->get('STS_ID');
	}



	/**
	*		get Registration Date
	* 		@access		public
	*/	
	public function date() {
		return $this->get('REG_date');
	}
	
	/**
	 * get datetime object for this registration
	 *
	 * @access public
	 * @return EE_Datetime
	 */
	public function date_obj() {		
		return $this->get_first_related('Datetime');
	}



	/**
	*		get Price Paid
	* 		@access		public
	*/	
	public function price_paid() {
		return $this->get('REG_final_price');
	}
	
	
	
	
	/**
	 * Returns a nice version of the status for displaying to customers
	 * @return string
	 */
	public function pretty_status(){
		require_once( EE_MODELS . 'EEM_Registration.model.php');
		switch($this->status_ID()){
			case EEM_Registration::status_id_approved:
				return __("Approved",'event_espresso');
			case EEM_Registration::status_id_not_approved:
				return __("Not Approved",'event_espresso');
			case EEM_Registration::status_id_pending:
				return __("Pending Approval",'event_espresso');
			case EEM_Registration::status_id_cancelled:
				return __("Cancelled",'event_espresso');
			default:
				return __("Unknown",'event_espresso');
		}
	}

	
	
	/**
	 * Prints out the return value of $this->pretty_status()
	 * @return void
	 */
	public function e_pretty_status(){
		echo $this->pretty_status();
	}





	/**
	*		get Attendee Is Going
	* 		@access		public
	*/	
	public function att_is_going() {
		return $this->get('REG_att_is_going');
	}



	/**
	*		get Attendee Checked In
	* 		@access		public
	*/	
	public function att_checked_in() {
		return $this->get('REG_att_checked_in');
	}
	
	/**
	 * Gets related answers
	 * @param array $query_params like EEM_Base::get_all
	 * @return EE_Answer[]
	 */
	public function answers($query_params = null){
		return $this->get_many_related('Answer',$query_params);
	}
	
	/**
	 * Returns the registration date in the 'standard' string format
	 * (function may be improved in the future to allow for different formats and timezones)
	 * @return string
	 */
	public function reg_date(){
		return $this->get('REG_date');
	}
}


/* End of file EE_Registration.class.php */
/* Location: includes/classes/EE_Registration.class.php */	
