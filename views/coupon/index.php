<?php
   // php wrappers
   use yii\helpers\Html; /* global globalParams */
   use yii\widgets\LinkPager;
   // use yii\widgets\ActiveForm;
   
   ?>
<!-- Styling in -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href="css/main.css" rel="stylesheet" type="text/css">
<!-- Body begins here -->
<div class="container">
   <div class="row">
      <div class="col-md-3">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h4>FILTER BY OFFER</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <form role="form">
                     <div class="row">
                        <div class="col-md-12">
                           <input type="checkbox" id="couponscheck" checked="true" onclick="checkCouponDeal()"> Coupon
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <input type="checkbox" id="dealscheck" checked="true" onclick="checkCouponDeal()"> Deal
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="row" style="height:25px">
            </div>
            <div class="row">
               <div class="col-md-12">
                  <h4>FILTER BY VENDOR</h4>
                  <form role="form">
                      
                     <div class="row">
                        <div class="col-md-12">
                           <input type="radio" id="Allvendors" value="Allvendors" name ="Vendors" onclick="checkCouponDeal()" checked="true"> All Vendors
                        </div>
                     </div>
                      
                     <?php $counter = 0; foreach ($vendors as $vendor) { if ($counter < 5) {?>
                     <div class="row">
                        <div class="col-md-12">
                            <input type="radio" id="<?= Html::encode($vendor->WebsiteID); ?>" value="<?= Html::encode($vendor->WebsiteID); ?>" name ="Vendors" onchange="checkCouponDeal()">
                           <?= strtoupper($vendor->WebsiteTitle); ?>
                        </div>
                     </div>
                     <?php }$counter++;} ?>
                  </form>
               </div>
            </div>
            <div class="row" style="height:25px">
            </div>
            <div class="row">
               <div class="col-md-12">
                  <h4>FILTER BY CATEGORY</h4>
                  <form role="form">
                    
                      <div class="row">
                        <div class="col-md-12">
                           <input type="radio" id="Allcategories" value="Allcategories" name ="Categories" onclick="checkCouponDeal()" checked="true">All Categories
                        </div>
                     </div>
                     
                     <?php $counter = 0; foreach ($categories as $category) { if ($counter < 5) {?>
                     <div class="row">
                        <div class="col-md-12">
                           <input type="radio" id="<?= Html::encode($category->CategoryID); ?>" value="<?= Html::encode($category->CategoryID); ?>" name ="Categories" onchange="checkCouponDeal()">
                           <?= Html::encode($category->Name); ?>
                        </div>
                     </div>
                     <?php } $counter++;} ?>
                  </form>
               </div>
            </div>
         </div>
      </div>
      
      <div class="col-md-6">
         <h1 align="center" style="margin-top: 0px; margin-bottom: 0px"></h1>
         
         <div id="loading" align="center">
         </div>
         <div id="offers">
            <?php foreach ($coupons as $coupon): ?>
            <div class="thumbnail">
               <div class="caption">
                   <p><span>Coupon ID: </span>
                  <?= $coupon->CouponID ?>
                   </p>
                  <p>Vendor Name : <b><?= Html::encode($coupon->website->WebsiteName); ?></b></p>
                  
                  <?php if ($coupon->IsDeal == 1) { ?>
                  <h5>
                    ACTIVATE DEAL: <?= Html::encode($coupon->IsDeal) ?>
                  </h5>
                  <?php } else {
                     ?>
                  <h5>
                     Coupon Code : <?= Html::encode($coupon->CouponCode) ?>
                  </h5>
                  <?php } ?>
               </div>
            </div>
            <?php endforeach; ?>
            <?= LinkPager::widget(['pagination' => $pagination]) ?>
         </div>
      </div>
       
      <!-- Begin export to Excel feature -->
      <div class="col-md-3">
          <img src="images/excel.png" onclick="exportToExcel()" style="cursor:pointer; width:20px; height:20px;"/>
      </div>
      <!-- End --> 
   </div>
</div>

