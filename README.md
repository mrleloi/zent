- Database:
  - File db: zent_240118.sql
  - Account đăng nhập admin: admin / 123456
  - Sửa thông tin db tại: C:\xampp\htdocs\zent\etc\db_config.php (line 18-20)
- Cài đặt với XAMPP APACHE (WINDOWS):
  - Ví dụ đường dẫn folder source là : C:/xampp/htdocs/zent >> Thay đổi lại.
  - Tìm file: C:\xampp\apache\conf\extra\httpd-vhosts.conf
  - Thêm vào cuối file dòng: 
Include "C:/xampp/htdocs/zent/vhost/*.conf"

  - Tìm file: C:\xampp\htdocs\zent\vhost\00.php.admin.include_path-dev
  - Sửa lại thành:
php_value include_path ".;C:\xampp\htdocs\zent\admin\etc;C:\xampp\htdocs\zent\admin\lib;C:\xampp\htdocs\zent\etc;C:\xampp\htdocs\zent\lib;C:\xampp\php\pear;C:\xampp\php"
  >> chú ý: đây là cấu hình include_path của Windows, với Linux sẽ cấu hình khác (xem tại: https://www.php.net/manual/en/ini.core.php#ini.include-path)

  - Các file trong folder C:\xampp\htdocs\zent\vhost, tìm và replace đường dẫn mặc định thành C:\xampp\htdocs\zent\vhost
    
  - File "C:\xampp\htdocs\zent\lib\formdecorder.php" khi sử dụng sẽ gặp lỗi do source code dùng PHP version cũ, với PHP 8 trở lên sửa lại dòng 227 thành:
  foreach($vars as $key=>$val){

