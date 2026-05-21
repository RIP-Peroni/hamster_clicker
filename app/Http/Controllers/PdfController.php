<?php

namespace App\Http\Controllers;

use App\Services\GotenberService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    protected $gotenberg;

    public function __construct(GotenberService $gotenberg)
    {
        $this->gotenberg = $gotenberg;
    }

    public function download(Request $request): Response
    {
        $user = Auth::user();

        $clickController = app(ClickController::class);
        $stats = $clickController->stats($request)->getData();

        $html = view('pdf.report', [
            'user' => $user,
            'total' => $stats->total,
            'today' => $stats->today,
            'last7Days' => $stats->last7Days,
            'generatedAt' => now()->format('Y-m-d H:i:s'),
        ])->render();

        $pdfContent = $this->gotenberg->generatePdf($html);

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="hamster-report.pdf"');
    }
}
