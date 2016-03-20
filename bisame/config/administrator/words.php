<?php
return array(
    'title' => 'Words',
    'single' => 'word',
    'model' => 'App\Models\Word',
    'columns' => array(
        'id',
        'value',
        'sentence_id',
    ),
    'edit_fields' => array(
        'value',
        'sentence' => array (
            'type' => 'relationship',
            'title' => 'Sentence',
            'name_field' => 'name',
            )
    )
);