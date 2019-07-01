# laravel-modelx
An artisan console command line that generate model class file with PHPDOC for phpstorm auto prompt <br>

<h1>Installation</h1>
Just download zip file then unzip to your laravel project root directory
Type the command line in your terminal:
<code>php artisan list</code>
If you see make:modelx
Contratulations! Installation complete!


<h1>Usage</h1>
In your laravel project root directory, type the command line in your terminal console:
<code>php artisan make:modelx ModelName --table=table-name</code>
<h4>Note:</h4> If your database.php has set <h6>"prefix"</h6>.Your table name shoul not be had this prefix.For examle: you have a table named pre-tbName. If you set <h6>"prefix" => "pre_"</h6> Just type tbName. Else, type full name of your tablename(pre-tbName for the example).

<h1>Q&A</h1>
When you use it. You would be encounter this problem:
<div style="color:green">Class 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' not found</div>
Just follow this <a href="https://stackoverflow.com/questions/33817983/artisan-migration-error-class-doctrine-dbal-driver-pdomysql-driver-not-fo">link</a> to resolve the problem.
<code>composer require doctrine/dbal</code>

