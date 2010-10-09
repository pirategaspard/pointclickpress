2010-10-08
PirateGaspard Presents:
PointClickPress Alpha 2 release
www.pointclickpress.org

PointClickPress is an open source web app game engine for the creation of point and click style games built using Kohana, JQuery, and good ol’ HTML. 
It allows you to create Interactive Stories that you can play in any browser and share with your friends!

PointClickPress has been tested with:
Apache 2.2
PHP 5.3
MySQL 5
FireFox & Chrome 
Teh interwebz

If you have any problems installing or would like to report a bug:
www.pointclickpress.org/forums/

To Install:
1) Mod_rewrite must be enabled in Apache
2) Create an empty MySQL database
3) Edit \config\database.php and enter your database information.
4) Edit .htaccess to make sure RewriteBase is pointing to the correct folder
5) Navigate to WEBROOT\admin\install 
6) Enter a Admin username and password then click install

Alternate Install:
1) Mod_rewrite must be enabled in Apache
2) Create an empty MySQL database
3) Use the provided SQL script to populate database.  
4) Edit \config\database.php and enter your database information.
5) Edit .htaccess to make sure RewriteBase is pointing to the correct folder
6) PointClickPress Username Password in script is admin/admin.


Notes:
If "index.php" is showing in the URL: 
- Check to ensure that mod_rewrite is turned on 
- Check that the REWRITEBASE is set correctly in the .htaccess file. 

Please keep in mind that though PointClickPress should be stable enough to experiment with, this is an alpha release and is not suitable for production environments or small children.
