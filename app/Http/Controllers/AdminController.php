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

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', true)->count();
        $inactiveUsers = User::where('status', false)->count();

        return view('admin.dashboard', compact('totalUsers', 'activeUsers', 'inactiveUsers'));
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
            'description' => 'required|string',
            'impact' => 'required|string'
        ]);

        Imprevu::create($validated);
        return redirect()->route('admin.imprevus')->with('success', 'Imprévu créé avec succès');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
