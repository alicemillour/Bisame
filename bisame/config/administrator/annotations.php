<?php
return array(
    'title' => 'Annotations',
    'single' => 'annotation',
    'model' => 'App\Models\Annotation',
    'columns' => array(
        'id',
        'word_id',
        'postag_id',
        'confidence_score'
    ),
    'edit_fields' => array(
        'user' => array (
            'type' => 'relationship',
            'title' => 'User',
            'name_field' => 'name',
            ),
        'word' => array (
            'type' => 'relationship',
            'title' => 'Mot',
            'name_field' => 'value',
        ),
        'postag' => array (
            'type' => 'relationship',
            'title' => 'POS-tag',
            'name_field' => 'name',
        )

    )
);