<?php
/**
 * Contains definition for EEM_Event_Message_Template model
 * @package 		Event Espresso
 * @subpackage 	models
 * @since 			4.4
 */
 if ( ! defined('EVENT_ESPRESSO_VERSION')) exit('No direct script access allowed');
 /**
 *	EEM_Event_Message_Template
 *	Model for relation table between EEM_Message_Template_Group and EEM_Event
 *
 * @package			Event Espresso
 * @subpackage		models
 * @since 				4.4
 * @author			 	Darren Ethier
 *
 * ------------------------------------------------------------------------
 */
require_once( EE_MODELS . 'EEM_Base.model.php' );

class EEM_Event_Message_Template extends EEM_Base {

	// private instance of the EEM_Event_Message_Template object
	private static $_instance = NULL;

	/**
	 * private constructor to prevent direct creation
	 * @Constructor
	 * @access private
	 * @param string $timezone 	string representing the timezone we want to set for returned Date
	 *                          				Time Strings (and any incoming timezone data that gets saved).
	 *                         				Note this just sends the timezone info to the date time model
	 *                         				field objects.  Default is NULL (and will be assumed using the set
	 *                         				timezone in the 'timezone_string' wp option)
	 * @return void
	 */
	protected function __construct( $timezone ) {
		$this->singlular_item = __('Event Message Template','event_espresso');
		$this->plural_item = __('Event Message Templates','event_espresso');

		$this->_tables = array(
			'Event_Message_Template'=> new EE_Primary_Table('esp_event_message_template', 'EMT_ID')
		);
		$this->_fields = array(
			'Event_Message_Template'=>array(
				'EMT_ID'=>new EE_Primary_Key_Int_Field('EMT_ID', __('Event Message Template ID','event_espresso')),
				'EVT_ID'=>new EE_Foreign_Key_Int_Field('EVT_ID', __('The ID to the Event','event_espresso'), false, 0, 'Event' ),
				'GRP_ID'=>new EE_Foreign_Key_Int_Field('GRP_ID', __('The ID to the Message Template Group','event_espresso'), false, 0, 'Message_Template_Group' )
			));
		$this->_model_relations = array(
			'Event'=>new EE_Belongs_To_Relation(),
			'Message_Template_Group'=>new EE_Belongs_To_Relation()
		);

		parent::__construct( $timezone );
	}




	/**
	 * This function is a singleton method used to instantiate the EEM model object
	 *
	 * @access public
	 * @param string $timezone 	string representing the timezone we want to set for returned Date
	 *                         				Time Strings (and any incoming timezone data that gets saved).
	 *                         				Note this just sends the timezone info to the date time model
	 *                         				field objects.  Default is NULL (and will be assumed using the set
	 *                         				timezone in the 'timezone_string' wp option)
	 * @return EEM_Datetime_Ticket instance
	 */
	public static function instance( $timezone = NULL ){

		// check if instance of EEM model already exists
		if ( self::$_instance === NULL ) {
			// instantiate EEM_Model
			self::$_instance = new self( $timezone );
		}

		//set timezone if we have in incoming string
		if ( !empty( $timezone ) )
			self::$_instance->set_timezone( $timezone );

		// EEM_Model object
		return self::$_instance;
	}

} //end class EEM_Event_Message_Template
