# laravel-modelx
An artisan console command line that generate model class file with PHPDOC for phpstorm auto prompt. <br>

<h1>Installation</h1>
Just download zip file then unzip it to your laravel project root directory.<br>
Type the command line in your terminal:<br>
<code>php artisan list</code>
If you see <code>make:modelx</code><br>
Contratulations! Installation complete!

<h1>Usage</h1>
In your laravel project root directory, type the command line in your terminal console:<br>
<code>php artisan make:modelx ModelName --table=table-name</code><br>
<h3>Note:</h3> If your database.php has set <b>"prefix"</b>.Your table name should not be had this prefix.For examle: you have a table named <code>pre_tbName</code>. If you set <b>"prefix" => "pre_"</b>,just type <b>tbName</b>. Else, type full name of your tablename(<b>pre_tbName</b> for the example).

<h1>Q&A</h1>
When you use it. You would be encounter this problem:<br>
<code>Class 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' not found</code><br>
Just follow this <a href="https://stackoverflow.com/questions/33817983/artisan-migration-error-class-doctrine-dbal-driver-pdomysql-driver-not-fo">link</a> to resolve the problem.<br>
<code>composer require doctrine/dbal</code><br>
Code was tested in laravel 5.5, 5.6, 5.7, 5.8 version.
