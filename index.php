<?php 

require_once("includes/initialize.php");

global $database;

$username='admin';
//echo $x=$database->table('users')->where("username",'=',$username)->count();

//exit();

$x=$database->table('users')->where('username', '=', $username)->first();
print_r($x->username);
//foreach($x as $key=>$ch)
//{
//	echo $ch->username."<br>";
//}



//$database->schema()->create('mytable', function ($table) {
    //$table->increments('id');
    //$table->string('email')->unique();
    //$table->timestamps();
//});
//$users = Students::get();

//foreach($users as $key=>$ch)

//{
	//echo "(NULL, 241, 10, ".$ch->cid.", '300', '2021-02-12', 'Admin', '', '2021-02-12 14:53:40', 'Active'),"."<br>";
//}

  ?>
