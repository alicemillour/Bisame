<?php
return array(
    'title' => 'Users',
    'single' => 'user',
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