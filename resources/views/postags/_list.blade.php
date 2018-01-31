<div class="list-group">
  @foreach($postags as $key=>$postag)
    @if($pos[$postag->id]!='PUNCT')
      @if($postag->difficulty=='easy' || Auth::user()->hasDoneTutorial($postag->id))
        <div class="postag list-group-item list-group-item-action {{ $key==0?'':'disabled' }}" data-postag-id="{{ $postag->id }}" 
          @if($key!=0)
          data-toggle="tooltip" title="Catégorie désactivée" data-placement="left"
          @endif
          >
          {{-- <div style="width:80%"> --}}
            {{ $postag->full_name }} <em>({{ $postag->name }})</em>
          {{-- </div> --}}
{{--           <div style="width:20%">
            <button class="btn btn-light float-right help">
            <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="collapse" data-target="#help{{ $postag->id }}" aria-expanded="false"></i>
            </button>
          </div> --}}
          <button class="btn btn-light float-right help d-inline-block" style="z-index:1000" onclick="help=true;$('#help{{ $postag->id }}').collapse('toggle');" aria-hidden="true" data-toggle="collapse" data-target="#help{{ $postag->id }}" aria-expanded="false">
            <i class="fa fa-question-circle-o"></i>
          </button>
          <div class="collapse clearfix mt-2" id="help{{ $postag->id }}">
            <h6>Quelques exemples :</h6>
            {!! $postag->description !!}
          </div>          
        </div>
      @else
        <div class="postag list-group-item list-group-item-action disabled warning" data-postag-id="{{ $postag->id }}" data-toggle="tooltip" title="Catégorie difficile, faire la formation ?" data-placement="left">
          {{ $postag->full_name }} <em>({{ $postag->name }})</em><i class="float-right fa fa-exclamation-triangle" aria-hidden="true"></i>
        </div>
      @endif
{{-- 
      <div class="list-group-item-action collapse" id="help{{ $postag->id }}">
        {!! $postag->description !!}
      </div> --}}

    @endif
  @endforeach
</div>