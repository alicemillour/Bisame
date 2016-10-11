<div class="scoreboard fancy-border">
    <h2 style='text-align: center'>Classement des <br> contributeurs</h2>
    <div class="fancy-border">
        <ul class="nav nav-tabs">
            <li class="active" ><a data-toggle="pill" style="color:black" href="#home">Les plus prolifiques !</a></li>
            <li><a data-toggle="pill" style="color:black" href="#menu1">Score global</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div style="text-align: center; margin-top: 5px;">
                    
                    <span class="score">
                        @foreach($users_quantity as $key=>$user)
                        {{$key + 1}}. {{$user->name}} <span style="font-size: 0.7em"> ({{$user->quantity}} annotations.) </span>
                        <br>
                        @endforeach
                    </span>
                </div>

            </div>
            <div id="menu1" class="tab-pane fade">
                <div style="text-align: center;">
                    <div class="score">
                        @foreach($users_score as $key=>$user)
                        {{$key + 1}}. {{$user->name}} 
                        <br>
                        @endforeach
                    </div>
                    <p>Le score global prend en compte le nombre d'annotations produites ainsi que le score de confiance obtenu par chaque joueur.</p>

                </div>
            </div>
        </div>
    </div>
</div>




