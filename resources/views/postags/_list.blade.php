<div class="list-group">
  @foreach($postags as $key=>$postag)
    @if($pos[$postag->id]!='PUNCT')
      @if($postag->difficulty=='easy' || $postag->difficulty=='very-easy' || Auth::user()->hasDoneTutorial($postag->id))
        <div class="postag list-group-item list-group-item-action {{ $postag->difficulty=='very-easy'?'':'d-none' }}" data-postag-id="{{ $postag->id }}" data-difficulty="{{ $postag->difficulty }}" data-count-todo="" 
{{--           @if($key!=0)
          data-toggle="tooltip" title="Catégorie désactivée" data-placement="left"
          @endif --}}
          >
          {{ $postag->full_name }} <em>({{ $postag->name }})</em>

          <button class="btn btn-light float-right help d-inline-block" style="z-index:1000" onclick="help=true;$('#help{{ $postag->id }}').collapse('toggle');" aria-hidden="true" data-toggle="collapse" data-target="#help{{ $postag->id }}" aria-expanded="false">
            <i class="fa fa-question-circle-o"></i>
          </button>
          <span class="count-not-validated float-right pr-2" data-postag-id="{{ $postag->id }}"></span>
          <div class="collapse clearfix mt-2" id="help{{ $postag->id }}">
            <h6>Quelques exemples :</h6>
            {!! $postag->description !!}
          </div>
        </div>
      @else
        <div class="postag list-group-item list-group-item-action disabled warning d-none" data-postag-id="{{ $postag->id }}" data-toggle="tooltip" title="Catégorie difficile, faire la formation ?" data-placement="left" data-difficulty="{{ $postag->difficulty }}" data-count-todo="">
          {{ $postag->full_name }} <em>({{ $postag->name }})</em>
          <i class="float-right fa fa-exclamation-triangle" aria-hidden="true"></i>
          <span class="count-not-validated float-right pr-2" data-postag-id="{{ $postag->id }}"></span>
        </div>
      @endif
    @endif
  @endforeach
</div>