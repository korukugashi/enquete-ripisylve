<?php

require __DIR__.'/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$handle = fopen(__DIR__.'/data', 'r');
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = ['Numéro', 'Date', 'Heure', 'Adresse', 'Latitude', 'Longitude',
  'Nom', 'Prénom', 'Email', 'Téléphone',
  'Nom du propriétaire', 'Prénom du propriétaire', 'Email du propriétaire', 'Téléphone du téléphone',
  'Remarques'];

foreach ($headers as $index => $columnName) {
  $sheet->setCellValueByColumnAndRow($index + 1, 1, $columnName);
}

if ($handle) {
  $numRow = 1;

  while (($line = fgets($handle)) !== false) {
    $numRow++;
    $data = json_decode($line, true);
    $date = new DateTime($data['date']);
    $values = [
      $numRow - 1,
      $date->format('d/m/Y'),
      $data['heure'],
      $data['adresse'],
      $data['lat'],
      $data['lon'],
      mb_strtoupper($data['name'], 'UTF-8'),
      $data['firstname'],
      $data['email'],
      $data['phone'],
      mb_strtoupper($data['propName'], 'UTF-8'),
      $data['propFirstname'],
      $data['propEmail'],
      $data['propPhone'],
      $data['remarks']
    ];

    foreach ($values as $index => $value) {
      $sheet->setCellValueByColumnAndRow($index + 1, $numRow, $value);
    }
  }

  fclose($handle);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="ripisylve.xlsx"');
  header('Cache-Control: max-age=0');
  
  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output'); 
} else {
  echo 'Error lors de l\'ouverture du fichier de données';
}

