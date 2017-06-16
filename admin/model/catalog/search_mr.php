<?php

class ModelCatalogSearchMr extends Model {

	public function getDefaultOptions() {

		return array(
			'key' => 'b4cce75558c444d4953dc218c0803b46',
			'min_word_length' => 2,
			'cache_results' => 1,
			'fields' => array(
				'name' => array(
					'search' => 'contains',
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 80,
						'phrase' => 60,
						'word' => 40
					)
				),
				'description' => array(
					'search' => 'contains',
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 20,
						'word' => 10
					)
				),
				'tags' => array(
					'search' => 'contains',
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 45
					)
				),
				'attributes' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'model' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'exclude_characters' => '-/_',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'sku' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'upc' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'ean' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'jan' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'isbn' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
				'mpn' => array(
					'search' => 0,
					'phrase' => 'cut',
					'use_morphology' => 1,
					'use_relevance' => 1,
					'logic' => 'OR',
					'relevance' => array(
						'start' => 0,
						'phrase' => 0,
						'word' => 0
					)
				),
			),
		);
	}

	public function getFields() {

		return array('name',
			'description',
			'tags',
			'attributes',
			'model',
			'sku',
			'upc',
			'ean',
			'jan',
			'isbn',
			'mpn');
	}

	public function install() {
		
				
		$a58e0b8784b4a3f354df27407a441a46e = array (
						'model' => true,
			'sku' => true,
			'upc' => true,
			'ean' => true,
			'jan' => true,
			'isbn' => true,
			'mpn' => true
		);
		
		$a062ef8da64c379dbde079d1c0bc10b77 = $this->db->query("SHOW INDEX FROM " . DB_PREFIX . "product");
		
		foreach ($a062ef8da64c379dbde079d1c0bc10b77->rows as $ac23d40c432e5bbfb1c5ec1df65eb3e64) {
						if (isset($ac23d40c432e5bbfb1c5ec1df65eb3e64['Column_name']) && array_key_exists($ac23d40c432e5bbfb1c5ec1df65eb3e64['Column_name'], $a58e0b8784b4a3f354df27407a441a46e)) {
				$a58e0b8784b4a3f354df27407a441a46e[$ac23d40c432e5bbfb1c5ec1df65eb3e64['Column_name']] = false;
			}
		}
		
		foreach ($a58e0b8784b4a3f354df27407a441a46e as $a320946f0b463a80e1b3a6ea2165043e6 => $aa264ae689628654f4784f73efa59f16c) {
			if ($aa264ae689628654f4784f73efa59f16c) {
				$this->db->query("ALTER TABLE " . DB_PREFIX . "product ADD INDEX ( " . $a320946f0b463a80e1b3a6ea2165043e6 . " )");
			}
		}				
	}
}
//author sv2109 (sv2109@gmail.com) license for 1 product copy granted for Lixor (nikita@mt21.ru mt21.ru)
