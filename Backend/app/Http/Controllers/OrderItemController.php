<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    /**
     * Affiche la liste des articles de commande.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderItems = OrderItem::all();
        return response()->json($orderItems);
    }

    /**
     * Affiche les détails d'un article de commande spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        return response()->json($orderItem);
    }

    /**
     * Crée un nouvel article de commande.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Logique de validation des données d'entrée
        $request->validate([
            // Ajoutez vos règles de validation ici
        ]);

        // Créer un nouvel article de commande
        $orderItem = OrderItem::create($request->all());

        return response()->json($orderItem, 201);
    }

    /**
     * Met à jour un article de commande spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Logique de validation des données d'entrée
        $request->validate([
            // Ajoutez vos règles de validation ici
        ]);

        // Mettre à jour l'article de commande existant
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($request->all());

        return response()->json($orderItem, 200);
    }

    /**
     * Supprime un article de commande spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Trouver et supprimer l'article de commande
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json(null, 204);
    }
}
