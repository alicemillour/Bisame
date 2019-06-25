<div class="card-columns">
    @each('freetexts/_show', $freetexts, 'freetext', 'freetexts/_empty')
</div>

<div class="d-flex justify-content-center">
    {{ $freetexts->links() }}
</div>
