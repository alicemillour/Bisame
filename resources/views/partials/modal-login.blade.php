<?php

$number_annotations_not_seen = 0;
if(Auth::check()){

    $annotations_not_seen = App\Annotation::getNotSeen(Auth::user());
    $number_annotations_not_seen = $annotations_not_seen->count();
}
if($number_annotations_not_seen){
    $modal = App::make('App\Services\Html\ModalBuilder');
        $html = '';
        if(isset($new_log))
            $html .= '<h2>Salut '.Auth::user()->username.' !</h2>';

        App\Annotation::resetNotSeen(Auth::user());
        $html .= '<h5>D\'autres joueurs ont joué comme toi :</h5>';
        $html .= '<h4>Tu as gagné '.$annotations_not_seen->sum('points_not_seen').' points !</h4>';


        echo $modal->modal($html,'modalLogin');

        echo "<script>
                $('#modalLogin').modal('show');
            </script>";
}
?>