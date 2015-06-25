<?php 

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Coupon;

class CouponSubCategories extends \yii\db\ActiveRecord
{
    public static function getTableName()
    {
        return 'CouponSubCategories';
    }
}