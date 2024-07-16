<?php

namespace App\Http\Controllers;

use App\Exports\FileExportByClient;
use App\Models\Client;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    //
    function index()
    {
        return view('client-form');
    }
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email|unique:clients',
            'company' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $clients = Client::create($validatedData);

        return redirect()->back()->with('success', 'Client created successfully.');
    }

    public function showClientList()
    {
        $clients = Client::latest()->paginate(6);
        // dd($clients);

        return view('client-list', compact('clients'));
    }
    public function deleteClient($id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->files()->delete();
            $client->delete();
            return redirect()->back()->with('success', 'Client and all associated data deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Client not found.');
        }
    }

    public function editClient($id)
    {
        $data = Client::find($id);
        return view('edit-client-data', compact('data'));
    }

    public function updateClient(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email|unique:clients,email,' . $id,
            'company' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        $client = Client::findOrFail($id);
        $client->update($validatedData);
        return redirect()->route('client-list')->with('success', 'Client Updated Successfully.');
    }

    // public function ViewClientFile($id)
    // {
    //     $codes = File::select('code')
    //         ->where('client_id', $id)
    //         ->groupBy('code')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(5);

    //     $files = File::with(['fileDetails', 'client'])
    //         ->where('client_id', $id)
    //         ->whereIn('code', $codes->pluck('code'))
    //         ->orderBy('created_at', 'desc')
    //         ->get()
    //         ->groupBy('code');

    //     return view('client-file', compact('codes', 'files'));
    // }

    // public function exportClientFiles()
    // {


    //     return Excel::download(new FileExportByClient($files), 'client_files.xlsx');
    // }

    public function ViewClientFile($id)
    {
        $codes = File::select('code')
            ->where('client_id', $id)
            ->groupBy('code')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $files = File::with(['fileDetails', 'client'])
            ->where('client_id', $id)
            ->whereIn('code', $codes->pluck('code'))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('code');

        // Store files in session
        Session::put('client_files', $files);

        return view('client-file', compact('codes', 'files'));
    }

    public function exportClientFiles()
    {
        // Retrieve files from session
        $files = Session::get('client_files');

        // Check if files exist in the session
        if (!$files) {
            return redirect()->back()->with('error', 'No files available for export.');
        }

        return Excel::download(new FileExportByClient($files), 'client_files.xlsx');
    }
}
