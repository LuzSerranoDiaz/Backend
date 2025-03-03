<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    /**
     * Get the usuario associated with the Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class);
    }
    /**
     * Get all of the citas for the Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
    /**
     * Get all of the contratos for the Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class);
    }
}
 