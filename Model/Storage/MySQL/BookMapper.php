<?php

/**
 * Pure MVC for web demonstration
 * 
 * Copyright (c) No Global State Lab
 */

namespace Mvc\Model\Storage\MySQL;

use PDO;
use Mvc\Model\Storage\BookMapperInterface;

/**
 * A mapper is a class that abstracts storage interactions.
 * This one is meant for MySQL
 * 
 * For the sake of simplicity, the raw PDO instance is used.
 * In real-world scenarios, that should really be managed by some kind of query builders.
 * 
 */
class BookMapper implements BookMapperInterface
{
	/**
	 * Prepared PDO instance
	 * 
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * Name of the table which is being abstracted
	 * 
	 * @var string
	 */
	private $table = 'books';

	/**
	 * State initialization
	 * 
	 * @param \PDO $pdo
	 * @return void
	 */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Adds a new book
	 * 
	 * In real-world scenarios, you could have more arguments.
	 * In that case, you'd better pass an array of data, instead of arguments, 
	 * so that the method won't look as it has too many arguments
	 * 
	 * @param string $name
	 * @param string $author
	 * @param string $cover
	 * @return boolean
	 */
	public function insert($name, $author, $cover)
	{
		$query = sprintf('INSERT INTO `%s` (`name`, `author`, `cover`) VALUES (:name, :author, :cover)');

		$stmt = $this->pdo->prepare($query);
		return $stmt->execute(array(
			':name' => $name,
			':author' => $author,
			':cover' => $cover,
		));
	}

	/**
	 * Updates a book
	 * 
	 * In real-world scenarios, you could have more arguments.
	 * In that case, you'd better pass an array of data, instead of arguments, 
	 * so that the method won't look as it has too many arguments
	 * 
	 * @param string $id
	 * @param string $name
	 * @param string $author
	 * @param string $cover
	 * @return boolean
	 */
	public function update($id, $name, $author, $cover)
	{
		$query = sprintf('UPDATE `%s` SET `name` =:name, `author` =:author, `cover` =:cover WHERE `id` =:id', $this->table);

		$stmt = $this->pdo->prepare($query);
		return $stmt->execute(array(

			':id' => $id,
			':name' => $name,
			':author' => $author,
			':cover' => $cover
		));
	}

	/**
	 * Deletes a book by its associated id
	 * 
	 * @param string $id
	 * @return boolean
	 */
	public function deleteById($id)
	{
		$query = sprintf('DELETE FROM `%s` WHERE `id` =:id', $this->table);

		$stmt = $this->pdo->prepare($query);
		return $stmt->execute(array(
			':id' => $id
		));
	}

	/**
	 * Fetches a book by its associated id
	 *  
	 * @param string $id
	 * @return array
	 */
	public function fetchById($id)
	{
		$query = sprintf('SELECT * FROM `%s` WHERE `id` =:id', $this->table);

		$stmt = $this->pdo->prepare($query);
		$stmt->execute(array(
			':id' => $id
		));

		return $stmt->fetch();
	}

	/**
	 * Fetches all books
	 * 
	 * @return array
	 */
	public function fetchAll()
	{
		$query = sprintf('SELECT * FROM `%s`', $this->table);
		return $this->pdo->query($query);
	}
}
