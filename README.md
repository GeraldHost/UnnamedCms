# UnnamedCms
If you've got any good ideas for names let me know.

# What
An open source content management system built with a strict content model structure.

# Motivation
As current content management systems move further and further away from the simple routes and 
become heavier and heavier to port around I wanted to create something that was lightweight. 
I wanted to build something that would handle the content management but allowed developers to build
the additional functionality around it without coming with a hundred other features that bloat the
service and overcomplicate things. 

I'm a big fan of using micro frameworks over larger systems because I appriciate lean well thoughtout code
with only the bits you will use.

# Getting Started
This project is currently in it's early stages. I hope to build it out to be fully supported.
The following is the basic idea:

```php
// define the model (post type)
$cms->add('posts', function() use ($cms){

  // define the title field
	// takes three params <name>, <validation filter>, <ui component>
	$cms->field('title', 
		function(){ return true; }, 
		function($value){ return "<input value='$value'/>"; }
	);

	// define the body field
	$cms->field('body', 
		function(){ return true; },
		function($value){ return "<textarea>$value</textarea>"; }
	);

});
```
