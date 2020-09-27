<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "chargingStations".
 *
 * @property int $id
 * @property int|null $output
 * @property int|null $placesAvailable
 * @property string|null $status
 * @property string|null $address
 * @property float $latitude
 * @property float $longitude
 * @property int|null $idCity
 */
class ChargingStations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chargingStations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['output', 'placesAvailable', 'idCity'], 'integer'],
            [['status'], 'string'],
            [['latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['address'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'output' => 'Output',
            'placesAvailable' => 'Places Available',
            'status' => 'Status',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'idCity' => 'Id City',
        ];
    }
}
