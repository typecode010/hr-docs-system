<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class PdfService
{
    /**
     * Generate a PDF from the given HTML and return the file path.
     */
    public function generate(string $html, string $fileName): string
    {
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'sans-serif');

        $path = storage_path('app/documents/'.$fileName);

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $pdf->save($path);

        return $path;
    }

    /**
     * Stream the PDF inline to the browser.
     */
    public function stream(string $path, string $fileName): Response
    {
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
        ]);
    }

    /**
     * Download the PDF file.
     */
    public function download(string $path, string $fileName): Response
    {
        return response()->download($path, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
