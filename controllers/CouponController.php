<?php namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use app\models\Coupon;
use app\models\Website;
use app\models\CouponCategories;
use yii\web\JsonResponseFormatter;
use PHPExcel;

class CouponController extends Controller {   
    public function actionIndex() {
        $query_coupons = Coupon::find(); 
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query_coupons->count(),
        ]);
        $vendors = Website::find()
                    ->orderBy('WebsiteID') 
                    ->limit(10)
                    ->all();
        $categories = CouponCategories::find()
                    ->orderBy('CategoryID') 
                    ->all();
        $coupons = Coupon::find()
                    ->orderBy('CouponID')
                    ->with('website')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
        return $this->render('index', [
                'coupons' => $coupons,
                'pagination' => $pagination,
                'vendors' => $vendors,
                'categories' => $categories
        ]);
    }
    /*
    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);
        foreach (Yii::app()->log->routes as $route) {
            if($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }
    */
    public function actionFilter($choice, $vendor_id, $category_id) {
        if (Yii::$app->request->isAjax) { 
            $coupons = Coupon::getCouponsBasedOnFilters($choice, $vendor_id, $category_id);
            
            // This is a JSON Approach Blocker:
            // var_dump($coupons);
            // var_dump($choice);
            header('Content-Type: application/json');
            $data = array_map(create_function('$m','return $m->getAttributes(array(\'CouponID\', \'IsDeal\', \'CouponCode\', \'WebsiteID\'));'),$coupons);
            // var_dump($data);
            echo json_encode($data);
            // return $this->renderAjax('filter', ['coupons' => $coupons]);
        }
    }
    public function actionExport2excel($choice, $vendorId, $categoryId) {
        /*
         * Export data to Excel 
         * for reference : https://github.com/PHPOffice/PHPExcel
         */
        $coupons = Coupon::getCouponsBasedOnFilters($choice, $vendorId, $categoryId);
        $objPHPExcel = new PHPExcel(); //make a new object of the php excel
        $sheet = 0; //start on sheet zero

        $objPHPExcel->setActiveSheetIndex($sheet);
        $row = 2; 
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->setTitle('Coupons Excel Sheet')
            ->setCellValue('A1', 'CouponID');
        
        foreach ($coupons as $coupon) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $coupon->CouponID);   
            $row++; //incrementing row
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "result.xlsx"; //filename of the downloaded excel sheet
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); //getting output
        exit();
    }
}
