<?php
namespace App\Http\Controllers;
use App\Models\Reading;
use Illuminate\Http\Request;

class ReadingController extends Controller
{    
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'meter_id' => 'required|exists:meters,id', 
            'reading_value' => 'required|numeric', 
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'reading_date' => 'required|date', 
        ]);

        // Handle photo upload if it exists
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('uploads/readings', 'public');
        }

        // Extract year, month, and day from the reading_date
        $readingDate = new \DateTime($validated['reading_date']);
        $validated['reading_year'] = (int) $readingDate->format('Y');
        $validated['reading_month'] = (int) $readingDate->format('m');
        $validated['reading_day'] = (int) $readingDate->format('d');

        // Remove reading_date as it is not part of the database schema
        unset($validated['reading_date']);

        // Create the reading record
        $reading = Reading::create($validated);

        // Return a success response
        return response()->json([
            'message' => 'Reading created successfully!',
            'data' => $reading,
        ], 201);
    }
}
