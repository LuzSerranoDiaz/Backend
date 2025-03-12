<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\CitaServicio;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function Pest\Laravel\json;

/**
 * Clase Controlador de Citas
 */
class AppointmentController extends Controller
{

    /**
     * Añade una cita
     * 
     * Asocia el o los servicios a la cita
     */
    public function add(Request $request)
    {

        $validatedData = $request->validate([
            'contrato_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'empleado_id' => 'required|integer',
            'arrayServicios' => 'required|array',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,cancelado,completado',
            'numero_de_atenciones' => 'required|integer|max:50',
        ]);

        $cita = Cita::create([
            'cliente_id' => $validatedData['cliente_id'],
            'contrato_id' => $validatedData['contrato_id'],
            'empleado_id' => $validatedData['empleado_id'],
            'fecha' => $validatedData['fecha'],
            'estado' => $validatedData['estado'],
            'numero_de_atenciones' => $validatedData['numero_de_atenciones']
        ]);

        foreach ($validatedData['arrayServicios'] as $idServicio) {
            $citaServicio = CitaServicio::create([
                'cita_id' => $cita->id,
                'servicio_id' => $idServicio,
            ]);
        }

        return response()->json($cita->load('servicios'), 201);
    }

    /**
     * Muestra las citas con sus servicios
     */
    public function show()
    {
        $citas = Cita::all();

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Muestra las citas con sus servicios tengan un contrato especifico
     */
    public function showContract($idContrato)
    {
        try {
            $citas = Cita::where('contrato_id', '=', $idContrato)->get();
            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Muestra las citas con sus servicios donde tengan un cliente especifico
     */
    public function showClient($idCliente)
    {
        try {
            $citas = Cita::where('cliente_id', '=', $idCliente)->get();
            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Muestra las citas con sus servicios donde tengan un empleado especifico
     */
    public function showEmployee($idEmpleado)
    {
        try {
            $citas = Cita::where('empleado_id', '=', $idEmpleado)->get();
            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Muestra las citas con sus servicios donde tengan un contrato y cliente especifico
     */
    public function showContractClient($idContrato, $idCliente)
    {
        try {
            $citas = 
                Cita::where('contrato_id', '=', $idContrato,)
                ->where('cliente_id', '=', $idCliente)
                ->get();
            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Muestra las citas con sus servicios
     */
    public function showContractEmployee($idContrato, $idEmpleado)
    {
        try {
            $citas = 
                Cita::where('contrato_id', '=', $idContrato,)
                ->where('empleado_id', '=', $idEmpleado)
                ->get();
            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Muestra las citas con sus servicios
     */
    public function showClientEmployee($idCliente, $idEmpleado)
    {
        try {
            $citas = 
                Cita::where('cliente_id', '=', $idCliente,)
                ->where('empleado_id', '=', $idEmpleado)
                ->get();
            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($citas->load('servicios'), 200);
    }

    /**
     * Obtiene una cita con su o sus servicios
     */
    public function getAppointment($idCita)
    {
        try {
            $cita = Cita::FindOrFail($idCita);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        return response()->json($cita->load('servicios'), 200);
    }

    /**
     * Modifica una cita con su o sus servicios
     */
    public function update(Request $request, $idCita)
    {
        try {
            $cita = Cita::findOrFail($idCita);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        $citaServicios = CitaServicio::where('cita_id', '=', $idCita)->get(); //No requiere control de errores ya que si idCita fuera erroneo habria saltaado excepcion antes, y si no hay lineas en citaServicios tampoco pasa nada porque se van a crear nuevas ahora
        $arrayServicios = [];

        $validatedData = $request->validate([
            'contrato_id' => 'sometimes|integer',
            'cliente_id' => 'sometimes|integer',
            'empleado_id' => 'sometimes|integer',
            'arrayServicios' => 'sometimes|array',
            'fecha' => 'sometimes|date',
            'estado' => 'sometimes|in:pendiente,cancelado,completado',
            'numero_de_atenciones' => 'required|integer|max:50',
        ]);

        // Si esta vacio usa ya las lineas de citaServicios ya creadas, sino las borra y crea nuevas
        if ($validatedData['arrayServicios']) {
            foreach ($citaServicios as $servicio) {
                $servicio->delete();
            }
            foreach ($validatedData['arrayServicios'] as $idServicio) {
                $citaServicio = CitaServicio::create([
                    'cita_id' => $cita->id,
                    'servicio_id' => $idServicio,
                ]);
            }
        } else {
            foreach ($citaServicios as $servicio) {
                array_push($arrayServicios, $servicio->id);
            }
            $validatedData['arrayServicios'] = $arrayServicios;
        }

        $cita->update($validatedData);

        return response()->json($cita->load('servicios'), 201);
    }

    /**
     * Elimina una cita con su o sus servicios
     */
    public function delete($idCita)
    {
        try {
            $cita = Cita::FindOrFail($idCita);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['message' => 'Cita eliminada correctamente'], 200);
    }
}
