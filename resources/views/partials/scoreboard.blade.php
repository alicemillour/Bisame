<div class="fancy-border">
    <h2 style='text-align: center; color:black' >Classement des <br> contributeurs</h2> 
    <div class="fancy-border">
        <ul class="nav nav-tabs">
            <li class="nav-item" style="font-size: 1.5em;" ><a class="nav-link active" data-toggle="pill" style="color:black" href="#week"> Cette semaine </a></li>
            <li class="nav-item" style="font-size: 1.5em;" ><a class="nav-link" data-toggle="pill" style="color:black" href="#home"> Top 5 </a></li>
            <!--<li><a data-toggle="pill" style="color:black" href="#menu1">Score global</a></li>-->
            <!--<li class="pull-right"><a data-toggle="pill" style="color:black" href="#info" > <i class="fa fa-question-circle-o fa-2x" aria-hidden="true"></i></a></li>-->
            <li class="nav-item pull-right ostrich"><a class="nav-link" data-toggle="pill" style="color:black; font-size: 1.5em; font-weight: 600" href="#info" > ? </a></li>
            <!--<li class="pull-right ostrich"><a data-toggle="pill" style="color:black; font-size: 1.5em; font-weight: 600" href="#info" ><img src="images/question_mark.jpg"></a></li>-->
        </ul>
        
        <div class="tab-content">
            <div id="week" class="tab-pane fade in active">
                <div style="text-align: center; margin-top: 5px; display: inline-block;">
                    <span class="score" style="color:black;text-align: center; display: inline-block;">
                        @foreach($users_month as $key=>$user)
                        @if($key == 0)
                        <span  style="text-align: center; display: inline-block; font-size: 1.3em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->real_score)}}&nbsp;points)
                        <!--</span> <span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
                            @else
                            <span  style="text-align: center; display: inline-block; font-size: 0.7em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->real_score)}}&nbsp;points)
                            <!--<span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
                            </span>
                            @endif
                            <br>
                            @endforeach
                        </span>
                </div>
            </div>
            
            <div id="home" class="tab-pane fade">
                <div style="text-align: center; margin-top: 5px; display: inline-block;">
                    <span class="score" style="color:black;text-align: center; display: inline-block;">
                        @foreach($users_score as $key=>$user)
                        @if($key == 0)
                        <span  style="text-align: center; display: inline-block; font-size: 1.3em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->real_score)}}&nbsp;points)
                        <!--</span> <span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
                            @else
                            <span  style="text-align: center; display: inline-block; font-size: 0.7em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->real_score)}}&nbsp;points)
                            <!--<span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
                            </span>
                            @endif
                            <br>
                            @endforeach
                        </span>
                </div>
            </div>
            
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




