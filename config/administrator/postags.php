<?php
return array(
    'title' => 'Postags',
    'single' => 'postag',
    'model' => 'App\Models\Postag',
    'columns' => array(
        'name',
        'category',
    ),
    'edit_fields' => array(
        'name',
        'category',
        'description'
    )
);