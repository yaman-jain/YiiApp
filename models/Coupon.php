<?php 

namespace app\models;

use app\models\Website;
use app\models\CouponCategories;

class Coupon extends \yii\db\ActiveRecord
{
    /*
     * constructors and destructors are are not include to keep the things simple
     */
    public static function getTableName()
    {
        return 'coupon';
    }

    public function rules()
    {
        return [
            [['CountSuccess', 'CountFail', 'Hits', 'IsApproved', 'IsFeatured', 'WL_IsOffline', 'WebsiteID', 'AddedByAdmin', 'AdminID', 'EmailSent', 'UseLandingPageOnly', 'HasBeenReviewed', 'Priority', 'IsOneTimeUse', 'OneCodeIssuedPerNumSeconds', 'IsDeal', 'IncludeInAlertEmails', 'Gender', 'PinExpireTime', 'FeaturedCouponRank', 'FeaturedRankUnderMerchant', 'AllowWoSignIn', 'Category', 'Tags', 'SubCategory', 'diwaliScore'], 'integer'],
            [['FeatureStartDate', 'FeatureEndDate', 'LastFeaturedActivityTimestamp', 'DateAdded', 'Expiry', 'DateVerified', 'MakeActiveDate', 'ExclusiveStartDate', 'MerchantFeatureEndTime'], 'safe'],
            [['Discount', 'CouponPopularityScore', 'NewCouponPopularityScore'], 'number'],
            [['DiscountDescription', 'DiscountType', 'AllowWoSignIn'], 'required'],
            [['DiscountType', 'Description', 'MobileWebType', 'MobileAppType', 'CouponType', 'FullTerms', 'Status', 'Images'], 'string'],
            [['CouponCode', 'DiscountByValue', 'DiscountByPercentage', 'DiscountByFreeItem'], 'string', 'max' => 100],
            [['DiscountDescription'], 'string', 'max' => 50],
            [['Title', 'URLKeyword'], 'string', 'max' => 250],
            [['Link', 'MobileWebUrl', 'CustomMobileWebUrl', 'MobileAppUrl', 'CustomMobileAppUrl', 'MicroSitePartners', 'APIClients'], 'string', 'max' => 1000],
            [['IP'], 'string', 'max' => 20]
        ];
    }

    public function attributeLabels()
    {
        return [
            'CouponID' => 'Coupon ID',
            'CouponCode' => 'Coupon Code',
            'CountSuccess' => 'Count Success',
            'CountFail' => 'Count Fail',
            'Hits' => 'Hits',
            'IsApproved' => 'Is Approved',
            'IsFeatured' => 'Is Featured',
            'WL_IsOffline' => 'Wl  Is Offline',
            'FeatureStartDate' => 'Feature Start Date',
            'FeatureEndDate' => 'Feature End Date',
            'LastFeaturedActivityTimestamp' => 'Last Featured Activity Timestamp',
            'DateAdded' => 'Date Added',
            'Discount' => 'Discount',
            'DiscountDescription' => 'Discount Description',
            'DiscountType' => 'Discount Type',
            'Title' => 'Title',
            'Description' => 'Description',
            'WebsiteID' => 'Website ID',
            'Expiry' => 'Expiry',
            'DateVerified' => 'Date Verified',
            'AddedByAdmin' => 'Added By Admin',
            'AdminID' => 'Admin ID',
            'EmailSent' => 'Email Sent',
            'UseLandingPageOnly' => 'Use Landing Page Only',
            'Link' => 'Link',
            'MobileWebType' => 'Mobile Web Type',
            'MobileWebUrl' => 'Mobile Web Url',
            'CustomMobileWebUrl' => 'Custom Mobile Web Url',
            'MobileAppType' => 'Mobile App Type',
            'MobileAppUrl' => 'Mobile App Url',
            'CustomMobileAppUrl' => 'Custom Mobile App Url',
            'IP' => 'Ip',
            'HasBeenReviewed' => 'Has Been Reviewed',
            'Priority' => 'Priority',
            'IsOneTimeUse' => 'Is One Time Use',
            'CouponType' => 'Coupon Type',
            'OneCodeIssuedPerNumSeconds' => 'One Code Issued Per Num Seconds',
            'IsDeal' => 'Is Deal',
            'IncludeInAlertEmails' => 'Include In Alert Emails',
            'Gender' => 'Gender',
            'MakeActiveDate' => 'Make Active Date',
            'CouponPopularityScore' => 'Coupon Popularity Score',
            'ExclusiveStartDate' => 'Exclusive Start Date',
            'PinExpireTime' => 'Pin Expire Time',
            'FullTerms' => 'Full Terms',
            'FeaturedCouponRank' => 'Featured Coupon Rank',
            'FeaturedRankUnderMerchant' => 'Featured Rank Under Merchant',
            'MerchantFeatureEndTime' => 'Merchant Feature End Time',
            'MicroSitePartners' => 'Micro Site Partners',
            'AllowWoSignIn' => 'Allow Wo Sign In',
            'APIClients' => 'Apiclients',
            'DiscountByValue' => 'Discount By Value',
            'DiscountByPercentage' => 'Discount By Percentage',
            'DiscountByFreeItem' => 'Discount By Free Item',
            'Category' => 'Category',
            'Tags' => 'Tags',
            'SubCategory' => 'Sub Category',
            'diwaliScore' => 'Diwali Score',
            'Status' => 'Status',
            'NewCouponPopularityScore' => 'New Coupon Popularity Score',
            'Images' => 'Images',
            'URLKeyword' => 'Urlkeyword',
        ];
    }
    public function getWebsite()
    {
        return $this->hasOne(Website::className(), ['WebsiteID' => 'WebsiteID']);
    }

    public function getCouponCategories()
    {
        return $this->hasMany(CouponCategories::className(), ['CategoryID' => 'CategoryID'])
                ->viaTable('CouponCategoryInfo', ['CouponID' => 'CouponID']);
    }
    
    public static function getCouponsBasedOnFilters($choice, $vendorId, $categoryId)
    {
        $query = Coupon::find()
                ->joinWith('couponCategories')
                ->with('website')
                ->orderBy('CouponID')
                ->limit(19); 
        $coupons = clone $query; 
        if ($choice === 1) // coupons 
        { 
            $coupons = $query->where("IsDeal=0");
        } 
        elseif ($choice === 2) // deals 
        { 
            $coupons = $query->where("IsDeal=1");
        }
        if ($vendorId != "Allvendors") 
        {
            $coupons = $coupons->andWhere(array("WebsiteID" => $vendorId));
        }
        if ($categoryId != 'Allcategories') 
        {
            $coupons = $coupons->andWhere(array("`CouponCategories`.`CategoryID`" => $categoryId));
        } 
        else 
        {
            $categoryId = -1;
        }
        return $coupons->all();
    }
}