<?php
namespace li3_pagination\extensions\data ;

use lithium\action\Request;
use li3_pagination\extensions\data\PaginableSet;

/**
 * Add a model the ability to paginate automagically from a request.
 */
trait Paginable {

	/**
	 * Executes the 2 necessary requests : count and all.
	 *
	 * @param  Request       $request Lithium http request
	 * @param  array         $query   Model query
	 * @return PaginableSet           A paginable documents set
	 */
	public static function paginate(Request $request, array $query = []) {
		$query += ['limit' => 20];

		$page = static::_page($request);

		$total = static::count($query);
		$records = static::all([
			'page' => $page
		] + $query);

		$return = new PaginableSet($records);
		$return->meta(['page' => $page, 'total' => $total, 'limit' => $query['limit']]);

		return $return;
	}

	/**
	 * Current page
	 *
	 * @param  Request $request Lithium request
	 * @return int              Current page. Default : 1
	 */
	protected static function _page(Request $request) {
		if (isset($request->query['page']) && is_numeric($request->query['page']) && $request->query['page'] > 0) {
			return $request->query['page'];
		}

		return 1;
	}
}
