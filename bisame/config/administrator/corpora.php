<?php
return array(
    'title' => 'Corpora',
    'single' => 'corpus',
    'model' => 'App\Models\Corpus',
    'columns' => array(
        'id'
    ),
    'edit_fields' => array(
        'sentences' => array (
            'type' => 'relationship',
            'title' => 'Sentences',
            'name_field' => 'name',
            )
    )
);