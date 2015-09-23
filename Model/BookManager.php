<?php

/**
 * Pure MVC for web demonstration
 * 
 * Copyright (c) No Global State Lab
 */

namespace Mvc\Model;

use Mvc\Storage\BookMapperInterface;

/**
 * A service is just a bridge between data mappers and domain objects, which later gets called inside controllers.
 * 
 * A domain object is a tool/parser that does computations. A domain object can be a library as well (like a library that does image resizing, cropping etc).
 * A domain object is not required. Totally optional, it's all up to your requirements.
 * 
 * You can also have several domain object (a.k.a domain layer), but that's not a good practise since you might end up with a long list of arguments to be passed to constructor.
 * In case you're writing several domain object, try to wrap everything into the one and abstract its instantiation via factory.
 * 
 */
class BookManager
{
	
	private $bookMapper;
	
	
	public function __construct(BookMapperInterface $bookMapper)
	{
		$this->bookMapper = $bookMapper;
	}

	/**
	 * Fetches all records from a mapper
	 * 
	 * In case you need to append some additional keys or to parse the initial result-set, do it inside this method
	 * 
	 * @return array
	 */
	public function fetchAll()
	{
		return $this->bookMapper->fetchAll();
	}

	/**
	 * An copy of input must be passed to this method
	 * In case you're managing files, the checking also needs to be done here (not in the controller!)
	 * 
	 * @param array $input
	 */
	public function add(array $input)
	{
		/**
		 * Implement a logic which is responsible for adding records here.
		 * Use data mappers and domain objects here. Make them work together here
		 * 
		 */
	}
	
	// ... The rest ...
}
