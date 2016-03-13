<?php
return array(
    'title' => 'Users',
    'single' => 'users',
    'model' => 'App\Models\User',
    'columns' => array(
        'id',
        'name',
        'email',
    ),
    'edit_fields' => array(
        'name',
        'email',
        'password'
    )
);