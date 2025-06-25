<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('admin.documentation.index');
    }

    public function downloadPdf($type)
    {
        switch ($type) {
            case 'admin':
                $view = 'admin.documentation.admin-manual';
                $filename = 'admin-user-manual.pdf';
                break;
            case 'client':
                $view = 'admin.documentation.client-manual';
                $filename = 'client-user-manual.pdf';
                break;
            case 'system':
                $view = 'admin.documentation.system-manual';
                $filename = 'system-documentation.pdf';
                break;
            default:
                abort(404);
        }

        $pdf = PDF::loadView($view);
        return $pdf->download($filename);
    }
} 