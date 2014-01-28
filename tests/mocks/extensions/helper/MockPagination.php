<?php
namespace li3_pagination\tests\mocks\extensions\helper;

use li3_pagination\extensions\helper\Pagination;

/**
 * Test sub class.
 */
class MockPagination extends Pagination {

	/**
	 * Gives access to the _numbers() protected method.
	 *
	 * @param  array $options Options
	 * @return array          Numbers
	 */
	public function numbers(array $options = []) {
		list($scope, $options, $documents) = $this->_split($options);

		return $this->_numbers($documents, $scope) ;
	}
}
