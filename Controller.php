<?php

/**
 * Pure MVC for web demonstration
 * 
 * Copyright (c) No Global State Lab
 */

namespace Mvc;

/**
 * Controllers in MVC are responsible for variable assignments (also known as altering state). 
 * In most cases their actions simply send a content of request variables to services.
 * 
 * The work-flow is this:
 * 
 * - You call a registered service (Service management must be implemented within your framework)
 * - You call some method passing request variables (When needed)
 * - You pass what a service returned to a view (you alter view's state)
 * 
 * Remember, controllers DO NOT responsible for:
 * 
 * - Data processing. 
 *   The typical sign of data processing is having some kind of foreach iteration with nested if condition.
 *   Even if you're uploading an image and want to check if an image is attached, then you would do that in service. 
 *   In controller, you would simply pass $_POST and $_FILES to that service.
 *  
 * - For registering services 
 *   Controllers only know how to use services, they must not be aware of how to register or build them
 *  
 * - For accessing database
 *   Controllers don't even know that such thing as database exists.
 *    
 *   -> They only aware of services. 
 *     -> Services aware of data mappers.
 *       -> Data mappers aware of PDO and things like that
 * 
 */
class Controller
{
	/**
	 * Returns book manager
	 */
	private function getBookManager()
	{
		// Assuming this functionality has been implemented by you, and that getService() returns prepared instance of \Mvc\Service\BookManager
		return $this->getServiceManager()->getService('bookManager');
	}

	/**
	 * Assuming that this action responds to some route
	 * i.e it gets called automatically when its attached route map is executed
	 * 
	 * This will show all available books, i.e the template's grid
	 */
	public function indexAction()
	{
		// Alter view's state. Set template path and define its variables
		// The view must be implemented by you and it should be a service which gets injected automatically
		$this->view->prepare('template.phtml', array(
			'books' => $this->getBookManager()->fetchAll()
		));
	}

	/**
	 * This action must respond to some route which invokes deleting
	 */
	public function deleteAction()
	{
		$id = $this->request->getPost('id'); // This is an equivalent to $_POST['id']

		$this->getBookManager()->deleteById($id);
	}

	// And so on
}
