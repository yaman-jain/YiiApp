<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use app\models\Coupon;
use app\models\CouponCategories;
use app\models\CouponCategoryInfo;

use yii\data\Pagination;


class CouponController extends Controller
{
    public function actionIndex()
    {
        // This query is used to find coupons i.e. where IsDeal flag is 0 in the database
        $coupons = Coupon::find()                                   
                ->where(['isDeal' => 0])
                ->andWhere(['IS NOT', 'CouponCode', null])
                ->andWhere(['!=', "CouponCode", ''])
                ->orderBy('CouponCode')
                ->limit(60)
                ->all();        
        
        // This query is used to find coupons i.e. where IsDeal flag is 1 in the database
    	$deals = Coupon::find()
    		->where(['isDeal' => 1])
    		->andWhere(['IS NOT', 'CouponCode', null])
    		->andWhere(['!=', "CouponCode", ''])
    		->orderBy('CouponCode')
    		->limit(60)
    		->all();
        // This shows the deal and coupons on the index page when the url is hit.
        return $this->render('index', [
        	'deals' => $deals, 
        	'coupons' => $coupons,
                
                ]);
    }

    public function actionSearch() 
    {		
        $request = Yii::$app->request;
        $IsRequested = false;
        $model = array();
        $model["Coupon"] = new Coupon;
        $model["CouponCategories"] = new CouponCategories;
        $queryString = $request->get();
        $couponCategoriesModel = $model["CouponCategories"];
        $categories = $couponCategoriesModel->fetchDistinctCategories(["CategoryID", "Name"]);
        //Filter by Category
        if(isset($queryString["CouponCategories"]["CategoryID"]) && !empty($queryString["CouponCategories"]["CategoryID"])) 
        {
            $categoryId = $queryString["CouponCategories"]["CategoryID"];
            $categoryRecord = CouponCategories::findOne($categoryId);
            $count = CouponCategoryInfo::fetchCoupons($categoryId, true);
            $coupons = $categoryRecord->categoryCoupons;
            $IsRequested = true;
        }
        else 
        {
            $coupons = [];
            $categoryId = '';
        }
        //Filter by Deal
        $IsDeal = isset($queryString["Coupon"]["IsDeal"]) ? $queryString["Coupon"]["IsDeal"] : 0;
        $where = array();
        $where["isDeal"] = $IsDeal;
        if(sizeof($coupons) > 0) 
        {
            $couponIds = array();
            foreach($coupons as $coupon) 
            {
                array_push($couponIds, $coupon["CouponID"]);
            }
            $where["CouponID"] = $couponIds;
        }
        $query = Coupon::find()
                ->select(["CouponID", "CouponCode", "IsDeal", "Title"])
                ->where($where);
        $counter = clone $query;
        $count = $counter->count();
        $pages = new Pagination(['totalCount' => $count]);
        $coupons = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render('search', [
                'model' => $model,
                'coupons' => $coupons,
                'pages' => $pages,
                'CategoryID' => $categoryId,
                'categories' => $categories
        ]);
    }
    
    /*
     * This is just a test function
     */
    public function actionTest() 
    {
        // $request = Yii::$app->request;
        // $queryString = $request->get();
        return $this->render('test', [
            'test' => 'Just doing test',
        ]);
    }
}
