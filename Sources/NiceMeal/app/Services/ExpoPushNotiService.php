<?php
namespace App\Services;

class ExpoPushNotiService {
  protected const api_url = "https://exp.host/--/api/v2/push/send";

  public static function pushNoti($expo_token,$title,$body){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', self::api_url, [
            'form_params' => [
                'to' => $expo_token,
                'title'=> $title,
                'body'=> $body,
                'data' => [
                  'title' => $title,
                  'body' => $body,
                ]
            ]
        ]);
  }


}
