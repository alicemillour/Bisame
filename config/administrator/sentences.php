<?php
return array(
    'title' => 'Sentences',
    'single' => 'sentence',
    'model' => 'App\Models\Sentence',
    'columns' => array(
        'id',
        'corpus_id',
        'position'
    ),
    'edit_fields' => array(
        'corpus' => array (
            'type' => 'relationship',
            'title' => 'Corpus',
            )
    )
);