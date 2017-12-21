<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      @if(isset($title))
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="modal-body">
        {{ $slot }}
      </div>
      @if(!isset($footer) || $footer)
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      @endif
    </div>
  </div>
</div>