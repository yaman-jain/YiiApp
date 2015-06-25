<?php 

namespace app\models;

use Yii;

class Coupon_Cat_Tag extends \yii\db\ActiveRecord 
{
    public static function getTableName() 
    {
        return 'coupon_cat_tag';
    }
}