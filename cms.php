<?php

// define the model (post type)
$cms->add('posts', function() use ($cms){

	// defin the title field
	// takes three params <name>, <validation filter>, <ui>
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