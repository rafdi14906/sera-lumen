<?php

namespace App\Http\Controllers;

class FilterObjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/filter_object",
     *     operationId="/filter_object",
     *     tags={"No. 7 Filter Object"},
     *     @OA\Response(
     *         response="200",
     *         description="Returns array denom >= 100000",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function index()
    {
        $arrDenom = [];

        $url = "https://gist.githubusercontent.com/Loetfi/fe38a350deeebeb6a92526f6762bd719/raw/9899cf13cc58adac0a65de91642f87c63979960d/filter-data.json";
        $obj = $this->apiHelper->hit($url, "GET");
        $response = $obj->response;

        if ($response->status == 1) {
            $billdetails = $response->data->response->billdetails;
            foreach ($billdetails as $bill) {
                $denom = 0;
                foreach ($bill->body as $value) {
                    $exp = explode(':', $value);
                    $denom = trim($exp[1]);

                    if ($denom >= 100000) {
                        array_push($arrDenom, $denom);
                    }
                }
            }
        }

        return response()->json($arrDenom);
    }

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

        curl_close($curl);
        return json_decode($response);
    }
}
