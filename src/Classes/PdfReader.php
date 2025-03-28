<?php

namespace Eren\Lms\Classes;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfReader
{
    private static $download = false;

    public static function  getPdf($d, $option = [])
    {

        $date = LmsCarbon::now($toDateString = true);

        if (key_exists("download", $option)) {
            self::$download = true;
        }
        $path = config("setting.cert_img_path");

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $img = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $d['img'] = $img;
        $d["date"] = $date;
        $d["name"] = auth()->user()->name;

        $pdf = PDF::loadView("course.certificate", $d)->setPaper('a4', 'landscape')->setWarnings(false);
        return self::$download ? $pdf->download() : $pdf->stream('certificate.pdf');
    }
}
