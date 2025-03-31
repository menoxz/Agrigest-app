<?php
namespace App\Http\Controllers;

use App\Models\TypeCulture;
use Illuminate\Http\Request;

class TypeCultureController extends Controller
{
    public function index()
    {
        $cultures = TypeCulture::all();
        return view('type-culture.index', compact('cultures'));
    }

    public function create()
    {
        return view('type-culture.create');
    }

    public function store(Request $request)
{
   // dd("je suis ici 1", $request->all());

    $request->validate([
        'libelle' => 'required|unique:type_cultures|max:255',
    ]);

  //  dd("je suis ici 2");

    TypeCulture::create([
        'libelle' => $request->libelle,
    ]);

    return redirect()->route('type-culture.index')->with('success', 'Type de culture ajouté avec succès.');
}

    

    public function edit(TypeCulture $typeCulture)
    {
        return view('type-culture.edit', compact('typeCulture'));
    }

    public function update(Request $request, TypeCulture $typeCulture)
    {
        $request->validate([
            'libelle' => 'required|max:255|unique:type_cultures,libelle,' . $typeCulture->id,
        ]);

        $typeCulture->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('type-culture.index')->with('success', 'Type de culture mis à jour.');
    }

    public function destroy(TypeCulture $typeCulture)
    {
        $typeCulture->delete();
        return redirect()->route('type-culture.index')->with('success', 'Type de culture supprimé.');
    }
}
