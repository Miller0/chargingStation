<?php

namespace app\modules\api\models;


use app\models\generated\City;

class ChargingStations extends \app\models\generated\ChargingStations
{

    const STATUS = array('open' => 'open' , 'close' => 'close');

    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'id',
            'output',
            'city'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'idCity']);
    }

}
