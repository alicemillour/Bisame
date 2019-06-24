<div class="card-columns">
    @each('poems/_show', $poems, 'poem', 'poems/_empty')
</div>

<div class="d-flex justify-content-center">
    {{ $poems->links() }}
</div>
