<?php
namespace App\Http\Controllers;

use App\Models\TypeCulture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class TypeCultureController extends Controller
{
    public function index()
    {
        $cultures = TypeCulture::where('user_id', Auth::user()->id)->get(); // ✅ seulement les types de l'utilisateur
        return view('type-culture.index', compact('cultures'));
    }

    public function create()
    {
        return view('type-culture.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|unique:type_cultures|max:255',
        ]);

        TypeCulture::create([
            'libelle' => $request->libelle,
            'user_id' => Auth::id() // 👈 Très important !
        ]);

        return redirect()->route('type-culture.index')->with('success', 'Type de culture ajouté avec succès.');
    }

    public function edit(TypeCulture $typeCulture)
    {
        $this->authorizeTypeCulture($typeCulture);
        return view('type-culture.edit', compact('typeCulture'));
    }

    public function update(Request $request, TypeCulture $typeCulture)
    {
        $this->authorizeTypeCulture($typeCulture);

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
        $this->authorizeTypeCulture($typeCulture);
        $typeCulture->delete();
        return redirect()->route('type-culture.index')->with('success', 'Type de culture supprimé.');
    }

    protected function authorizeTypeCulture(TypeCulture $typeCulture)
    {
        if ($typeCulture->user_id !== Auth::user()->id) {
            abort(403, 'Vous n\'avez pas accès à ce type de culture.');
        }
    }
}