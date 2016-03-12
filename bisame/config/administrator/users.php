<?php
return array(
    'title' => 'Users',
    'single' => 'user',
    'model' => 'App\Models\User',
    'columns' => array(
        'id',
        'name'
    ),
    'edit_fields' => array(
        'name' => array(
            'title' => 'First Name',
            'type' => 'text',
        ),
    )
);