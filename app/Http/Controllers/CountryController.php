<?php

namespace App\Http\Controllers;

use App\Exports\FileExportByCountry;
use App\Models\Country;
use App\Models\File;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CountryController extends Controller
{
    public function Index()
    {
        return view('add-country');
    }

    public function Store(Request $request)
    {
        $data = $request->validate([
            'country' => 'required|string|unique:countries,country'
        ]);

        $country = Country::create($data);
        return redirect()->route('country-list')->with('success', 'Country created successfully.');
    }
    public function Show()
    {
        $countries = Country::latest('created_at')->paginate(10);

        return view('country-list', compact('countries'));
    }

    public function EditCountry($id)
    {
        $country = Country::findOrFail($id);

        return view('edit-country', compact('country'));
    }
    public function updateCountry($id, Request $request)
    {
        try {
            $country = Country::findOrFail($id);

            $data = $request->validate([
                'country' => 'required|string|unique:countries,country,' . $id,
            ]);

            $country->update($data);

            return redirect()->back()->with('success', 'Country updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating country: ' . $e->getMessage());
        }
    }
    public function deleteCountry($id)
    {
        try {
            $country = Country::findOrFail($id);
            // Uncomment the line below to debug and ensure $country is fetched correctly
            // dd($country);

            $country->delete();

            return redirect()->route('country-list')->with('success', 'Country deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('country-list')->with('error', 'Error deleting country: ' . $e->getMessage());
        }
    }


    

    public function filterFilesByCountry(Request $request)
    {
        $country = $request->input('country');

        // Get all distinct codes filtered by the selected country
        $codes = File::select('code')
            ->where('country', $country)
            ->groupBy('code')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Retrieve all files for the paginated codes
        $files = File::with(['fileDetails', 'client'])
            ->where('country', $country)
            ->whereIn('code', $codes->pluck('code'))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('code');

        $countries = Country::all();

        // Check if export request
        if ($request->input('export') == 1) {
            return Excel::download(new FileExportByCountry($country), 'filtered_files.xlsx');
        }

        return view('file-list-filtered', compact('codes', 'files', 'countries', 'country'));
    }

   
}
