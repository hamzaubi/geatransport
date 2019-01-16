<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Mission extends Model
{

 protected $fillable = ['chauffeurname','vehicule','missiondetails','heurdepart','date'];
    
}

/*Me.Texte185.Value = "Working......"
Me.WebBrowser3.Navigate "http://geadd30158.sonahess.local/insert?" & "chauffeurname=" & Me.Chauffeur.Value & "&vehicule=" & Me.Matricule.Value & "&missiondetails=" & Me.Mission.Value & ":" & Me.Texte41.Value & "&heurdepart=" & Me.HeurD.Value & "&date=" & Me.Pourle.Value
Me.Texte185.Value = ".........(-).........."*/