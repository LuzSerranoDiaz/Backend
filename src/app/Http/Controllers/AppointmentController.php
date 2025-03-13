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
        ], [
            'contrato_id.required' => 'El contrato es obligatorio',
            'contrato_id.integer' => 'El contrato debe ser un numero entero',

            'cliente_id.required' => 'El cliente es obligatorio',
            'cliente_id.integer' => 'El cliente debe ser un numero entero',

            'empleado_id.required' => 'El empleado es obligatorio',
            'empleado_id.integer' => 'El empleado debe ser un numero entero',

            'arrayServicios.required' => 'Es obligatorio poner los servicios',
            'arrayServicios.array' => 'Los servicios deben incluirse como un array []',

            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date' => 'La fecha tiene que estar en formato yyyy-mm-dd',

            'estado.required' => 'El estado de la cita es obligatorio (pendiente, cancelado, completado)',
            'estado.in' => 'El estado de la cita debe ser: pendiente, cancelado o completado',

            'numero_de_atenciones.required' => 'El numero de atenciones es obligatorio',
            'numero_de_atenciones.max' => 'El maximo de numero de atenciones es 50',
            'numero_de_atenciones.integer' => 'el numero de atenciones debe ser un numero entero'
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
    public function show($offset, $limit, $withServicios)
    {
        //Vuelve withServicios a booleano, acepta 1, "1", true, "true", "on", y "yes" como true y cualquier otro valor devuelve falso
        $withBoolean = $withServicios->boolean();

        // Offset y limit para limitar las lineas mostradas
        if ($offset > Cita::count() || $limit > Cita::count()) {
            return response()->json(['Message' => 'Offset o limit supera el número de lineas en tabla'], 400);
        }

        // Si limit es 0 se ensena todo
        if ($limit == 0) {
            $citas = Cita::all();
        } else {
            $citas = Cita::all()->offset($offset)->limit($limit);
        }

        //$withServicios es un booleano para indicar si se quieren ver los servicios o no de cada cita
        $withBoolean ? $return = response()->json($citas->load('servicios'), 200) :
            $return = response()->json($citas, 200);

        return $return;
    }

    /**
     * Muestra las citas con sus servicios tengan un contrato especifico
     */
    public function showContract($idContrato, $offset, $limit, $withServicios)
    {
        //Vuelve withServicios a booleano, acepta 1, "1", true, "true", "on", y "yes" como true y cualquier otro valor devuelve falso
        $withBoolean = $withServicios->boolean();

        try {
            // Offset y limit para limitar las lineas mostradas
            if ($offset > Cita::count() || $limit > Cita::count()) {
                return response()->json(['Message' => 'Offset o limit supera el número de lineas en tabla'], 400);
            }

            // Si limit es 0 se ensena todo
            if ($limit == 0) {
                $citas = Cita::where('contrato_id', '=', $idContrato)->get();
            } else {
                $citas = Cita::where('contrato_id', '=', $idContrato)->offset($offset)->limit($limit)->get();
            }

            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        //$withServicios es un booleano para indicar si se quieren ver los servicios o no de cada cita
        $withBoolean ? $return = response()->json($citas->load('servicios'), 200) :
            $return = response()->json($citas, 200);

        return $return;
    }

    /**
     * Muestra las citas con sus servicios donde tengan un cliente especifico
     */
    public function showClient($idCliente, $offset, $limit, $withServicios)
    {
        //Vuelve withServicios a booleano, acepta 1, "1", true, "true", "on", y "yes" como true y cualquier otro valor devuelve falso
        $withBoolean = $withServicios->boolean();

        try {
            // Offset y limit para limitar las lineas mostradas
            if ($offset > Cita::count() || $limit > Cita::count()) {
                return response()->json(['Message' => 'Offset o limit supera el número de lineas en tabla'], 400);
            }

            // Si limit es 0 se ensena todo
            if ($limit == 0) {
                $citas = Cita::where('cliente_id', '=', $idCliente)->get();
            } else {
                $citas = Cita::where('cliente_id', '=', $idCliente)->offset($offset)->limit($limit)->get();
            }

            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        //$withServicios es un booleano para indicar si se quieren ver los servicios o no de cada cita
        $withBoolean ? $return = response()->json($citas->load('servicios'), 200) :
            $return = response()->json($citas, 200);

        return $return;
    }

    /**
     * Muestra las citas con sus servicios donde tengan un empleado especifico
     */
    public function showEmployee($idEmpleado, $offset, $limit, $withServicios)
    {
        //Vuelve withServicios a booleano, acepta 1, "1", true, "true", "on", y "yes" como true y cualquier otro valor devuelve falso
        $withBoolean = $withServicios->boolean();

        try {
            // Offset y limit para limitar las lineas mostradas
            if ($offset > Cita::count() || $limit > Cita::count()) {
                return response()->json(['Message' => 'Offset o limit supera el número de lineas en tabla'], 400);
            }

            // Si limit es 0 se ensena todo
            if ($limit == 0) {
                $citas = Cita::where('empleado_id', '=', $idEmpleado)->get();
            } else {
                $citas = Cita::where('empleado_id', '=', $idEmpleado)->offset($offset)->limit($limit)->get();
            }

            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        //$withServicios es un booleano para indicar si se quieren ver los servicios o no de cada cita
        $withBoolean ? $return = response()->json($citas->load('servicios'), 200) :
            $return = response()->json($citas, 200);

        return $return;
    }

    /**
     * Muestra las citas con sus servicios donde tengan un contrato y cliente especifico
     */
    public function showContractClient($idContrato, $idCliente, $offset, $limit, $withServicios)
    {
        //Vuelve withServicios a booleano, acepta 1, "1", true, "true", "on", y "yes" como true y cualquier otro valor devuelve falso
        $withBoolean = $withServicios->boolean();

        try {
            // Offset y limit para limitar las lineas mostradas
            if ($offset > Cita::count() || $limit > Cita::count()) {
                return response()->json(['Message' => 'Offset o limit supera el número de lineas en tabla'], 400);
            }

            // Si limit es 0 se ensena todo
            if ($limit == 0) {
                $citas =
                Cita::where('contrato_id', '=', $idContrato,)
                ->where('cliente_id', '=', $idCliente)
                ->get();
            } else {
                $citas =
                Cita::where('contrato_id', '=', $idContrato,)
                ->where('cliente_id', '=', $idCliente)
                ->offset($offset)->limit($limit)->get();
            }

            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        //$withServicios es un booleano para indicar si se quieren ver los servicios o no de cada cita
        $withBoolean ? $return = response()->json($citas->load('servicios'), 200) :
            $return = response()->json($citas, 200);

        return $return;
    }

    /**
     * Muestra las citas con sus servicios
     */
    public function showContractEmployee($idContrato, $idEmpleado, $offset, $limit, $withServicios)
    {
        //Vuelve withServicios a booleano, acepta 1, "1", true, "true", "on", y "yes" como true y cualquier otro valor devuelve falso
        $withBoolean = $withServicios->boolean();

        try {
            // Offset y limit para limitar las lineas mostradas
            if ($offset > Cita::count() || $limit > Cita::count()) {
                return response()->json(['Message' => 'Offset o limit supera el número de lineas en tabla'], 400);
            }

            // Si limit es 0 se ensena todo
            if ($limit == 0) {
                $citas =
                Cita::where('contrato_id', '=', $idContrato,)
                ->where('empleado_id', '=', $idEmpleado)
                ->get();
            } else {
                $citas =
                Cita::where('contrato_id', '=', $idContrato,)
                ->where('empleado_id', '=', $idEmpleado)
                ->offset($offset)->limit($limit)->get();
            }

            if ($citas->empty()) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'cita no encontrada'], 404);
        }

        //$withServicios es un booleano para indicar si se quieren ver los servicios o no de cada cita
        $withBoolean ? $return = response()->json($citas->load('servicios'), 200) :
            $return = response()->json($citas, 200);

        return $return;
    }

    /**
     * Muestra las citas con sus servicios
     */
    public function showClientEmployee($idCliente, $idEmpleado, $offset, $limit, $withServicios)
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
    public function getAppointment($idCita, $offset, $limit, $withServicios)
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
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $citaServicios = CitaServicio::where('cita_id', '=', $idCita)->get(); //No requiere control de errores ya que si idCita fuera erroneo habria saltaado excepcion antes, y si no hay lineas en citaServicios tampoco pasa nada porque se van a crear nuevas ahora
        $arrayServicios = [];

        $validatedData = $request->validate([
            'contrato_id' => 'sometimes|integer',
            'cliente_id' => 'sometimes|integer',
            'empleado_id' => 'sometimes|integer',
            'arrayServicios' => 'sometimes|array',
            'fecha' => 'sometimes|date_format:Y-m-d', //Formato Y-m-d
            'estado' => 'sometimes|in:pendiente,cancelado,completado',
            'numero_de_atenciones' => 'sometimes|integer|max:50', //Podemos corregir datos de una cita sin haber hecho una atencion
        ], [
            'contrato_id.integer' => 'El id de contrato debe ser un numero entero',
            'cliente_id.integer' => 'El id de cliente debe ser un numero entero',
            'empleado_id.integer' => 'El id de empleado debe ser un numero entero',

            'arrayServicios.array' => 'Los servicios deben incluirse en un formato de array []',
            'fecha.date_format' => 'La fecha debe incluirse con el formato yyy-mm-dd',
            'estado.in' => 'El estado de la cita debe ser pendiente, cancelado o completado',
            'numero_de_atenciones.integer' => 'El numero de atenciones debe ser un numero entero',
            'numero_de_atenciones.max' => 'El maximo numero de atenciones es 50'
        ]);

        // Si esta vacio usa ya las lineas de citaServicios ya creadas, sino las borra y crea nuevas
        if (isset($validatedData['arrayServicios'])) {
            // Comprobamos si cada servicio existe
            foreach ($validatedData['arrayServicios'] as $idServicio) {
                if (!Servicio::find($idServicio)) { 
                    return response()->json(['message' => "El servicio con id $idServicio no existe"], 404);
                }
            }

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
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['message' => 'Cita eliminada correctamente'], 200);
    }
}
