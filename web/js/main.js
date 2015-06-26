"use strict";
var ajaxWrapper = function(choice, vendorId, categoryId) {
  if (vendorId === "Allvendors" && categoryId === "Allcategories") {
    $('#offers').show();
  }
  $.ajax({
    type: 'GET',
    beforeSend: function() {
      $("#loading").fadeIn();
    },
    url: "index.php?r=coupon/filter&choice=" + choice + "&vendor_id=" +
      vendorId + "&category_id=" + categoryId,
    dataType: "json",
    data: {},
    success: function(data) {
      if (data) {
        var len = data.length,
          txt = "";
        if (len === 0) {
          txt =
            "<p><h4>Currently, No Coupons/Deals are Available Stay tuned</h4></p>";
        } else {
          for (var i = 0; i < len; i++) {
            if (choice === 2 || choice === 3) {
              if (data[i]['IsDeal'] === 1) {
                txt += "<div class=\"thumbnail\">" +
                  "<div class=\"caption\">" +
                  "<p><span>Coupon ID: </span>" + data[i]["CouponID"] +
                  "</p><p>VendorID : <b>" + data[i]['WebsiteID'] +
                  "</b></p><h5>ACTIVATE DEAL :" + data[i]['IsDeal'] +
                  "</h5></div></div>";
              }
            }
            if (choice === 1 || choice === 3) {
              if (data[i]['IsDeal'] === 0) {
                txt += "<div class=\"thumbnail\">" +
                  "<div class=\"caption\">" +
                  "<p><span>Coupon ID: </span>" + data[i]["CouponID"] +
                  "</p><p>VendorID : <b>" + data[i]['WebsiteID'] +
                  "</b></p><h5>Coupon Code :" + data[i]['CouponCode'] + "</h5></div></div>";
              }
            }
          }
        }
        if (txt !== "") {
          $("#offers").html(txt);
          $("#loading").fadeOut();
        }
      }
    },
    statusCode: {
      404: function() {
        alert("Page not found");
      }
    }
  });
}
var checkCouponDeal = function() {
  /*
   *  This function filters the data based on vendors/categories, coupons and deals
   */
  var couponCheck = $("#couponscheck").is(":checked"),
    dealCheck = $("#dealscheck").is(":checked"),
    vendorId = $('input:radio[name="Vendors"]:checked').val(),
    categoryId = $('input:radio[name="Categories"]:checked').val()
  $('#loading').html('<img src="images/money.GIF">');
  if ((couponCheck && dealCheck) || !(couponCheck || dealCheck)) {
    ajaxWrapper(3, vendorId, categoryId);
  } else if (couponCheck && !dealCheck) {
    ajaxWrapper(1, vendorId, categoryId);
  } else {
    ajaxWrapper(2, vendorId, categoryId);
  }
};
var exportToExcel = function() {
  /*
   * This function exports data into EXCEL
   */
  var couponCheck = $("#couponscheck").is(":checked"),
    dealCheck = $("#dealscheck").is(":checked"),
    vendorId = $('input:radio[name="Vendors"]:checked').val(),
    categoryId = $('input:radio[name="Categories"]:checked').val(),
    url = "";
  if ((couponCheck && dealCheck) || !(couponCheck || dealCheck)) {
    url = "index.php?r=coupon/export2excel&choice=3&vendorId=" + vendorId +
      "&categoryId=" + categoryId;
  } else if (couponCheck && !dealCheck) {
    url = "index.php?r=coupon/export2excel&choice=1&vendorId=" + vendorId +
      "&categoryId=" + categoryId;
  } else {
    url = "index.php?r=coupon/export2excel&choice=2&vendorId=" + vendorId +
      "&categoryId=" + categoryId;
  }
  window.location = url;
};