
Model-View-Controller in PHP: The right way
===============================


It's not that easy to find an accurate real-world example of MVC nowadays, so I decided to provide a detailed one (which is based on Martin Fowler's definition)



### Rule #1 : Model is a layer, and should never be a class!

If you studied many popular frameworks, you probably noted that they call objects that abstract table access and perform validation "models".
Just like as: `BookModel, PagesModel, UserModel`.

and handle records this way:

    BookModel::fetchAll();
    BookModel::findById(1);

This approach introduces major disadvantages:

 - Storage logic is tightly-coupled to domain logic. 
   
   What if you decide to switch to MongoDB/ArangoDB from MySQL in future? You will have to touch domain logic as well, which by the way has nothing to do with data storage!  What if you want only to render all records. In that case you don't care about data validation, right? But validation code is always gets inherited!

 - That breaks the Single-Responsibility-Principle
   Because so-called "model" class has more than one reason to change.

 - This eats more RAM and takes more milliseconds to parse the script.
   As mentioned in the first item, you have to parse (in most cases) a lot of code that is not related and not needed.

 - Harder to test in isolation
   Since it becomes much harder to mock objects due to global state

Calling model a class, is like calling: 

    class BookSingleResponsibilityClass {}

The core point: Model is a concept of data abstraction, a principle if you want, but not a single class!!!




### Rule #2 : Model consists of service classes.
While a service class itself consists of Data Mappers (that abstract database access) and Domain Object/Layer (that abstracts computations).
You can think of a service as a bridge between Data Mappers and Domain Objects. A model might contain several services.



### Rule #3 : View consist of two parts: UI logic and template

So what could be UI logic itself? Imagine if you were rending a drop-down menu recursively. Rendering menu has nothing to do with a model, since it's all about presentation.  So the function that does recursive rendering would go to View layer. In a template, you would call that function and `echo` its returned value.


### Rule #4: Thin controllers

Controllers are only responsible for variable assignments. (also known as "Altering state"). Controllers usually have several methods (also known as "actions"), that respond to route matches.

The typical work-flow is this:

 - A controller calls a service (from the model layer) and its desired method and passes `request` variables to it. Then the result of that call is assigned to a view.
 
 For example:
 
        public function updateAction()
        {
       	    // Grab prepared service. Assuming it has been registered in configuration before
    	    $bookManager = $this->getServiceManager()->get('bookManager');
            
        	// Grab request data
        	$data = $this->request->getPost();  // $this->request->getPost() returns a copy of $_POST
            
        	if ($bookManager->update($data)) {
                
        		$this->view->setContent('1');
                
        		// Or maybe set flash message if you use flash messenger
                
        	} else {
                
        		$this->view->setContent('0');
        	}
        }
