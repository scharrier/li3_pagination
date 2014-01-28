<?php
namespace li3_pagination\extensions\data ;

use lithium\action\Request;
use li3_pagination\extensions\data\PaginableSet;

/**
 * Prend en charge la pagination depuis une requête HTTP.
 */
trait Paginable {

	/**
	 * Exécute les deux requêtes nécessaires à la pagination : le count et la récupération des résultats
	 * de la page courant.
	 *
	 * @param  Request $request Requête Lithium
	 * @param  array  $query    Paramètres complémentaires de requêtage
	 * @return PaginableSet     Set de données pris en charge par le helper de pagination
	 */
	public static function paginate(Request $request, array $query = []) {
		$query += ['limit' => 20] ;

		$page = static::_page($request) ;

		$total = static::count($query) ;
		$records = static::all([
			'page' => $page
		] + $query) ;

		$return = new PaginableSet($records) ;
		$return->meta(['page' => $page, 'total' => $total, 'limit' => $query['limit']]) ;

		return $return ;
	}

	/**
	 * Récupère le numéro de la page courante
	 *
	 * @param  Request $request Requête Lithium
	 * @return int              Page courante. 1 par défaut.
	 */
	protected static function _page(Request $request) {
		if (isset($request->query['page']) && is_numeric($request->query['page']) && $request->query['page'] > 0) {
			return $request->query['page'] ;
		}

		return 1 ;
	}
}
