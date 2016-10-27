<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<div class="scoreboard fancy-border">
    <h2 style='text-align: center'>Classement des <br> contributeurs</h2>
    <div class="fancy-border">
        <ul class="nav nav-tabs">
            <li class="active" style="font-size: 1.5em;" ><a data-toggle="pill" style="color:black" href="#home"> Top 5 </a></li>
            <!--<li><a data-toggle="pill" style="color:black" href="#menu1">Score global</a></li>-->
            <!--<li class="pull-right"><a data-toggle="pill" style="color:black" href="#info" > <i class="fa fa-question-circle-o fa-2x" aria-hidden="true"></i></a></li>-->
            <li class="pull-right ostrich"><a data-toggle="pill" style="color:black; font-size: 1.5em; font-weight: 600" href="#info" > ? </a></li>
            <!--<li class="pull-right"><a data-toggle="pill" style="color:black; font-size: 1.5em; font-weight: 600" href="#info" >{{ HTML::image('images/question_mark.jpg') }}</a></li>-->
            <!--<li class="pull-right ostrich"><a data-toggle="pill" style="color:black; font-size: 1.5em; font-weight: 600" href="#info" ><img src="images/question_mark.jpg"></a></li>-->
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div style="text-align: center; margin-top: 5px; display: inline-block;">
                    <span class="score" style="text-align: center; display: inline-block;">
                        @foreach($users_score as $key=>$user)
                        @if($key == 0)
                        <span  style="text-align: center; display: inline-block; font-size: 1.3em;"> {{$key + 1}}. {{$user->name}} 
                        </span> <span style="font-size: 0.7em; line-height: 10%"> ({{$user->quantity}} annotations) </span> 
                        @else
                        {{$key + 1}}. {{$user->name}} <span style="font-size: 0.7em"> ({{$user->quantity}} annotations) </span>
                        @endif
                        <br>
                        @endforeach
                    </span>
                </div>
            </div>
            <!--            <div id="menu1" class="tab-pane fade">
                            <div style="text-align: center; margin-top: 5px;">
                                <div class="score" style="text-align: center; display: inline-block;">
                                    @foreach($users_quantity as $key=>$user)
                                    @if($key == 0)
                                    <span style="text-align: center; display: inline-block; font-size: 1.5em"> {{$key + 1}}. {{$user->name}} </span>
                                    @else
                                    {{$key + 1}}. {{$user->name}} 
                                    @endif
                                    <br>
                                    @endforeach
                                </div>
                                <p>Le score global prend en compte le nombre d'annotations produites ainsi que le score de confiance obtenu par chaque joueur.</p>
                            </div>
                        </div>-->

            <div id="info" class="tab-pane fade">
                <div style="text-align: justify; font-size: 1.5em; margin-top: 5px;">
<!--                    <div class="score" style="text-align: center; display: inline-block;">
                        @foreach($users_quantity as $key=>$user)
                        @if($key == 0)
                        <span style="text-align: center; display: inline-block; font-size: 1.5em"> {{$key + 1}}. {{$user->name}} </span>
                        @else
                        {{$key + 1}}. {{$user->name}} 
                        @endif
                        <br>
                        @endforeach
                    </div>-->
                    <p>Ce classement prend en compte le nombre d'annotations produites par chaque utilisateur ainsi que l'exactitude des réponses fournies sur les phrases de test dissimulées dans les séquences.</p>
                </div>
            </div>

        </div>
    </div>
</div>




