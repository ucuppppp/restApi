<?php
// $siswa = [

//     [
//         "nama" => "Raditya Yusuf Aslam",
//         "umur" => 17
//     ],
//     [
//         "nama" => "Salsabila Aulia Zahra",
//         "umur" => 16
//     ],
//     [
//         "nama" => "IKHSANTRIA",
//         "umur" => 17
//     ],
//     [
//         "nama" => "Yuandhi",
//         "umur" => 17
//     ],
//     [
//         "nama" => "Hamzah Haniffudin Rahman",
//         "umur" => 12
//     ]

// ];

// var_dump($siswa);

$conn = new PDO('mysql:host=localhost;dbname=merchandise', 'root', '');

$db = $conn->prepare('SELECT * FROM catalog');

$db->execute();

$catalog = $db->fetchAll(PDO::FETCH_ASSOC);



$data = json_encode($catalog);
echo $data;
