<?php 

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Coupon;

class Website extends \yii\db\ActiveRecord
{
    public static function getTableName() 
    {
        return 'Website';
    }
    
    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['WebsiteID' => 'WebsiteID']);
    }
}