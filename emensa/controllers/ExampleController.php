<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');

class ExampleController
{
    public function m4_7a_queryparameter(RequestData $rd) {
        /*
           Wenn Sie hier landen:
           bearbeiten Sie diese Action,
           so dass Sie die Aufgabe löst
        */

        return view('examples.m4_7a_queryparameter', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }

    public function m4_7b_kategorie(RequestData  $rd){

        $data = db_kategorie_select_namen_sortiert();

        $vars = [
            'data' => $data
        ];
        return view("examples.m4_7b_kategorie", $vars);
    }
    public  function m4_7c_gerichte(RequestData  $rd){
        $data = db_gericht_select_names_preis_intern();

        $vars = [
            'data' => $data
        ];
        return view("examples.m4_7c_gerichte", $vars);
    }
}