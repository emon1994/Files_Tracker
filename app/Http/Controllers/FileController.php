<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\FileDetail;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Facade;




class FileController extends Controller
{
    public function submitFile()
    {
        $clients = Client::all();
        $countries = Country::all();
        // dd($countries);
        return view('submit-form', ['clients' => $clients, 'countries' => $countries]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the form data
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'country' => 'required|string',
            'files.*' => 'required|mimes:pdf,docx,jpg,jpeg,png|max:2048', // Example validation for files
            'note' => 'nullable|string',
            'receiver' => 'required|string',
        ]);

        try {
            // Generate unique code
            $code = $this->generateUniqueCode();

            // Create a new File model instance
            $file = new File();
            $file->client_id = $validatedData['client_id'];
            $file->country = $validatedData['country'];
            $file->note = $validatedData['note'];
            $file->receiver = $validatedData['receiver'];
            $file->code = $code; // Assign generated code
            $file->save(); // Save the File model to get its ID

            // Handle file uploads
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $uploadedFile) {
                    // Store file in storage/app/public/files (adjust as needed)
                    $path = $uploadedFile->store('public/files');

                    // Create a new FileDetail model instance
                    $fileDetail = new FileDetail();
                    $fileDetail->filename = $uploadedFile->getClientOriginalName(); // Example: original file name
                    $fileDetail->file_path = $path; // Store the file path
                    $fileDetail->file_id = $file->id; // Associate with the File model
                    $fileDetail->save(); // Save the FileDetail model
                }
            }

            // Redirect back with success message
            return redirect()->route('file-list')->with('success', 'File information saved successfully.');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->back()->with('error', 'Failed to save file information. Please try again.');
        }
    }

    // Method to generate unique code
    protected function generateUniqueCode()
    {
        $latestFile = File::latest()->first();

        if (!$latestFile) {
            $sequence = 1;
        } else {
            $sequence = intval(substr($latestFile->code, -5)) + 1;
        }

        return sprintf("FILE-%05d", $sequence);
    }

    public function showFiles()
    {
        // Get all distinct codes
        $codes = File::select('code')
            ->groupBy('code')
            // ->latest('created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Retrieve all files for the paginated codes
        $files = File::with(['fileDetails', 'client'])
            ->whereIn('code', $codes->pluck('code'))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('code');

        $countries = Country::all();

        return view('file-list', compact('codes', 'files','countries'));
    }


    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->back()->with('success', ' file deleted successsfuly!!');
    }

    public function edit($id)
    {
        $file = File::with('fileDetails')->findOrFail($id);
        // Assuming you have a list of clients for dropdown selection
        $clients = Client::all();
        $countries = Country::all();
        return view('edit-file', compact('file', 'clients', 'countries'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'country' => 'required|string',
            'files.*' => 'nullable|mimes:pdf,docx,jpg,jpeg,png|max:2048', // Example validation for files
            'note' => 'nullable|string',
            'status' => 'nullable|string',
            'receiver' => 'required|string',
        ]);



        $file = File::findOrFail($id);
        $file->client_id = $validatedData['client_id'];
        $file->country = $validatedData['country'];
        $file->note = $validatedData['note'];
        $file->receiver = $validatedData['receiver'];
        $file->status = $validatedData['status'];
        $file->save();

        // Handle file uploads if any
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('public/files');

                $fileDetail = new FileDetail();
                $fileDetail->filename = $uploadedFile->getClientOriginalName();
                $fileDetail->file_path = $path;
                $fileDetail->file_id = $file->id;
                $fileDetail->save();
            }
        }

        return redirect()->route('file-list')->with('success', 'File updated successfully.');
    }



    public function deleteFileDetail($id)
    {
        try {
            // Find the file detail record by ID
            $fileDetail = FileDetail::findOrFail($id);

            // Check if the associated file exists in storage and delete it
            if (Storage::exists($fileDetail->file_path)) {
                Storage::delete($fileDetail->file_path);
            }

            // Delete the file detail record from the database
            $fileDetail->delete();

            return redirect()->back()->with('success', 'File detail deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete file detail. ' . $e->getMessage());
        }
    }

    public function showTransferForm($id)
    {
        $file = File::findOrFail($id);
        if ($file && $file->status == 'rejected') {
            // Your file transfer logic here
            $file->status = 'transferred';
            $file->save();
        }
        $countries = Country::all();
        $clients = Client::all();
        return view('transfer-form', compact('file', 'clients', 'countries'));
    }
    public function transferFile(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'new_country' => 'required|string',
        ]);

        try {
            // Find the original File by ID
            $file = File::findOrFail($id);

            // Duplicate the File and associated FileDetail records
            $newFile = $file->replicate();
            $newFile->country = $validatedData['new_country'];
            $newFile->status = 'migrated';
            // Keep the original code for the replicated file
            $newFile->code = $file->code; // Assign the original code
            $newFile->push(); // Save the new File model to get its ID

            foreach ($file->fileDetails as $fileDetail) {
                $newFileDetail = $fileDetail->replicate();
                $newFileDetail->file_id = $newFile->id; // Associate with the new File model
                $newFileDetail->save(); // Save the new FileDetail model
            }

            // Redirect back with success message
            return redirect()->route('file-list')->with('success', 'File transferred successfully to the new country.');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->route('file-list')->with('error', 'Failed to transfer file. Please try again.');
        }
    }
}
