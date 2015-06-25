"use strict";
var checkCouponDeal = function (){
   var couponCheck = $("#couponscheck").is(":checked")
     , dealCheck = $("#dealscheck").is(":checked") 
     , vendorId = $('input:radio[name="Vendors"]:checked').val() 
     , categoryId = $('input:radio[name="Categories"]:checked').val() 
   $('#loading').html('<img src="images/money.GIF">'); 
   if((couponCheck && dealCheck) || !(couponCheck || dealCheck)) {
       //both deals and coupons
       if(vendorId === "Allvendors" && categoryId === "Allcategories"){
            $("#loading").fadeIn(); 
            $('#offers').show(); 
            $('#offers_ajax').hide();
            $("#loading").fadeOut();
        } else {
            /*
            $.getJSON("index.php?r=coupon/filter&choice=3&vendor_id="+vendorId+"&category_id="+categoryId, function(data) {
                console.log( "JSON Data: " + data );
            });
            */
            $.ajax({
            //type: 'GET',
            beforeSend:function () {
                $("#loading").fadeIn(); 
            },
            url: "index.php?r=coupon/filter&choice=3&vendor_id="+vendorId+"&category_id="+categoryId, 
            dataType: "html",
            success: function (data) {                   
                    $('#offers_ajax' ).html( data ); 
                    $('#offers_ajax').show(); 
                    $('#offers').hide(); 
                    $("#loading").fadeOut(); 

                }
                ,
            statusCode: {
                404 : function() {
                    alert("Page not found");
                }
            }
            });
        }
   } else if(couponCheck && !dealCheck) {
       /*$.getJSON("index.php?r=coupon/filter&choice=1&vendor_id="+vendorId+"&category_id="+categoryId, function(data) {
                console.log( "JSON Data: " + data );
            });
        */
        $.ajax({
            //type: 'GET',
            beforeSend: function () {
                $("#loading").fadeIn(); //ajax effect before sending the ajax request
            },
            url: "index.php?r=coupon/filter&choice=1&vendor_id="+vendorId+"&category_id="+categoryId, 
            dataType: "html",
            success: function (data) {                   
                    $('#offers_ajax' ).html( data ); 
                    $('#offers_ajax').show(); 
                    $('#offers').hide(); 
                    $("#loading").fadeOut(); 
                }
            ,
            statusCode: {
                404 : function() {
                    alert("Page not found");
                }
            }
        });
        
   } else {
       /*$.getJSON("index.php?r=coupon/filter&choice=2&vendor_id="+vendorId+"&category_id="+categoryId, function(data) {
                console.log( "JSON Data: " + data );
        });*/
       
        $.ajax({
            //type: 'GET',
            beforeSend:function () {
                $("#loading").fadeIn(); //ajax effect before sending the ajax request
            },
            url: "index.php?r=coupon/filter&choice=2&vendor_id="+vendorId+"&category_id="+categoryId, 
            dataType: "html",
            success: function (data) {                   
                    $('#offers_ajax' ).html( data ); 
                    $('#offers_ajax').show(); 
                    $('#offers').hide(); 
                    $("#loading").fadeOut(); 
                }
            ,
            statusCode: {
                404 : function() {
                    alert("Page not found");
                }
            }
        });
        
    }
};
var exportToExcel = function (){
   /*
    * This function exports data into EXCEL
    */
   var couponCheck = $("#couponscheck").is(":checked") 
     , dealCheck = $("#dealscheck").is(":checked")
     , vendorId = $('input:radio[name="Vendors"]:checked').val() 
     , categoryId = $('input:radio[name="Categories"]:checked').val() 
     , url = "";
   if((couponCheck && dealCheck) || !(couponCheck || dealCheck)) {
        url = "index.php?r=coupon/export2excel&choice=3&vendorId="+vendorId+"&categoryId="+categoryId; 
   } else if(couponCheck && !dealCheck) {
        url = "index.php?r=coupon/export2excel&choice=1&vendorId="+vendorId+"&categoryId="+categoryId;
   } else {
        url = "index.php?r=coupon/export2excel&choice=2&vendorId="+vendorId+"&categoryId="+categoryId;
   }
   window.location = url;
};