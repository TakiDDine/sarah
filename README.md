


<h1 align="center">لوحة تحكم نَفراس ، شبيهة بالوردبريس</h1>
<p align="center">  لوحة تحكم بسيطة الإستخدام يمكن تركيبها على أي مشروع PHP  .</p>
<p align="center">  حلم هذا السكربت هو أن يصبح أول وأقوى لوحة تحكم عربية  .</p>

## النسخة 1.1


```sh
فكرة لوحة التحكم هي انشاء لوحة تحكم عربية شبيهة بالوردبريس وتوفر الكثير من المزايا
```



// fixed
* admin when open any inside page redirect to index when the user is not logged in
* make the routes more clean and perfect


## النسخة 1.1
* تم اضافة العلبة البريدية ، ارسال البريد ، معاينة وحذف
* اضافة خاصية اضافة أكواد html/css/js في الهيدر والفوتر
* حل مشكلة اللوغو والأيقونة العلوية عند التعديل 
* تم اضافة زر ، امكانية اضافة جميع المنتجات من قائمة الأمنيات الى السلة بضغطة زر
* تم حماية جميع المدخلات بدون اسثناء
* تم اظهار نسبة الخصومة للمنتجات 
* مسح الصورة القديمة للمستخدم من الملفات عند تعديل المعلومات و تغيير الصورة الى واحدة جديدة
* تعديل : لا يمكن انشاء طلب اذا كانت السلة فارغة
* التحقق من الفورمات ب js قبل php من أجل استهلاك أقل للموارد
* اضافة امكانية حذف الطلب
* منع التسجيل بالإميلات المؤقتة والإميلات الوهمية
* منع الدخول لصفحة انشاء تسجيل الدخول واسترجاع كلمة المرور في حالة المستخدم مسجل دخوله
* منع الدخول لصفحة انشاء حساب جديد في حالة المستخدم مسجل دخوله
* تم اضافة امكانية حذف القائمة
* امكانية حذف عدة حقول في آن واحد  [للصفحات والمقالات والأعضاء]
* تم اضافة ملف خاص بحفظ الأخطاء البرمجية ،



# المميزات
* سهل التثبيت
* تعتمد لغتين العربية والإنجليزية
* لوحة تحكم متجاوبة مع كافة الشاشات ، يمكنك الولوج اليها من هاتفك ، حاسوبك ، بأي مكان
* واضحة جداً ، يكنك استعمالها حتى بدون اي معرفة مسبقة بالبرمجة
* نقدم المساعدة دائما في الصفحات التي ربما قد تلقى فيها صعوبة
* استخراج كافة معلومات الأعضاء في ملف csv أو pdf
* زر خاص بتكرار المنتجات والمقالات والصفحات .. دون الحاجة للنسخ واللصق
* التحكم الكامل بالإعضاء 
* انشاء قوائمة ديناميكية بكل حرية
* يوجد محرك بحث خاص بكل قسم ، محرك بحث للأعضاء والمنتجات والرسائل والطلبات
* عرض الإحصائيات والتفاصيل عن لوحة التحكم 
* رابط الإسترجاع لكلمة المرور صالح لمدة 30 دقيقة فقط 
* تستخدم تقنية جد آمنة في حفظ كلمات المرور
* صفحة الموقع في حالة الصيانة ، احترافية



## to do in version 1.2.3 

* check all repeated code & enhance it , dry the code
* show the user ip, country , system in the dashboard




## To do in version 1.2 ()




delete all the libraries from github
update carte
add font awesome to menu
add font awesome picker --> https://farbelous.io/fontawesome-iconpicker/

تسمية مثالية breadcrumbsbreadcrumb
عرض شرائح مثالي
قم بتحسين admin.js

قم بزيادة الحد الأقصى لطول كلمة مرور المسؤول أثناء التثبيت
عند حذف كل الأعضاء ، مسح كل صور الأعضاء بالاستثناء صورة الأدمن ونفس الشيء مع تلك البيانات الأخرى
اضافة رابط تحميل كافة ملفات الموقع
تذكير المستخدم بالقياسات في مكان رفع الصور
تذكير المستخدم بضغط الصور  قبل رفعها
جعل جداول لوحة التحكم متجاوبة
https://www.youtube.com/watch?v=spoNYvTdH64https://drive.google.com/file/d/0B7gM8rl_j5nsakpxOFlSSlZvbnc/view
https://www.youtube.com/watch?v=ktUOY0OAFmA

a hin pibih
shipping methods


## To do in version 1.3 ( 20 Decembre 2018 )
* add fake data
* Follow this instruction --> https://github.com/php-pds/skeleton
* add Published * Not published / Published
* use and create assets helper 
* add dropzone in mediauploader
* add maintenace mode - Done
* add Time Zone in settings general - Done
* add Date Format in settings general - Done
* add reCAPTCHA public key to settings general - Done
* add reCAPTCHA private key to settings general - Done
* add google maps api input in settings general - Done
* add file manager allawed files extension
* add more social media to social media links in settings
* add nice_time() function to each model
* Active Sessions Management (see and manage all your active sessions) 
* add force logout the user
* organize html files & compress them automaticly, Remove all inline css ( 1 day )
* organize the helpers classes (2 days)
* add csrf security for each form in the admin indivudualy (1 day)
* add permissions to controllers (1 day)
* add the file manger  (1 day)
* add users registred stats to dashboard  , use pie charts ( 1 day)
* get visitors google analytics stats to dashboard home (1 day )
* good idea for assets , grab it from here --> https://github.com/yakuzan/assets (0.5 day)
* Prevent robots from indexing login and install of admin ( 3 houres)
* add this library --> https://github.com/drmonkeyninja/social-share-url (3 houres)
* add this library --> https://github.com/drmonkeyninja/cakephp-video-helper (3 houres)
* add the api of mailchimp for the email list
* add calculate age , by birth --> https://stackoverflow.com/questions/3776682/php-calculate-age
* create add link tool
* fix broken images -> https://stackoverflow.com/questions/92720/jquery-javascript-to-replace-broken-images?rq=1
* when the user type the password and cap lock, tell the user that cap lock is activated
* check if the user enables cookies, 



## To do in version 1.4 ( 1/1/2019 )
* make the pagination more efficace
* log the activites of users
* make timer for ads
* send email to all users
* ban ip's
* add the progress bar with percentage when uploading files
* add categories filter in post
* create usermeta system
* Add the Documentation For all php codes
* add support tickets system
* limit loggin attempt error in 3 times only
* logout the user in all tabs automatically when user logs out in one of them
* resize the image with php in the places where they don't need full size
* add adblock detecter -> https://stackoverflow.com/questions/4869154/how-to-detect-adblock-on-my-website
* you are offline --> http://github.hubspot.com/offline/docs/welcome/
* secure the website from httrack & similar -> https://stackoverflow.com/questions/10453306/how-can-i-protect-my-site-from-httrack-or-other-softwares-ripping
* Creating a comment and reply system PHP and MySQL ->http://codewithawa.com/posts/creating-a-comment-and-reply-system-php-and-mysql
* this-> https://i.imgur.com/kZjjy1I.png
* photo gallery
* send email to user
* new registred users default role





## To do in version 1.5 ( 1/1/2019 )
* widgets system
* Powerfull security(CSRF,XSS,SQL Injection)
* Tags system
* add admin bar to the front end website
* add checkbox user email activation required
* add checkbox send welcome email
* Disallow Usernames - Prevent Usernames from being registered


## To do in version 1.6 ( 1/1/2019 )
* add support HelpDesck
* add a Ticket Support System


## To do in version 1.7 ( 10/1/2019 )
* Database management -> Making backup - 

## To do in version 1.8 ( 10/1/2019 )
* add the editor https://github.com/ajaxorg/ace
* import from wordpress  --> 
https://royduineveld.nl/creating-your-own-wordpress-import/
https://gist.github.com/royduin/69ff94b68c28419dbd9a8e07dcf13187
* import and export 
* resize preview images --> http://image.intervention.io/
* add this helpers to your helper --> https://laravel-admin.org/docs/#/en/extension-helpers?id=helpers




##  Special thanks :
* <a href='https://www.slimframework.com/'>Slim framework </a> 
* <a href='https://themeforest.net/item/limitless-responsive-web-application-kit/13080328'>limitless admin template</a> 
* <a href='https://github.com/scottconnerly/timezone'> TimeZoneSelect </a>




https://demo.fastadmin.net/admin/dashboard?ref=addtabs


للتواصل / contact
takiddine.job@gmail.com

