<?php 

namespace app\models;

use Yii;
use app\models\CouponCategoryInfo;

class CouponCategories extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'CouponCategories';
    }

    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['CouponID' => 'CouponID'])
                ->viaTable('CouponCategoryInfo', ['CategoryID' => 'CategoryID']);
    }
    
    public function getCouponSubCategories() 
    {
        return $this->hasMany(CouponSubCategories::className(), ['CategoryID' => 'CategoryID']);
    }
}