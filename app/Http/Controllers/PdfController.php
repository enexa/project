<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ['SW', 'IS', 'IT', 'CS'];
        $years = ['1st', '2nd', '3rd', '4th'];
        $files = [];
    
        foreach ($categories as $category) {
            foreach ($years as $year) {
                $pdfFiles = Storage::files("public/$category/$year");
                $files["$category $year"] = $pdfFiles;
            }
        }
    
        return response()->json(['files' => $files]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'category' => 'required|string',
        'year' => 'required|string',
        'pdf_file' => 'required|mimes:pdf|max:2048',
    ]);

    $category = $request->category;
    $year = $request->year;
    $pdfFile = $request->file('pdf_file');
    $fileName = $pdfFile->getClientOriginalName();

    $pdf = Pdf::create([
        'category' => $category,
        'year' => $year,
        'name' => $fileName,
    ]);

    $pdfFile->storeAs("public/$category/$year", $fileName);

    return response()->json(['message' => 'PDF file uploaded successfully.']);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
