<?php

$data = file_get_contents('coba.json');

$siswa = json_decode($data, true);

var_dump($siswa);
echo $siswa[0]["hobi"][1];
