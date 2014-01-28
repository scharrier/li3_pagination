<?php
namespace li3_pagination\tests\cases\extensions\helper;

use li3_pagination\extensions\data\Set;
use li3_pagination\tests\mocks\extensions\helper\MockPagination as Pagination;
use lithium\net\http\Router;
use lithium\action\Request;
use lithium\tests\mocks\template\MockRenderer;

class PaginationTest extends \lithium\test\Unit {

	/**
	 * Initialize test by creating a new object instance with a default context.
	 */
	public function setUp() {
		Router::connect('/{:controller}/{:action}/{:args}');

		$this->request = new Request();
		$this->request->params = ['controller' => 'post', 'action' => 'index'];
		$this->request->persist = ['controller'];
		$this->context = new MockRenderer(['request' => $this->request]);
	}

	public function tearDown() {
		Router::reset();
	}

	public function testGlobalConfiguration() {
		$defaults = Pagination::defaults() ;
		$this->assertTrue(is_array($defaults)) ;

		$pagination = new Pagination(['context' => $this->context]) ;
		$this->assertEqual('<< First', $pagination->config()['firstLabel']) ;

		Pagination::defaults(['firstLabel' => 'Start']) ;
		$pagination = new Pagination(['context' => $this->context]) ;
		$this->assertEqual('Start', $pagination->config()['firstLabel']) ;

		Pagination::defaults($defaults) ;
	}

	public function testFirst() {
		$pagination = new Pagination(['context' => $this->context]) ;
		$set = new Set(null, ['page' => 1]) ;
		$this->assertEqual('',$pagination->first(['documents' => $set]));

		$set->meta(['page' => 2]) ;
		$res = $pagination->first(['documents' => $set]) ;
		$this->assertTrue((bool) preg_match('/\?page=1/', $res)) ;
	}

	public function testLast() {
		$pagination = new Pagination(['context' => $this->context]) ;
		$set = new Set(null, ['page' => 5, 'total' => 25, 'limit' => 5]) ;
		$this->assertEqual('',$pagination->last(['documents' => $set]));

		$set->meta(['page' => 4]) ;
		$res = $pagination->last(['documents' => $set]) ;
		$this->assertTrue((bool) preg_match('/\?page=5/', $res)) ;
	}

	public function testNext() {
		$pagination = new Pagination(['context' => $this->context]) ;
		$set = new Set(null, ['page' => 5, 'total' => 25, 'limit' => 5]) ;
		$this->assertEqual('',$pagination->next(['documents' => $set]));

		$set->meta(['page' => 4]) ;
		$res = $pagination->next(['documents' => $set]) ;
		$this->assertTrue((bool) preg_match('/\?page=5/', $res)) ;
	}

	public function testPrev() {
		$pagination = new Pagination(['context' => $this->context]) ;
		$set = new Set(null, ['page' => 1, 'total' => 25, 'limit' => 5]) ;
		$this->assertEqual('',$pagination->prev(['documents' => $set]));

		$set->meta(['page' => 2]) ;
		$res = $pagination->prev(['documents' => $set]) ;
		$this->assertTrue((bool) preg_match('/\?page=1/', $res)) ;
	}

	public function testNumbers() {
		$pagination = new Pagination(['context' => $this->context]) ;
		$set = new Set(null, ['page' => 1, 'total' => 25, 'limit' => 5]) ;

		$res = $pagination->numbers(['documents' => $set]);
		$this->assertEqual([1,2,3,4,5], $res) ;

		$set->meta(['total' => 100]);
		$res = $pagination->numbers(['documents' => $set]);
		$this->assertEqual([1,2,3,4,5,6,7,8,9,10], $res) ;

		$set->meta(['page' => 20]);
		$res = $pagination->numbers(['documents' => $set]);
		$this->assertEqual([11,12,13,14,15,16,17,18,19,20], $res) ;

		$set->meta(['total' => 10]);
		$res = $pagination->numbers(['documents' => $set]);
		$this->assertEqual([1,2], $res) ;
	}

	public function testPages() {
		$pagination = new Pagination(['context' => $this->context]) ;
		$set = new Set(null, ['page' => 1, 'total' => 25, 'limit' => 5]) ;
		$res = $pagination->pages(['documents' => $set]);

		$this->assertTrue((bool) preg_match('/class="active"><a href="[^"]+\/post/', $res)) ;
		$this->assertTrue((bool) preg_match('/\?page=5/', $res)) ;
	}
}
