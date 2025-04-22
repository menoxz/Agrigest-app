<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parcelle;
use App\Models\Imprevu;
use App\Models\Intervention;
use App\Models\TypeCulture;
use App\Models\TypeIntervention;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistiques des utilisateurs
        $totalUsers = User::count();
        $activeUsers = User::where('status', true)->count();
        $inactiveUsers = User::where('status', false)->count();

        // Statistiques des types de cultures
        $totalTypeCultures = TypeCulture::count();
        $typeCulturesWithParcelles = TypeCulture::has('parcelles')->count();
        $mostUsedTypeCultures = TypeCulture::withCount('parcelles')
            ->orderByDesc('parcelles_count')
            ->take(5)
            ->get();

        // Statistiques des types d'interventions
        $totalTypeInterventions = TypeIntervention::count();
        $typeInterventionsWithInterventions = TypeIntervention::has('interventions')->count();
        $mostUsedTypeInterventions = TypeIntervention::withCount('interventions')
            ->orderByDesc('interventions_count')
            ->take(5)
            ->get();

        // Statistiques des parcelles
        $totalParcelles = Parcelle::count();

        // Statistiques des interventions
        $totalInterventions = Intervention::count();
        $interventionsByStatus = Intervention::select('statut_intervention', DB::raw('count(*) as total'))
            ->groupBy('statut_intervention')
            ->get()
            ->pluck('total', 'statut_intervention')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalTypeCultures',
            'typeCulturesWithParcelles',
            'mostUsedTypeCultures',
            'totalTypeInterventions',
            'typeInterventionsWithInterventions',
            'mostUsedTypeInterventions',
            'totalParcelles',
            'totalInterventions',
            'interventionsByStatus'
        ));
    }

    // Gestion des utilisateurs
    public function users()
    {
        $users = User::with(['role', 'parcelles'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès');
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $user->update(['status' => !$user->status]);
        $message = $user->status ? 'Utilisateur activé avec succès' : 'Utilisateur désactivé avec succès';
        return redirect()->route('admin.users')->with('success', $message);
    }

    // Gestion des parcelles
    public function parcelles()
    {
        $parcelles = Parcelle::with('typeCulture')->get();
        return view('admin.parcelles.index', compact('parcelles'));
    }

    public function createParcelle()
    {
        $typeCultures = TypeCulture::all();
        return view('admin.parcelles.create', compact('typeCultures'));
    }

    public function storeParcelle(Request $request)
    {
        $validated = $request->validate([
            'nom_parcelle' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'type_culture_id' => 'required|exists:type_cultures,id',
            'date_plantation' => 'required|date'
        ]);

        Parcelle::create($validated);
        return redirect()->route('admin.parcelles')->with('success', 'Parcelle créée avec succès');
    }

    // Gestion des interventions
    public function interventions()
    {
        $interventions = Intervention::with(['parcelle', 'typeIntervention'])->get();
        return view('admin.interventions.index', compact('interventions'));
    }

    public function createIntervention()
    {
        $parcelles = Parcelle::all();
        $typeInterventions = TypeIntervention::all();
        return view('admin.interventions.create', compact('parcelles', 'typeInterventions'));
    }

    public function storeIntervention(Request $request)
    {
        $validated = $request->validate([
            'parcelle_id' => 'required|exists:parcelles,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'date' => 'required|date',
            'description' => 'required|string'
        ]);

        Intervention::create($validated);
        return redirect()->route('admin.interventions')->with('success', 'Intervention créée avec succès');
    }

    // Gestion des imprévus
    public function imprevus()
    {
        $imprevus = Imprevu::with('parcelle')->get();
        return view('admin.imprevus.index', compact('imprevus'));
    }

    public function createImprevu()
    {
        $parcelles = Parcelle::all();
        return view('admin.imprevus.create', compact('parcelles'));
    }

    public function storeImprevu(Request $request)
    {
        $validated = $request->validate([
            'parcelle_id' => 'required|exists:parcelles,id',
            'date' => 'required|date',
            'description' => 'required|string'
        ]);

        Imprevu::create($validated);
        return redirect()->route('admin.imprevus')->with('success', 'Imprévu créé avec succès');
    }

    // Gestion des types de cultures
    public function typeCultures()
    {
        $typeCultures = TypeCulture::all();
        return view('admin.type-cultures.index', compact('typeCultures'));
    }

    public function createTypeCulture()
    {
        return view('admin.type-cultures.create');
    }

    public function storeTypeCulture(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_cultures,libelle',
        ]);

        TypeCulture::create([
            'libelle' => $validated['libelle'],
            'user_id' => auth()->id()
        ]);

        return redirect()->route('admin.type-cultures')->with('success', 'Type de culture créé avec succès');
    }

    public function editTypeCulture(TypeCulture $typeCulture)
    {
        return view('admin.type-cultures.edit', compact('typeCulture'));
    }

    public function updateTypeCulture(Request $request, TypeCulture $typeCulture)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_cultures,libelle,' . $typeCulture->id,
        ]);

        $typeCulture->update([
            'libelle' => $validated['libelle']
        ]);

        return redirect()->route('admin.type-cultures')->with('success', 'Type de culture mis à jour avec succès');
    }

    public function deleteTypeCulture(TypeCulture $typeCulture)
    {
        // Vérifier si le type de culture est utilisé par des parcelles
        if ($typeCulture->parcelles()->count() > 0) {
            return redirect()->route('admin.type-cultures')->with('error', 'Ce type de culture est utilisé par des parcelles et ne peut pas être supprimé.');
        }

        $typeCulture->delete();
        return redirect()->route('admin.type-cultures')->with('success', 'Type de culture supprimé avec succès');
    }

    // Gestion des types d'interventions
    public function typeInterventions()
    {
        $typeInterventions = TypeIntervention::all();
        return view('admin.type-interventions.index', compact('typeInterventions'));
    }

    public function createTypeIntervention()
    {
        return view('admin.type-interventions.create');
    }

    public function storeTypeIntervention(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_interventions,libelle',
        ]);

        TypeIntervention::create([
            'libelle' => $validated['libelle'],
            'user_id' => auth()->id()
        ]);

        return redirect()->route('admin.type-interventions')->with('success', 'Type d\'intervention créé avec succès');
    }

    public function editTypeIntervention(TypeIntervention $typeIntervention)
    {
        return view('admin.type-interventions.edit', compact('typeIntervention'));
    }

    public function updateTypeIntervention(Request $request, TypeIntervention $typeIntervention)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_interventions,libelle,' . $typeIntervention->id,
        ]);

        $typeIntervention->update([
            'libelle' => $validated['libelle']
        ]);

        return redirect()->route('admin.type-interventions')->with('success', 'Type d\'intervention mis à jour avec succès');
    }

    public function deleteTypeIntervention(TypeIntervention $typeIntervention)
    {
        // Vérifier si le type d'intervention est utilisé par des interventions
        if ($typeIntervention->interventions()->count() > 0) {
            return redirect()->route('admin.type-interventions')->with('error', 'Ce type d\'intervention est utilisé par des interventions et ne peut pas être supprimé.');
        }

        $typeIntervention->delete();
        return redirect()->route('admin.type-interventions')->with('success', 'Type d\'intervention supprimé avec succès');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
