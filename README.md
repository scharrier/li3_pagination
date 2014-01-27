li3_pagination
==============

Lithium doesn't suck. This is a fact. But hey, what's about pagination ? Not natively included in the framework, all the
existing plugins are just wrong. Pagination is a really common thing : we, developers, have to paginate everything, everytime.

It has to be simple. And you know what ? With li3_pagination, it is.

Install
-------

The easiest way to install li3_pagination is to use composer, adding this lines in your composer.json file:

```json
{
	"require" : {
		"scharrier/li3_pagination" : "dev-master"
	}
}
```

Tell composer to install it :
```
composer install
```

And finally, load the library:
```php
// config/bootstrap/libraries.php
Libraries::add('li3_pagination') ;
```

Using li3_pagination
--------------------

In your model, just use the good trait :
```php
class MyModel extends \lithium\data\Model {

	use \li3_pagination\extensions\data\Paginable ;

}
```

The trait add a method paginate() to your model. Now, call it directly from your controller instead of a standard find() :
```php
public function index() {
	$records = Records::paginate($this->request, [
		'limit' => 20,
		'order' => ['field' => 'asc'],
		'conditions' => [
			'your' => ['custom' => 'conditions']
		]
	]);
}
```

And finally, just give your paginable records set to the Pagination helper in your view :
```php
$this->pagination->paginate($records) ;
```

Yep. That's all.

Help and support
----------------

Fork it, play with it, commit if needed and pull request ! Ask your questions or tell me about problemes you have in the repo issues.
