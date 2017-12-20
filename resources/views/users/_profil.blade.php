{!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user]]) !!}

  <div class="form-group row">
    {!! Form::label('name', __('users.attributes.name'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required', 'readonly']) !!}

      @if ($errors->has('name'))
          <span class="invalid-feedback">{{ $errors->first('name') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('email', __('users.attributes.email'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), '', 'readonly']) !!}

      @if ($errors->has('email'))
          <span class="invalid-feedback">{{ $errors->first('email') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('password', __('users.attributes.password'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password'), 'readonly']) !!}

      @if ($errors->has('password'))
          <span class="invalid-feedback">{{ $errors->first('password') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group form-group-hidden d-none row">
    {!! Form::label('password_confirmation', __('users.attributes.password_confirmation'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation')]) !!}

      @if ($errors->has('password_confirmation'))
          <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group form-group-show">
    <button id="edit_profil" class="btn btn-success">Editer mon profil</button>
  </div>
  <div class="form-group form-group-hidden d-none">
    <a id="cancel_edit" href="{{ route('users.show', $user) }}" class="btn btn-secondary">{{ __('forms.actions.cancel') }}</a>
    {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-success']) !!}
  </div>

{!! Form::close() !!}

<h4 class="card-title">Informations facultatives</h4>
<div class="form-group">
  {!! Form::label('age_group_id', __('Quel est votre âge ?'), ['class' => '']) !!}
  <div class="custom-controls-stacked">

    @foreach($age_groups as $age_group)
      <label class="custom-control custom-radio radio-age">
        <input id="radio1" name="age_group_id" type="radio" value="{{ $age_group->id }}" class="custom-control-input" {{ ($age_group->id==$user->age_group_id)?'checked':'' }}>
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description">{{ __('users.age-group.'.$age_group->slug) }}</span>
      </label>
    @endforeach

  </div>
</div>
<div class="form-group">
  {!! Form::label('position', __('Où avez-vous appris l\'alsacien ?'), ['class' => '']) !!}
  <div class="custom-controls-stacked">  
  <label class="custom-control custom-radio radio-position">
    <input id="radio-position-1" name="radio" type="radio" class="custom-control-input">
    <span class="custom-control-indicator"></span>
    <span class="custom-control-description">{{ __('users.dk') }}</span>
  </label>
  <label class="custom-control custom-radio radio-position" data-toggle="" data-target="#collapseMap" aria-expanded="false" aria-controls="collapseMap">
    <input id="radio-position-2" name="radio" type="radio" class="custom-control-input">
    <span class="custom-control-indicator"></span>
    <span class="custom-control-description">{{ __('users.place-on-a-map') }}</span>
  </label>
  </div>
  <div class="collapse" id="collapseMap">
    <div>
      <button class="btn btn-success btn-sm" id="modify-position">Modifier ma position</button>
    </div>
    <div class="alert alert-info explanation-map d-none">
      <em>Cliquez sur la carte à l'endroit où vous avez appris l'alsacien :</em>
    </div>
    <div style="position:relative;">
      <img style="position:relative;left:0;top:0;width:30%;" id="map" src="{{ asset('img/Carte_Alsace.svg') }}" />
      <i id="anchor" style="position:absolute;" class="fa fa-child fa-2x d-none" aria-hidden="true"></i>
    </div>
  </div>
</div>

@section('scripts')
  <script type="text/javascript">
var posX = {{ $user->posX }};
var posY = {{ $user->posY }};
var can_modify_position = false;
    function placeAnchor(){
      if(posX>0&&posY>0) {
        $('#anchor').removeClass('d-none');
        $('#collapseMap').collapse('show');
        $('#radio-position-2').prop("checked",true);
        var width_map = parseInt($('#map').css("width"),10);
        var height_map = parseInt($('#map').css("height"),10);      
        var posX_anchor =  posX * width_map;
        var posY_anchor =  posY * height_map;
        var height = $('#anchor').css("height");
        var width = $('#anchor').css("width");      
        $('#anchor').css("left",posX_anchor - parseInt(width,10)/2);
        $('#anchor').css("top",posY_anchor - parseInt(height,10));
      } else {
        $('#anchor').addClass('d-none');
      }
    }
    $('.radio-position').click(function(e){
      if($('#radio-position-2').prop("checked")){
        $('#collapseMap').collapse('show');
        can_modify_position = true;
        $('#modify-position').hide();
        $('.explanation-map').removeClass('d-none');
        $('#map').css({'width':'100%'});
        placeAnchor();   
      } else {
        $('#collapseMap').collapse('hide');
        posX = 0;
        posY = 0;
        $.post( "{{ route('users.update-position') }}", {
          posX: 0, 
          posY: 0
        }).done(function( data ) {

        }).fail(function( data ) {
          alert( "Erreur lors de la mise à jour du profil" );
        });        
      }
    });

    $('.radio-age').change(function(e){
        $.post( "{{ route('users.update-age') }}", {
          age_group_id: $('input[name=age_group_id]:checked').val()
        }).done(function( data ) {

        }).fail(function( data ) {
          alert( "Erreur lors de la mise à jour du profil" );
        });
    });

    $('#map').click(function(e){
        if(!can_modify_position) return false;
        var offsetX = $(this).offset().left,
            offsetY = $(this).offset().top;
        var posX_relative = $(this).position().left,
            posY_relative = $(this).position().top;
        var width_map = parseInt($('#map').css("width"),10);
        var height_map = parseInt($('#map').css("height"),10);
        var height = $('#anchor').css("height");
        var width = $('#anchor').css("width");
        var posX_anchor = e.pageX - offsetX;
        var posY_anchor = e.pageY - offsetY;
        posX = posX_anchor / width_map;
        posY = posY_anchor / height_map;
        $('#anchor').css("left",posX_anchor - parseInt(width,10)/2);
        $('#anchor').css("top",posY_anchor - parseInt(height,10));
        $.post( "{{ route('users.update-position') }}", {
          posX: posX, 
          posY: posY
        }).done(function( data ) {
          $('.explanation-map').addClass('d-none');
          $('#modify-position').show();
          $('#map').css({'width':'30%'});
          can_modify_position = false;
          placeAnchor();
        }).fail(function( data ) {
          alert( "Erreur lors de la mise à jour du profil" );
        });        
    })

    $('#edit_profil').click(function(event){
      event.preventDefault();
      $('.form-control').attr('readonly',null);
      $('.form-group-hidden').removeClass('d-none');
      $('.form-group-show').addClass('d-none');
    })
    $('#cancel_edit').click(function(event){
      event.preventDefault();
      $('.form-control').attr('readonly',"true");
      $('.form-group-hidden').addClass('d-none');
      $('.form-group-show').removeClass('d-none');
    })
    $('#modify-position').click(function(event){
      event.preventDefault();
      can_modify_position = true;
      $(this).hide();
      $('.explanation-map').removeClass('d-none');
      $('#map').css({'width':'100%'});
      placeAnchor();
    })
    $('#cancel-modify-position').click(function(event){
      event.preventDefault();
      can_modify_position = false;
      $('.explanation-map').addClass('d-none');
      $('#modify-position').show();
      $('#map').css({'width':'30%'});
      placeAnchor();
    })
    
    window.onload = function() {
      if(posX>0&&posY>0) {
        placeAnchor();
      } else {
        $('#radio-position-1').prop("checked",true);
      }
    };
    $( window ).resize(function() {
      placeAnchor();
    });
  </script>
@endsection