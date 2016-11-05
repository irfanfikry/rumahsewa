<?php

function dbConnect()
{
    try
		{
            $username = 'root'; //Change to your username for phpmyadmin
            $userpassword = 'fakhrupi'; //Please enter your password for phpmyadmin
            $conn = new pdo("mysql:host=localhost;dbname=rumahsewa;", $username, $userpassword); 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        }   catch(PDOException $e){
            echo 'ERROR', $e->getMessage();
    }
}
