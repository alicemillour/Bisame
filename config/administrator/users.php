<?php
return array(
    'title' => 'Users',
    'single' => 'users',
    'model' => 'App\Models\User',
    'columns' => array(
        'id',
        'name',
        'email',
        'is_admin',
        'is_in_training'
    ),
    'edit_fields' => array(
        'name',
        'email',
        'password',
        'is_admin',
        'is_in_training'
    )
);