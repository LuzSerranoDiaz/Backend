<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * clase Controlador de Contrato
 */
class ContractController extends Controller
{

    /*      Route::post('customers/{id}/contracts', [ContractController::class, 'add']);
            Route::get('customers/{id}/contracts', [ContractController::class, 'show']);
            Route::get('customers/{id}/contracts/{contractId}', [ContractController::class, 'getContract']);
            Route::put('customers/{id}/contracts/{contractId}', [ContractController::class, 'update']);
            Route::delete('customers/{id}/contracts/{contractId}', [ContractController::class, 'delete']); */
    /**
     * Añade un contrato a un cliente
     */
    public function add($idCliente ,Request $request) {
        $validatedData = $request->validate([
            'numero_de_atenciones' => 'required|integer|max:50',
            'numero_de_atenciones_realizadas' => 'sometimes|integer|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);


        $contrato = Contrato::create([
            'cliente_id' => $idCliente,
            'numero_de_atenciones' => $validatedData['numero_de_atenciones'],
            'numero_de_atenciones_realizadas' => $validatedData['numero_de_atenciones_realizadas'],
            'fecha_inicio' => $validatedData['fecha_inicio'],
            'fecha_fin' => $validatedData['fecha_fin'],
        ]);

        return response()->json($contrato, 201);
    }

    /**
     * Muestra todos los contratos
     */
    public function showAll() {
        $contratos = Contrato::all();

        return response()->json($contratos, 200);
    }

        /**
     * Muestra los contratos de un cliente
     */
    public function show($idCliente) {
        $contratos = Contrato::where('cliente_id', '=', $idCliente)->get();

        return response()->json($contratos, 200);
    }

    /**
     * Obtiene un contrato de un cliente
     */
    public function getContract($idCliente, $idContrato) {
        try{
            $contrato = Contrato::findOrFail($idContrato);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'contrato no encontrado'], 404);
        }

        return response()->json($contrato, 200);
    }

    /**
     * Modifica un contrato de un cliente
     */
    public function update(Request $request, $idContrato) {
        try{
            $contrato = Contrato::findOrFail($idContrato);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'contrato no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'contrato_id' => 'sometimes|exists:contratos,id,' . $idContrato,
            'numero_de_atenciones' => 'required|integer|max:50',
            'numero_de_atenciones_realizadas' => 'sometimes|integer|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $contrato->update($validatedData);

        return response()->json($contrato, 201);
    }

    /**
     * Elimina un contrato de un cliente
     */
    public function delete($idContrato) {
        try{
            $contrato = Contrato::findOrFail($idContrato);
        }
        catch (ModelNotFoundException){
            return response()->json(['message' => 'contrato no encontrado'], 404);
        }

        $contrato->delete();

        return response()->json(['message' => 'contrato eliminado correctamente'], 200);
    }
}
