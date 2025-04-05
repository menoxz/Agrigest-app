<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParcelleUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assignUser(Request $request, Parcelle $parcelle)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        // Vérifier si l'utilisateur a les droits d'administration
        if (!Auth::user()->role || Auth::user()->role->nom_role !== 'admin') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        // Vérifier si la parcelle a déjà un utilisateur
        if ($parcelle->user_id) {
            return response()->json(['message' => 'Cette parcelle a déjà un utilisateur assigné'], 400);
        }

        $parcelle->user_id = $request->user_id;
        $parcelle->save();

        return response()->json([
            'message' => 'Utilisateur assigné avec succès',
            'parcelle' => $parcelle->load('user')
        ]);
    }

    public function removeUser(Parcelle $parcelle)
    {
        // Vérifier si l'utilisateur a le role requis
        if (!Auth::user()->role || Auth::user()->role->nom_role !== 'agriculteur') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $parcelle->user_id = null;
        $parcelle->save();

        return response()->json([
            'message' => 'Utilisateur retiré avec succès',
            'parcelle' => $parcelle
        ]);
    }

    public function getParcelleUser(Parcelle $parcelle)
    {
        return response()->json([
            'user' => $parcelle->user
        ]);
    }
}
