<?php
/**
 * Created by PhpStorm.
 * User: nabun
 * Date: 2016. 01. 28.
 * Time: 19:15
 */

namespace App\Api;

use Carbon\Carbon;
use GuzzleHttp\Client;

class Schedule
{
    const MENETREND_API_URL = 'http://ujmenetrend.cdata.hu/uj_menetrend/hu/talalatok_json.php';

    public function getSchedule($from, $to, $when)
    {
        // Decode params
        $from = urldecode($from);
        $to = urldecode($to);
        $when = urldecode($when);

        // Send request
        $response = $this->sendScheduleRequest(
            self::MENETREND_API_URL,
            $this->getRequestBody($from, $to, $when)
        );

        // Parse response
        return $this->parseResponse($response, new Carbon($when));
    }

    /**
     * Gets the body of the request being sent to the menetrend site.
     *
     * @param int  $from
     * @param int  $to
     * @param int  $when
     * @return array
     */
    private function getRequestBody($from, $to, $when)
    {
        //$from = str_pad($from, 4, "0");
        //$to = str_pad($to, 4, "0");

        $jsonBody = [
            'erk_stype' => 'megallo',
            'ext_settings' => 'block',
            'datum' => $when,
            'filtering' => 0,
            'helyi' => 'No',
            'hour' => '0-1',
            'ind_stype' => 'megallo',
            'honnan' => 'Budapest',
            'honnan_eovx' => "",
            'honnan_eovy' => "",
            'honnan_ls_id' => 0,
            'honnan_settlement_id' => $from,
            'honnan_site_code' => "0",
            'honnan_zoom' => 7,
            'hova' => 'Szeged',
            'hova_eovx' => "",
            'hova_eovy' => "",
            'hova_ls_id' => 0,
            'hova_settlement_id' => $to,
            'hova_site_code' => "0",
            'hova_zoom' => 7,
            'keresztul' => "",
            'keresztul_eovx' => "",
            'keresztul_eovy' => "",
            'keresztul_ls_id' => "",
            'keresztul_site_code' => "",
            'keresztul_zoom' => "",
            'keresztul_settlement_id' => "",
            'maxatszallas' => 5,
            'maxvar' => 240,
            'maxwalk' => 700,
            'min' => '00',
            'napszak' => 0,
            'naptipus' => 0,
            'odavissza' => 0,
            'preferencia' => 1,
            'rendezes' => 0,
            'submitted' => 1,
            'talalatok' => 1,
            'target' => 0,
            'utirany' => 'oda',
            'var' => 0
        ];

        return [
            'json' => json_encode($jsonBody, JSON_UNESCAPED_UNICODE)
        ];
    }

    /**
     * Sends a schedule request to a site.
     *
     * @param string  $url  Url to send the request to.
     * @param array  $requestBody  Request body (form params).
     * @return null|string
     */
    private function sendScheduleRequest($url, $requestBody)
    {
        $client = new Client();

        try {
            $res = $client->request(
                'POST',
                $url,
                [
                    'form_params' => $requestBody,
                ]);
        } catch (Exception $ex) {
            return null;
        }

        return (string) $res->getBody();
    }

    private function parseResponse($response, $date = null)
    {
        $data = json_decode($response);
        $routes = [];

        if (property_exists($data, 'error')) {
            return $routes;
        }

        $schedule = $data->talalatok;

        // Why can't it be a motherfucking array? Fuck you
        $keys = (array)($schedule);

        foreach($keys as $routeData) {
            $routes[] = new Route(
                $date,
                $routeData->indulasi_hely,
                $routeData->erkezesi_hely,
                $routeData->indulasi_ido,
                $routeData->erkezesi_ido
            );
        }

        return $routes;
    }
}
