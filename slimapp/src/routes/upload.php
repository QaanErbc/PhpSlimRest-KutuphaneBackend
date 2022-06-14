<?php
header('Access-Control-Allow-Origin: *');

$filename = $_FILES["file"]["name"];
$tempname = $_FILES["file"]["tmp_name"];
$folder = "images/" . $filename;

if (move_uploaded_file($tempname, $folder)) {
    header('Content-type: application/json');
    $data = ['success' => true, 'message' => 'Resim başarı ile yüklendi'];
    echo json_encode($data);
    return;
}
header('Content-type: application/json');
$data = ['success' => false, 'message' => 'Resim yüklenirken bir hata oluştu, lütfen tekrar deneyin!'];
echo json_encode($data);
