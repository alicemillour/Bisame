Signalement de contenu inapproprié.

{!! str_replace('\r\n','<br />',nl2br($report->message)) !!}
<br/>
<br/>
Lien vers la page :<br/>
{!! link_to($report->page,null,['target'=>'blank']) !!}