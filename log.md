# معلومات وقواعد البيانات


حالة الموقع - site_statue

1  ====== >  الموقع يعمل
2  ====== >  الموقع في حالة صيانة

 
 حالة  الأعضاء - user_statue
 1 - active (مفعل)
 2 - waiting (ينتظر الموافقة)
 3 - blocked (محظور)
 
 
 نوع الأعضاء - user_type
 1 - simple user (مستخدم)
 2 - Admin		(مدير)
 3 - supper_admin
 
حالة التعليقات - statue
1 - مفعل
2 - بانتظار الموافقة
3 - محذوف
 
 
حالة الصفحات - statue
1 - مفعل
2 - بانتظار الموافقة
3 - محذوف
 
 
حالة المقالات - statue
1 - منشور
2 - مسودة
3 - محذوف


حالة الاميلات - seen
0 - غير مقروئ
1 - تمت قرائته


المقالات - articles - statue
0 - مسودة 
1 - منشور 



اعدادات الموقع 
name = اسم الموقع
description = وصف الموقع
url = رابط الموقع
admin_email = إميل المدير
admin_mobile = إميل المدير
language = لغة الموقع
mode = حالة الموقع ، هل يعمل ام هو في حالة صيانة [ live = الموقع يعمل ] , [ maintenace = حالة الصيانة ]
mode = لغة الموقع





Packages
===================
package_name
package_time
package_price
package_features



Ads
=================
ads_name
ads_type
ads_url
ads_image



Reports
===============
Report_time
Report_content
Report_




articles
===============
id 
author --> id of the writer
title --> title of the article
post_content --> article content
post_thumbnail -> image thumbnail 
statue --> 1 = active , 0 not active
comments_statue = 0 not active , 1 active ( 1 by default (or make the admin choos this ))
post_type --> post , page
url -> the slug of the url
created_at 
updated_at
deleted_at






// حالة المنتجات
===================
1 = قيد الإنتظار
2 = 














