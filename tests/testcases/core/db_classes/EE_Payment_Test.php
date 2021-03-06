<?php

if (!defined('EVENT_ESPRESSO_VERSION')) {
	exit('No direct script access allowed');
}

/**
 *
 * EE_Payment_Test
 *
 * @package			Event Espresso
 * @subpackage
 * @author				Mike Nelson
 *
 */
/**
 * @group core
 * @group core/db_classes
 */
class EE_Payment_Test extends EE_UnitTestCase{

	public function test_just_approved(){
		$p1 = EE_Payment::new_instance();
		$this->assertFalse( $p1->just_approved() );
		$p1->set_status( EEM_Payment::status_id_approved );
		$this->assertTrue( $p1->just_approved() );
		$id = $p1->save();
		$this->assertTrue( $p1->just_approved() );

		EEM_Payment::reset();
		//now try with a payment that began as approved
		//note that we've reset EEM_payment so this is just like
		//it had been created on a previous request
		$p2 = EEM_Payment::instance()->get_one_by_ID( $id );
		$this->assertFalse( $p2->just_approved() );
		$p2->set_status( EEM_Payment::status_id_pending );
		$p2->save();

		EEM_Payment::reset();
		//again, pretend this next part is a subsequent request
		$p3 = EEM_Payment::instance()->get_one_by_ID( $id );
		$this->assertFalse( $p3->just_approved() );
		$p3->set_status( EEM_Payment::status_id_approved );
		$this->assertTrue( $p3->just_approved() );
	}

	/**
	 * @group 7653
	 */
	function test_set_details(){
		$p = $this->new_model_obj_with_dependencies( 'Payment' );
		$cookie = new WP_HTTP_Cookie( array(
					'name' => 'something',
					'value' => 'somethingelse'
				));
		$details_to_set = array(
			'headers' => array(
				'header1' => 'headervalue1',
				'header2' => 'headervalue2',
			),
			'body' => '<html>hello</html>',
			'cookies' => array(
				$cookie
			)
		);
		//set the details with that object in there
		$p->set_details( $details_to_set );
		//ok now verify that it's been converted into an array a-ok
		$details_to_set['cookies'][0] = (array)$cookie;
		//and we should have actually removed tags like we set out to do in that method
		$details_to_set['body'] = 'hello';
		$this->assertEquals( $details_to_set, $p->details() );
	}
}

// End of file EE_Payment_Test.php