# Amazon_Calculator
Amazon Calculator For Sellers [Saudi Arabia] - [السعودية] حاسبة أمازون للبائعين

 أداة لحساب تكاليف البيع على أمازون السعودية [عمولة البيع - رسوم الشحن السهل] وحساب صافي الأرباح 

## 😎 Getting Started

*   [Referral_Fees.json](Referral_Fees.json) ملف عمولات البيع على أمازون بحسب القسم 
* [EasyShip.json ](EasyShip.json) ملف متغيرات رسوم الشحن السهل  
* [Referral_Fees.php](Referral_Fees.php) ملف حساب عمولة البيع
* [Shipping.php](Shipping.php) ملف حساب رسوم الشحن السهل
* [cul.php](cul.php) الحاسبة  



## GIT Request

```
cul.php?cul=&Sale_Price=100&category=1&weighs=0.25&length=25&witdth=25&height=25&shipping_charge=12&vat=15

```

- `cul` || `NULL`
- `Sale_Price` || `سعر البيع` (Float)
- `category` || `رقم القسم من 1 إلى 38` (int)
- `weighs` || `وزن الشحنة`(Float)
- `length` || `الطول`(Float)
- `witdth` || `العرض`(Float)
- `height` || `الأرتفاع`(Float)
- `shipping_charge` || `رسوم التوصيل`(Float)
- `vat` || `الضريبة المضافة`(Float)


## Response

```json
{
    "price": 100,
    "final": 153.17,
    "shipping_charge_price": 12,
    "Referral_Fees": 16.8,
    "Referral_Fees_vat": 2.52,
    "Referral_price": 19.32,
    "Easy_Ship": 19,
    "Easy_Ship_vat": 2.85,
    "Easy_Ship_price": 21.85,
    "net": 70.83000000000001
}
```




