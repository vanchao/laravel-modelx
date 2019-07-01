# laravel-modelx
An artisan console command line that generate model class file with PHPDOC for phpstorm auto prompt <br>

<h1>Installation</h1>
Just download zip file then unzip to your laravel project root directory
Type the command line in your terminal:
<code>php artisan list</code>
If you see make:modelx
```diff
+ Contratulations! Installation complete!
```
- ![#1589F0](https://placehold.it/15/1589F0/000000?text=+) `#1589F0`



<h1>Usage</h1>
In your laravel project root directory, type the command line in your terminal console:<br>
<code>php artisan make:modelx ModelName --table=table-name</code><br>
<h4>Note:</h4> If your database.php has set <b>"prefix"</b>.Your table name shoul not be had this prefix.For examle: you have a table named <code>pre_tbName</code>. If you set <b>"prefix" => "pre_"</b>,just type <b>tbName</b>. Else, type full name of your tablename(<b>pre_tbName</b> for the example).

<h1>Q&A</h1>
When you use it. You would be encounter this problem:
<span style="color:green">Class 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' not found</span>
Just follow this <a href="https://stackoverflow.com/questions/33817983/artisan-migration-error-class-doctrine-dbal-driver-pdomysql-driver-not-fo">link</a> to resolve the problem.
<code>composer require doctrine/dbal</code>

