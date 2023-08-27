<?php
require '../../function.php';

$search = trim($_POST["what"]);



if ($search != '') {
    $get = file_get_contents('temp.json');
    $temp = searchJson($get, $search) ;
    $view = '';
    $view .= '<table class="w-full md:table-fixed text-sm text-left text-gray-500">' .
        '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
        '<tr>' .
        '<th scope="col" class="px-6 py-3">No</th>' .
        '<th scope="col" class="px-6 py-3">Ident Code</th>' .
        '<th scope="col" class="px-6 py-3">MIR No</th>' .
        '<th scope="col" class="px-6 py-3">Spool No</th>' .
        '<th scope="col" class="px-6 py-3">MIR Qty</th>' .
        '</tr>' .
        '</thead>' .
        '<tbody>';
    for ($i = 0; $i < count($temp); $i++) {
        $view .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $i + 1 . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["Ident Code"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["Batch No"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["Spool No"] . '</td>' .
                '<td class="px-6 py-4">' . round($temp[$i]["Qty"], 2) . '</td>' .
                '</tr>';
    }
    $view .= '</tbody>' .
        '</table>';
    echo $view;

} else {
    if (file_exists('temp.json')) {
        $get = file_get_contents('temp.json');
        $temp = json_decode($get, true);
        $view = '';
        $view .= '<table class="w-full md:table-fixed text-sm text-left text-gray-500">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">MIR No</th>' .
            '<th scope="col" class="px-6 py-3">Spool No</th>' .
            '<th scope="col" class="px-6 py-3">MIR Qty</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        for ($i = 0; $i < count($temp); $i++) {
            $view .= '<tr class="bg-white border-b">' .
                    '<td class="px-6 py-4">' . $i + 1 . '</td>' .
                    '<td class="px-6 py-4">' . $temp[$i]["Ident Code"] . '</td>' .
                    '<td class="px-6 py-4">' . $temp[$i]["Batch No"] . '</td>' .
                    '<td class="px-6 py-4">' . $temp[$i]["Spool No"] . '</td>' .
                    '<td class="px-6 py-4">' . round($temp[$i]["Qty"], 2) . '</td>' .
                    '</tr>';
        }

        $view .= '</tbody>' .
            '</table>';
        echo $view;
    } else {
        $view = '<h1 class="w-full h-[200px] flex items-center justify-center font-bold text-md text-gray-700">Getting Data . . .</h1>' ;
        echo $view ;
    }
}