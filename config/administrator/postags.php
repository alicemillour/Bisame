<?php
return array(
    'title' => 'Postags',
    'single' => 'postag',
    'model' => 'App\Models\Postag',
    'columns' => array(
        'id',
        'name',
        'category',
        'full_name'
    ),
    'edit_fields' => array(
        'name',
        'category',
        'description',
        'full_name'
    )
);