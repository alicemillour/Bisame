<?php
return array(
    'title' => 'Users',
    'single' => 'users',
    'model' => 'App\Models\User',
    'columns' => array(
        'id',
        'name',
        'email',
        'is_admin'
    ),
    'edit_fields' => array(
        'name',
        'email',
        'password',
        'is_admin'
    )
);