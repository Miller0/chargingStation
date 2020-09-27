<?php

namespace app\modules\api\controllers;

use app\models\generated\City;
use app\utils\SaveError;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class ChargingStationsController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\ChargingStations';

    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function checkAccess($action, $model = null, $params = [])
    {
        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'xml' => Response::FORMAT_XML
                ],
            ],
        ];
    }

    /**
     * @param string $name
     * @return array|\yii\db\ActiveRecord[]|null
     */
    public function actionGetCity($name = '', $status = 'open')
    {
        try
        {
            if (!empty($name))
                $name = explode(",", $name);

            $city = City::find()
                ->select(['cs.*', 'city.name as cityName'])
                ->leftJoin('chargingStations cs', 'city.id = cs.idCity')
                ->filterWhere(['city.name' => $name])
                ->andFilterWhere(['cs.status' => $status])
                ->asArray()
                ->all();

            return $city;
        }
        catch (\Exception $e)
        {
            SaveError::save(1000, $e->getMessage());
        }

        return null;
    }


    /**
     * @param string $latitude
     * @param string $longitude
     * @return array|\yii\db\ActiveRecord[]|null
     */
    public function actionBeside($latitude = '', $longitude = '')
    {
        if (empty($latitude) || empty($longitude))
            return null;

        try
        {
            $area = 100;
            $radiusEarth = 6371;
            $half = ($area / $radiusEarth) / 2;
            $latitude = (double)$latitude;
            $longitude = (double)$longitude;
            $city = \app\models\generated\ChargingStations::find()
                ->select(['*'])
                ->FilterWhere(['between', 'latitude', $latitude - $half, $latitude + $half])
                ->andFilterWhere(['between', 'longitude', $longitude - $half, $longitude + $half])
                ->asArray()
                ->all();

            return $city;
        }
        catch (\Exception $e)
        {
            SaveError::save(1000, $e->getMessage());
        }

        return null;
    }
}