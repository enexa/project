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
        $pdfs = Pdf::all();
    
        return response()->json($pdfs);
    }
    

    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request)
// {
//     $request->validate([
//         'category' => 'required|string',
//         'year' => 'required|string',
//         'pdf_file' => 'required|mimes:pdf|max:2048',
//     ]);

//     $category = $request->category;
//     $year = $request->year;
//     $pdfFile = $request->file('pdf_file');
//     $fileName = $pdfFile->getClientOriginalName();

//     $pdf = Pdf::create([
//         'category' => $category,
//         'year' => $year,
//         'name' => $fileName,
//     ]);

//     $pdfFile->storeAs("public/$category/$year", $fileName);

//     return response()->json(['message' => 'PDF file uploaded successfully.']);
// }
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
    return   redirect()->route('admin.index')
    ->with('success','You have successfully upload file.')
    ->with('file',$fileName);
   
}
    /**
     * Display the specified resource.
     */
    public function add(Request $request)
    {
        //
        $request->validate([
            'category' => 'required|string',
            'year' => 'required|string',
            'pdf_file' => 'required|mimes:pdf|max:2048',
        ]);
        $category = $request->category;
    $year = $request->year;
    $pdfFile = $request->file('pdf_file');
    $fileName = $pdfFile->getClientOriginalName();
    $fileName = str_replace('+', ' ', $fileName); // Replace '+' with space
   $pdfFile->storeAs("public/$category/$year", $fileName);

    $pdf = new Pdf;
    $pdf->category = $category;
    $pdf->year = $year;
    $pdf->name = $fileName;
    $pdf->path = url("temp-pdf/$category/$year/" . urlencode($fileName)); // Include temp-pdf segment in the URL
    $pdf->save();
    return response()->json([
        'message' => 'success', 'You have successfully uploaded the file.',
      
    ]);

   
       
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
    public function pdfadd(Request $request)
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
    $path = $pdfFile->storeAs("public/$category/$year", $fileName);

    $pdf = new Pdf;
    $pdf->category = $category;
    $pdf->year = $year;
    $pdf->name = $fileName;
    $pdf->path = url('storage/' . $path); // Store the full URL in the 'path' column
    $pdf->save();

    return redirect()->route('admin.index')
        ->with('success', 'You have successfully uploaded the file.')
        ->with('file', $fileName);
}
}
