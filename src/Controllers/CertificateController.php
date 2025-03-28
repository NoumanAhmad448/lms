<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Models\Certificate;
use Eren\Lms\Models\Comment;
use Illuminate\Http\Request;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\Media;
use Eren\Lms\Models\RatingModal;
use Eren\Lms\Models\User;
use Eren\Lms\Rules\IsScriptAttack;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Classes\PdfReader;

class CertificateController extends Controller
{
    public function getCert($slug, $code)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $course = Course::where('slug', $slug)->first();
        // Find the certificate
        $certificate = Certificate::where('code', $code)
            ->where('user_id', auth()->id())
            ->where("course_id", $course->id)
            ->first();

        if ($certificate) {
            return response()->json([
                'status' => 'valid',
                'certificate' => $certificate,
                'course' => $certificate->course->name // Assuming you have a course relation
            ]);
        }

        return response()->json(['error' => 'Certificate not found'], 404);
    }
    public function getCertPdf($id)
    {
        // Find the certificate
        $certificate = Certificate::findOrFail($id);

        // Load the course relation
        $certificate->load('course');
        $d = ['course' => $certificate->course->name, 'cert_no' => $certificate->code];

        return PdfReader::getPdf($d, ["download" => true]);
    }
}
