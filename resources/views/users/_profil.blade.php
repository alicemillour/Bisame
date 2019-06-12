{!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user]]) !!}
<h4 class="card-title" id="title-avatar">Votre profil</h4>
  <div class="form-group row">
    {!! Form::label('name', __('users.attributes.name'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required', '','readonly']) !!}

      @if ($errors->has('name'))
          <span class="invalid-feedback">{{ $errors->first('name') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('email', __('users.attributes.email'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), '', '']) !!}

      @if ($errors->has('email'))
          <span class="invalid-feedback">{{ $errors->first('email') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group text-right">
    {{-- <a id="cancel_edit" href="{{ route('users.show', $user) }}" class="btn btn-secondary">{{ __('forms.actions.cancel') }}</a> --}}
    {!! Form::submit("Enregistrer mon profil", ['class' => 'btn btn-success']) !!}
  </div>
{!! Form::close() !!}
<hr/>

<h4 class="card-title mt-3" id="title-infos">Informations facultatives</h4>
<div class="row">
  <div class="form-group col-6">
    <div id="message-age" class="text-danger"></div>
    {!! Form::label('age_group_id', __('Quel est votre âge ?'), ['class' => '']) !!}
    <div class="custom-controls-stacked">

      @foreach($age_groups as $age_group)
      <div class="form-check">
                <input id="radio1" name="age_group_id" type="radio" id="age_group{{ $age_group->id }}" value="{{ $age_group->id }}" class="form-check-input radio-age" {{ ($age_group->id==$user->age_group_id)?'checked':'' }}>
        <label class="form-check-label" for="age_group{{ $age_group->id }}">
          {{ __('users.age-group.'.$age_group->slug) }}
        </label>
      </div>       
      @endforeach

    </div>
    <hr/>
    <div id="message-languages" class="text-danger"></div>
    <form id="form-languages">
    {!! Form::label('age_group_id', __('Quelle(s) langue(s) parlez-vous ?'), ['class' => '']) !!}
    <div class="custom-controls-stacked">

      @foreach($languages as $language)
      <div class="form-check">
          <input id="radio1" name="languages[]" type="checkbox" id="language{{ $language->id }}" value="{{ $language->id }}" class="form-check-input radio-language" {{ ($user->hasLanguage($language->id))?'checked':'' }}>
        <label class="form-check-label" for="language{{ $language->id }}">
          {{ __('users.language.'.$language->slug) }}
        </label>
      </div>       
      @endforeach

    </div>
    <div class="form-group text-right">
      {!! Form::submit("Enregistrer mes langues", ['id' => 'save-languages','class' => 'btn btn-success']) !!}
    </div>
    </form>   
  </div>

  <div class="form-group col-6 border border-right-0 border-top-0 border-bottom-0">
    {!! Form::label('position', __('Où avez-vous appris le créole mauricien ?'), ['class' => '']) !!}
    <div id="message-map-dk" class="text-danger"></div>
    <div class="form-check">
      <input  id="radio-position-1" class="form-check-input radio-position" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
      <label class="form-check-label" for="exampleRadios1">
        {{ __('users.dk') }}
      </label>
    </div>
    <div id="message-map-elsewhere" class="text-danger"></div>
    <div class="form-check">
      <input id="radio-position-2" class="form-check-input radio-position" type="radio" name="exampleRadios" id="exampleRadios1" value="option1">
      <label class="form-check-label" for="exampleRadios1">
        {{ __('users.place-on-a-map') }}
      </label>
    </div>
    <div id="message-map" class="text-danger"></div>
    <div class="form-check">
      <input id="radio-position-3" class="form-check-input radio-position" type="radio" name="exampleRadios" id="exampleRadios1" value="option1"  data-toggle="" data-target="#collapseMap" aria-expanded="false" aria-controls="collapseMap">
      <label class="form-check-label" for="exampleRadios1">
        {{ __('users.elsewhere') }}
      </label>
    </div>
    <div class="collapse" id="collapseMap">
      <div>
        <button class="btn btn-success btn-sm" id="modify-position">Modifier ma position</button>
      </div>
      <div class="alert alert-info explanation-map d-none">
        <em>Cliquez sur la carte à l'endroit où vous avez appris  :</em>
      </div>
      <div style="position:relative;">
        <img style="position:relative;left:0;top:0;width:50%;" id="map" src="{{ asset('img/Carte_'.App::getLocale().'.svg') }}" />
        Source : https://fr.wikipedia.org/wiki/Fichier:Mauritius_Island_map-fr.svg (Eric Gaba – Wikimedia Commons user: Sting)
        <i id="anchor" style="position:absolute;" class="fa fa-child fa-2x d-none" aria-hidden="true"></i>
      </div>
    </div>

    <hr/>

    <div id="message-city" class="text-danger"></div>
    <form id="form-city">
      {!! Form::label('city', __("Vous pouvez également préciser la ville ou le village où vous avez appris {{ __('home.langues') }} :"), ['class' => '']) !!}

      <div class="col-sm-9">
        <input type="text" class="form-control" name="city" id="city" />
      </div>
      <div class="form-group text-right">
        {!! Form::submit("Enregistrer", ['id' => 'save-city','class' => 'btn btn-success']) !!}
      </div>      
    </form>
  </div>
</div>
<hr/>
<h4 class="card-title" id="title-avatar">Modifier votre mot de passe</h4>
{!! Form::open(['route' => 'users.update-password']) !!}
  <div class="form-group row">
    {!! Form::label('password', __('users.attributes.password'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password'), '']) !!}

      @if ($errors->has('password'))
          <span class="invalid-feedback">{{ $errors->first('password') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('password_confirmation', __('users.attributes.password_confirmation'), ['class' => 'col-sm-3 col-form-label']) !!}

    <div class="col-sm-9">
      {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation')]) !!}

      @if ($errors->has('password_confirmation'))
          <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group text-right">
    <button class="btn btn-success">Modifier mon mot de passe</button>
  </div>
{!! Form::close() !!}

@component('components.modals.default', ['id' => 'avatarsModal'])
    @slot('title')
        Choisir son avatar
    @endslot
    <div class="">
      @foreach($avatars as $avatar)
        <img style="width:40px;" class="avatar mr-1 mb-1" id="{{ $avatar->id }}" src="{{ asset('img/avatars/'.$avatar->image) }}" />
      @endforeach
    </div>
@endcomponent


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
    
    function displayMessage(id,message){
      $('#'+id).show().html(message).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).delay(2000).slideUp();
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
          displayMessage('message-map-dk',data.message);
        }).fail(function( data ) {
          alert( "Erreur lors de la mise à jour du profil" );
        });
      }
    });

    $("#form-languages").on( "submit", function( event ) {
      event.preventDefault();
        $.ajax({
          url: "{{ route('users.update-languages') }}",
          data: $( this ).serialize(),
          type: 'post',
          dataType: 'json',
          success: function(data) {
            displayMessage('message-languages',data.message);
          }
        });  
    });

    $("#form-city").on( "submit", function( event ) {
      event.preventDefault();
        $.ajax({
          url: "{{ route('users.update-city') }}",
          data : {city: $('#city').val()},
          type: 'post',
          dataType: 'json',
          success: function(data) {
            displayMessage('message-city',data.message);
          }
        });  
    });

    $('.radio-age').change(function(e){
      console.log("fldisjlsj");
        $.post( "{{ route('users.update-age') }}", {
          age_group_id: $('input[name=age_group_id]:checked').val()
        }).done(function( data ) {
          displayMessage('message-age',data.message);
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
          $('#map').css({'width':'50%'});
          can_modify_position = false;
          placeAnchor();
          displayMessage('message-map',data.message);
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

    $('.avatar').click(function(event){
      if($('#avatar').length==0){
        $('#choose-avatar').before('<img style="width:50px" src="'+$(this).attr('src')+'" id="avatar" />');
      } else {
        $('#avatar').attr('src',$(this).attr('src'));
      }
      $('#avatarsModal').modal('hide');

      $.post( "{{ route('users.update-avatar') }}", {
        avatar_id: $(this).attr('id')
      }).done(function( data ) {

      }).fail(function( data ) {
        alert( "Erreur lors de l'enregistrement de votre avatar" );
      });

    })

  </script>
@endsection