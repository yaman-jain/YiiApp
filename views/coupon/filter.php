<?php if (empty($coupons)) { ?>
    <p><h4>Currently, No Coupons/Deals are Available Stay tuned</h4></p>
<?php } else { ?>
    <?php foreach ($coupons as $coupon): ?>
        <div class="thumbnail">
               <div class="caption">
                   <p><span>Coupon ID: </span>
                  <?= $coupon->CouponID ?>
                   </p>
                  <p>Vendor : <b><?= $coupon->website->WebsiteName ?></b></p>
                  <?php if ($coupon->IsDeal == 1) { ?>
                  <h5>
                    ACTIVATE DEAL : <?= $coupon->IsDeal ?>
                  </h5>
                  <?php } else {
                     ?>
                  <h5>
                     Coupon Code : <?= $coupon->CouponCode ?>
                  </h5>
                  <?php } ?>
               </div>
            </div>
        <?php //}  ?>
    <?php endforeach; ?>
<?php } ?>
