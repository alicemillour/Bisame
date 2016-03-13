<?php
return array(
    'title' => 'Annotations',
    'single' => 'annotation',
    'model' => 'App\Models\Annotation',
    'columns' => array(
        'id',
        'confidence_score'
    ),
    'edit_fields' => array(
        'name',
        'user' => array (
            'type' => 'relationship',
            'title' => 'Users',
            'name_field' => 'name',
            ),
        'word' => array (
            'type' => 'relationship',
            'title' => 'Mots',
        )

    )
);