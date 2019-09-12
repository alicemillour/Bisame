<div class="card-columns">
    @each('proverbs/_show', $proverbs, 'proverb', 'proverbs/_empty')
</div>

<div class="d-flex justify-content-center">
    {{ $proverbs->links() }}
</div>
