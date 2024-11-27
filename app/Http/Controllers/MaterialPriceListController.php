<?php
namespace App\Http\Controllers;

use App\Models\MaterialPriceList;
use Illuminate\Http\Request;

class MaterialPriceListController extends Controller
{
    public function index()
    {
        $materialPriceLists = MaterialPriceList::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Material price lists retrieved successfully.',
            'data' => $materialPriceLists,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price_group' => 'nullable|string',
            'material' => 'required|string',
            'specification' => 'nullable|string',
            'size' => 'nullable|string',
            'low_price_point' => 'nullable|numeric',
            'higher_price_point' => 'nullable|numeric',
            'average_price_point' => 'nullable|numeric',
        ]);

        $materialPriceList = MaterialPriceList::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Material price list created successfully.',
            'data' => $materialPriceList,
        ], 201);
    }

    public function show($id)
    {
        $materialPriceList = MaterialPriceList::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Material price list retrieved successfully.',
            'data' => $materialPriceList,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $materialPriceList = MaterialPriceList::findOrFail($id);

        $validated = $request->validate([
            'price_group' => 'nullable|string',
            'material' => 'required|string',
            'specification' => 'nullable|string',
            'size' => 'nullable|string',
            'low_price_point' => 'nullable|numeric',
            'higher_price_point' => 'nullable|numeric',
            'average_price_point' => 'nullable|numeric',
        ]);

        $materialPriceList->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Material price list updated successfully.',
            'data' => $materialPriceList,
        ], 200);
    }

    public function destroy($id)
    {
        $materialPriceList = MaterialPriceList::findOrFail($id);
        $materialPriceList->delete();

        return response()->json([
            'success' => true,
            'message' => 'Material price list deleted successfully.',
            'data' => null,
        ], 200);
    }
}
