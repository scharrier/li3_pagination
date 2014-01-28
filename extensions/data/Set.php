<?php
namespace li3_pagination\extensions\data ;

use lithium\data\collection\DocumentSet;

/**
 * Set de données embarquant les méta de pagination. Evite d'avoir à transmettre
 * des trucs à la main. Un peu hacky sur les bords, mais ça va être bien pratique.
 */
class Set implements \IteratorAggregate, \Countable {

	/**
	 * Meta données de pagination.
	 *
	 * @var array
	 */
	protected $_meta = array() ;

	/**
	 * Constructeur.
	 * @param DocumentSet $set  Set de données
	 * @param array       $meta (optionnel) Méta données
	 */
	public function __construct(DocumentSet $documents = null, array $meta = null) {
		if (isset($documents)) {
			$this->_documents = $documents ;
		}
		if (isset($meta)) {
			$this->_meta = $meta ;
		}
	}

	/**
	 * Permet d'accéder au vrai set.
	 *
	 * @return \lithium\data\collection\DocumentSet Set de document
	 */
	public function documents(DocumentSet $documents = null) {
		if (!isset($documents)) {
			return $this->_documents ;
		}

		$this->_documents = $documents ;
	}

	/**
	 * Getter/setter de méta données.
	 *
	 * @param  array $meta Setter : tableau de méta
	 * @return array       Getter : tableau de méta
	 */
	public function meta($meta = null) {
		if (!isset($meta)) {
			return $this->_meta ;
		}

		$this->_meta = $meta + $this->_meta ;
	}

	/**
	 * Accessor magique. Permet d'accéder aux méta donnée en direct.
	 *
	 * Exemple :
	 * {{{
	 * $set->limit ; // Accède à $this->_meta['limit']
	 * }}}
	 *
	 * @param  string $key Clé à laquelle on veut accéder
	 * @return mixed       Valeur
	 */
	public function __get($key) {
		return isset($this->_meta[$key]) ? $this->_meta[$key] : null ;
	}

	/**
	 * Implémentation d'IteratorAggregate. Retourne le vrai itérator.
	 *
	 * @return Iterator Le set de documents
	 */
	public function getIterator() {
		return $this->_set ;
	}

	/**
	 * Implémentation de Countable.
	 *
	 * @return int Nombre de documents dans le set
	 */
	public function count() {
		return $this->_set->count() ;
	}
}
