<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function callApi($method, $url, $parameters=[], $headers=[]){
      $client = new \GuzzleHttp\Client();
      $response = $client->request($method, $url, [
        'form_params' => $parameters,
        'headers'     => $headers
      ]);
      $return_value       = json_decode($response->getBody());
      return $return_value;
    }
}
