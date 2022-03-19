<?php

namespace App\Helpers;

use stdClass;

class ApiHelper
{
    public function hit($url, $method, $header = [], $body = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $response = json_encode([
                'status' => 0,
                'message' => curl_error($curl),
            ]);
        }

        $result = new stdClass;
        $result->response = json_decode($response);
        $result->http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        return $result;
    }

    public function make_response($status, $message, $total_data = 0, $data = [])
    {
        return ['status' => $status, 'message' => $message, 'total_data' => $total_data, 'data' => $data];
    }
}
