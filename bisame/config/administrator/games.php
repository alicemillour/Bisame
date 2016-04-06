<?php
return array(
    'title' => 'Games',
    'single' => 'game',
    'model' => 'App\Models\Game',
    'columns' => array(
        'id',
        'user_name' => array(
			'title' => "User",
    		'relationship' => 'user', //this is the name of the Eloquent relationship method!
    		'select' => "(:table).name",
		),
		'created_at',
		'is_finished'
    ),
    'edit_fields' => array(
		'sentences' => array(
		    'type' => 'relationship',
		    'title' => 'Sentences',
		    'name_field' => 'id'
		),
		'user' => array(
		    'type' => 'relationship',
		    'title' => 'User',
		    'name_field' => 'name'
		)
    )
);