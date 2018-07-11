<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use File;

class IqosController extends Controller
{
    public function parse()
    {
        $file = Input::file('attachment');
        $data = [];
        $maxR = [];
        $result = Excel::selectSheetsByIndex(0)->load($file, function ($reader) use (&$data, &$maxR) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $maxR = $sheet->getHighestRow();
            list($coach, $data) = $this->parseData($sheet, $maxR);
            foreach (array_unique($coach) as $coach) {
                $coachData = [];
                Excel::create($coach, function ($excel) use ($data, $coachData, $coach) {
                    foreach ($data as $cd) {
                        if ($cd['coach'] === $coach) {
                            array_push($coachData, $cd);
                        }
                    }
                    $excel->sheet('Sheetname', function ($sheet) use ($data, $coachData) {
                        $sheet->cell('A1', function($cell) {$cell->setValue('Nome');   });
                        $sheet->cell('B1', function($cell) {$cell->setValue('Cognome');   });
                        $sheet->cell('C1', function($cell) {$cell->setValue('Cellulare');   });
                        foreach ($coachData as $key => $value) {
                            $i= $key+2;
                            $sheet->cell('A'.$i, $value['first_name']);
                            $sheet->cell('B'.$i, $value['last_name']);
                            $sheet->cell('C'.$i, $value['phone']);
                        }
                    });

                })->store('csv', storage_path('excel/exports'));
            }
        });
        if ($result) {
            $zipFileName = 'Primi '. Carbon::now()->format('d-m-Y') .'.zip';
            $filePath = storage_path('excel/exports');
            // Create ZipArchive Obj
            $zip = new ZipArchive;
            if ($zip->open(public_path() . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                foreach (File::allFiles($filePath) as $file){
                    $zip->addFile($file, $file->getRelativePathname());
                }
                $zip->close();
                (new Filesystem)->cleanDirectory($filePath);
            }
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
            $fileToPath=public_path($zipFileName);
            // Create Download Response
            if(file_exists($fileToPath)){
                return response()->download($fileToPath,$zipFileName,$headers)->deleteFileAfterSend(true);
            }
        }

    }

    protected function parseData($reader, $maxRow)
    {
        try {
            $startRow = 2;
            $parsedData = [];
            $coach = [];
            do {
                if (
                trim($reader->getCell(sprintf('A%s', $startRow))->getValue())
                ) {
                    if ($reader->getCell(sprintf('D%s', $startRow))->getValue()) {
                        $d = ' ' . $reader->getCell(sprintf('D%s', $startRow))->getValue();
                    } else {
                        $d = '';
                    }
                    if ($reader->getCell(sprintf('K%s', $startRow))->getValue()) {
                        $k = ' ' . $reader->getCell(sprintf('K%s', $startRow))->getValue();
                    } else {
                        $k = '';
                    }
                    if ($reader->getCell(sprintf('M%s', $startRow))->getValue()) {
                        $m = ' ' . $reader->getCell(sprintf('M%s', $startRow))->getValue();
                    } else {
                        $m = '';
                    }
                    if ($reader->getCell(sprintf('N%s', $startRow))->getValue()) {
                        $n = ' ' . $reader->getCell(sprintf('N%s', $startRow))->getValue();
                    } else {
                        $n = '';
                    }
                    array_push($coach, $reader->getCell(sprintf('L%s', $startRow))->getValue());
                    array_unique($coach);
                    array_push($parsedData, [
                        'first_name' => $reader->getCell(sprintf('A%s', $startRow))->getValue(),
                        'last_name' => $reader->getCell(sprintf('B%s', $startRow))->getValue() . $d . $k . $m . $n,
                        'phone' => $reader->getCell(sprintf('E%s', $startRow))->getValue(),
                        'coach' => $reader->getCell(sprintf('L%s', $startRow))->getValue()
                    ]);
                }
                $startRow += 1;
            } while ($startRow <= $maxRow);
            return [$coach, $parsedData];
        } catch (\Exception $exception) {
            print_r($exception);
//            return redirect()->back();
        }
    }
}
