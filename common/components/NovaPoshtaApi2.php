<?php

namespace common\components;

use Yii;

class NovaPoshtaApi2 extends \LisDev\Delivery\NovaPoshtaApi2
{

    /**
     * @return NovaPoshtaApi2
     */
    public static function getInstance()
    {
        return new NovaPoshtaApi2(Yii::$app->params['novaPoshtaApiKey'], 'ua', true, 'file_get_content'); // file_get_content or curl
    }

    /**
     * @inheritdoc
     */
    public function getCity($cityName, $areaName = '', $warehouseDescription = '')
    {
        $error = [];
        $data = false;
        // Get cities by name
        $cities = $this->getCities(0, $cityName);
        if (is_array($cities['data'])) {
            // If cities more than one, calculate current by area name
            $data = (count($cities['data']) > 1 && !empty($areaName))
                ? $this->findCityByRegion($cities, $areaName)
                : $cities['data'][0];
        }
        // Error
        (!$data) and $error[] = 'City was not found';
        // Return data in same format like NovaPoshta API
        return 
            [
                'success'  => empty($error),
                'data'     => [$data],
                'errors'   => $error,
                'warnings' => [],
                'info'     => [],
            ]
        ;
    }

    public function getCityByRef($ref)
    {
        $cityName = '';
        $response = $this->getCities(0, '', $ref);

        if (isset($response['data']) && count($response['data']) && isset($response['data'][0]['Description'])) {
            $cityName = $response['data'][0]['Description'];
        }

        return $cityName;
    }

    public function getWarehouseRef($cityRef, $description)
    {
        $return = '';
        $response = $this->getWarehouse($cityRef, $description);

        if (isset($response['data']) && count($response['data']) && isset($response['data'][0]['Ref'])) {
            $return = $response['data'][0]['Ref'];
        }

        return $return;
    }

}
