<?php

namespace App\Controller;

use App\Entity\ImportData;
use App\Form\ImportDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ImportDataController extends AbstractController
{
    // #[Route('/', name: 'app')]
    // public function index(): Response
    // {
    //     $form = $this->createForm(ImportDataType::class);
    //     return $this->renderForm('import_data/index.html.twig', [
    //        'form' => $form,
    //     ]);
    // }

    #[Route('/', name: 'app')]
    public function showGraph(Request $request, SluggerInterface $slugger, ChartBuilderInterface $chartBuilder): Response
    {
        $importData = new ImportData();
        $form = $this->createForm(ImportDataType::class, $importData);
        $form->handleRequest($request);
        $data = [];
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
//&& $form->isValid()
        if ($form->isSubmitted()) {
            /** @var UploadedFile $excelFile */
            $excelFile = $form->get('xlsx')->getData();


           // dd(file_get_contents($excelFile)); die;
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($excelFile) {
                $originalFilename = pathinfo($excelFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $extension = $excelFile->guessExtension();
                $newFilename = $safeFilename.'-'.uniqid().'.'.$extension;


                // Move the file to the directory where brochures are stored

                    $excelFile->move(
                        $this->getParameter('wired_beauty_directory'),
                        $newFilename
                    );
                    /**  Identify the type of $inputFileName  **/
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->getParameter('wired_beauty_directory').'/wired_beauty_datas.xlsx');
//                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($newFilename->getPathname());

                    /**  Advise the Reader that we only want to load cell data  **/
                        $sheet = $spreadsheet->getActiveSheet();

                        $data = $sheet->toArray();

                // instead of its contents
                $importData->setDataFilename($newFilename);
//                    $entityManager = $this->getDoctrine()->getManager();
//                    $entityManager->persist($importData);
//                    $entityManager->flush();

               //dd($data);
                $label = [];
                if($data){
                    foreach($data[0] as $data) {
                        $label[] = $data;
                    }

                    $a = 0;
                    $table = [];

                    foreach ($sheet->getRowIterator() as $row) {
                        $iterator = $row->getCellIterator();
                        $b=0;
                        foreach ($iterator as $key => $cell) {
                            if($a != 0 & $b < 6) {
                                $table[$a][$b] = $cell->getValue();
                            }
                            $b++;
                        }
                        $a++;
                    }
                    //dd($table);

                    $chart->setData([
                        'labels' => [$table[1][4], $table[2][4],$table[3][4], $table[4][4], $table[5][4]],
                        'datasets' => [
                            [
                                'label' => "Score Anti-oxidant: ".$table[1][1],
                                'backgroundColor' => 'rgb(255, 99, 132)',
                                'borderColor' => 'rgb(255, 99, 132)',
                                'data' => [$table[1][5], $table[2][5],$table[3][5], $table[4][5], $table[5][4]],

                            ],
                            [
                                'label' => "Score Natural Moisturizing Factors: ".$table[6][1],
                                'backgroundColor' => 'rgb(155, 10, 158)',
                                'borderColor' => 'rgb(155, 10, 158)',
                                'data' => [$table[6][5], $table[7][5],$table[8][5], $table[9][5], $table[10][4]],

                            ],
                            [
                                'label' => "Score Barrière: ".$table[6][1],
                                'backgroundColor' => 'rgb(199, 10, 158)',
                                'borderColor' => 'rgb(199, 10, 158)',
                                'data' => [$table[11][5], $table[12][5],$table[13][5], $table[14][5], $table[15][4]],

                            ],
                        ],
                    ]);
                    //dd($table);
                    $chart->setOptions([]);
                }

            }

            return $this->renderForm('import_data/graph.html.twig', [
                'data' => $data,
                'form' => $form,
                'chart' => $chart
            ]);
        }
        return $this->renderForm('import_data/index.html.twig', [
            'data' => $data,
            'form' => $form,
            'chart' => $chart
        ]);
    }

}


