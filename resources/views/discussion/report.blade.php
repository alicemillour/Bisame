@component('components.modals.default', ['id' => 'reportModal'])
    @slot('title')
        Signaler du contenu non approprié
    @endslot
    <div class="text-center">
        {!! Form::open(['url' => 'report/send', 'method' => 'post', 'role' => 'form', 'id'=>'form-report']) !!} 
            <div class="form-group text-center">
                <textarea id="freeReportArea" class="free-report-textarea" name="message[]" type="text" placeholder="Si vous le souhaitez vous pouvez ajouter un message."></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success" id="submitReport">Envoyer</button>
                <button type="submit" class="btn btn-danger btn-default" data-dismiss="modal" id="cancelReport">Annuler</button>
            </div>
        {!! Form::close() !!}  
    </div>
@endcomponent
