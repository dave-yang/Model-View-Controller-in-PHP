<?php

/**
 * Pure MVC for web demonstration
 * 
 * (c) David Yang
 */

namespace Mvc\Model\Storage;

/* No matter what kind of data storage you're going to use. They all must implement this interface */
interface BookMapperInterface
{
	/**
	 * Adds a new book
	 * 
	 * @param string $name
	 * @param string $author
	 * @param string $cover
	 * @return boolean
	 */
	public function insert($name, $author, $cover);

	/**
	 * Updates a book
	 * 
	 * @param string $id
	 * @param string $name
	 * @param string $author
	 * @param string $cover
	 * @return boolean
	 */
	public function update($id, $name, $author, $cover);

	/**
	 * Deletes a book by its associated id
	 * 
	 * @param string $id
	 * @return boolean
	 */
	public function deleteById($id);

	/**
	 * Fetches a book by its associated id
	 *  
	 * @param string $id
	 * @return array
	 */
	public function fetchById($id);
}
