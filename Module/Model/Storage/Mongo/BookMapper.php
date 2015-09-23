<?php

/**
 * Pure MVC for web demonstration
 * 
 * Copyright (c) No Global State Lab
 */

namespace Module\Model\Storage\MySQL;

use Module\Model\Storage\BookMapperInterface;
use MongoClient;
use MongoId;

/**
 * This mapper abstracts 
 */
final class BookMapper implements BookMapperInterface
{
	/**
	 * Mongo instance
	 * 
	 * @var \MongoClient
	 */
	private $mongoClient;

	/**
	 * Database name
	 * 
	 * @var string
	 */
	private $db = 'db';

	/**
	 * Target collection
	 * 
	 * @var string
	 */
	private $collection ='books';

	/**
	 * State initialization
	 * 
	 * @param \MongoClient $mongoClient
	 * @return void
	 */
	public function __construct(MongoClient $mongoClient)
	{
		$this->mongoClient = $mongoClient;
	}

	/**
	 * Returns Mongo collection
	 * 
	 * @return object
	 */
	private function getCollection()
	{
		return $this->mongoClient->{$this->db}->{$this->collection};
	}

	/**
	 * Deletes a book by its associated id
	 * 
	 * @param string $id
	 * @return boolean
	 */
	public function deleteById($id)
	{
		return $this->getCollection()->remove(array('id' => $id), false);
	}
	
	/**
	 * Fetches all rows
	 * 
	 * @return array
	 */
	public function fetchAll()
	{
		return $this->getCollection()->find();
	}

	/**
	 * Fetches a book by its associated id
	 * 
	 * @param string $id
	 * @return array
	 */
	public function fetchById($id)
	{
		return $this->getCollection()->findOne(array('id' => new MongoId($id)));
	}

	/**
	 * Inserts a new book
	 * 
	 * @param string $name
	 * @param string $author
	 * @param string $cover
	 * @return boolean
	 */
	public function insert($name, $author, $cover)
	{
		// Mongo doesn't support AUTO_INCREMENTS, so we have to generate the id manually
		$id = uniqid();

		$data = array(
			'id' => $id,
			'name' => $name,
			'author' => $author,
			'cover' => $cover
		);

		return $this->getCollection()->insert($data);
	}

	/**
	 * Updates a book
	 * 
	 * @param string $id
	 * @param string $name
	 * @param string $author
	 * @param string $cover
	 * @return boolean
	 */
	public function update($id, $name, $author, $cover)
	{
		$data = array(
			'id' => $id,
			'name' => $name,
			'author' => $author,
			'cover' => $cover
		);

		return $this->getCollection()->update($data);
	}
}
