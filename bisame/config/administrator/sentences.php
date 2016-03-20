<?php
return array(
    'title' => 'Sentences',
    'single' => 'sentence',
    'model' => 'App\Models\Sentence',
    'columns' => array(
        'id'
    ),
    'edit_fields' => array(
        'corpus' => array (
            'type' => 'relationship',
            'title' => 'Corpus',
            )
    )
);