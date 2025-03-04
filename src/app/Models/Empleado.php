<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Empleado extends Model
{
    use HasFactory, Notifiable;
    /**
     * Get the user associated with the Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(Usuario::class);
    }

        /**
     * The empleados that belong to the Especialidad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function especialidades(): BelongsToMany
    {
        return $this->belongsToMany(Especialidad::class, 'empleado_especialidads', 'empleado_id', 'especialidad_id');
    }
}
