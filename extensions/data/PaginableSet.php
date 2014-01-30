<?php
namespace li3_pagination\extensions\data ;

use lithium\data\collection\DocumentSet;

/**
 * Paginable documents set.
 */
class PaginableSet implements \IteratorAggregate, \Countable {

	/**
	 * Pagination meta data.
	 *
	 * @var array
	 */
	protected $_meta = array();

	/**
	 * Constructor.
	 *
	 * @param DocumentSet $set  Original ocuments set
	 * @param array       $meta (optional) Meta data
	 */
	public function __construct(DocumentSet $documents = null, array $meta = null) {
		if (isset($documents)) {
			$this->_documents = $documents;
		}
		if (isset($meta)) {
			$this->_meta = $meta;
		}
	}

	/**
	 * Access to the real documents set
	 *
	 * @return \lithium\data\collection\DocumentSet Set de document
	 */
	public function documents(DocumentSet $documents = null) {
		if (!isset($documents)) {
			return $this->_documents;
		}

		$this->_documents = $documents;
	}

	/**
	 * Getter/setter : meta data
	 *
	 * @param  array $meta Setter : meta array
	 * @return array       Getter : meta array
	 */
	public function meta($meta = null) {
		if (!isset($meta)) {
			return $this->_meta;
		}

		$this->_meta = $meta + $this->_meta;
	}

	/**
	 * Magical accessor.
	 *
	 * Example :
	 * {{{
	 * $set->limit ; // Access to $this->_meta['limit']
	 * }}}
	 *
	 * @param  string $key Key we want to access to
	 * @return mixed       Value
	 */
	public function __get($key) {
		return isset($this->_meta[$key]) ? $this->_meta[$key] : null;
	}

	/**
	 * Transform into any data type.
	 *
	 * @param  string $format  Destination format
	 * @param  array  $options Options
	 * @return mixed           Formated data
	 */
	public function to($format, array $options = []) {
		return $this->_documents->to($format, $options);
	}

	/**
	 * Implemets IteratorAggregate.
	 *
	 * @return Iterator Documents set
	 */
	public function getIterator() {
		return $this->_documents;
	}

	/**
	 * Implements Countable.
	 *
	 * @return int Documents count
	 */
	public function count() {
		return $this->_documents->count();
	}
}
