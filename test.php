<?php
header( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).' GMT' );

// HTTP/1.1
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', FALSE );

// HTTP/1.0
header( 'Pragma: no-cache' );

require_once('dbinfoset.php');
require_once('User_class.php');


$user = new User('coacer', 'coacer@vate.com', 'password');
$user->save();

echo $user->id;
echo $user->name;
echo $user->email;
echo $user->password;

$user = User::findBy("email", "coacer2@vate.com");
echo $user->id;
echo $user->name;
echo $user->email;
echo $user->password;

$user = new User('coacer3', 'coacer3@vate.com', 'password');
$user->save();

echo $user->id;
echo $user->name;
echo $user->email;
echo $user->password;


