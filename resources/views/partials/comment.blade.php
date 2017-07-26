<div class="container ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default background-colored">
                <div class="panel-heading background-colored text-center">Un commentaire ?</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/send') }}">
                        <div class="form-group">

                        <label class="col-md-3 control-label">Commentaire</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary send-mail-button">
                                    <i class="fa fa-btn fa-user"></i>Poster votre commentaire
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>