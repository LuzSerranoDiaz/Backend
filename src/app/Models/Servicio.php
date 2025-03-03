<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
 /**
  * The citas that belong to the Servicio
  *
  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
  */
 public function citas(): BelongsToMany
 {
     return $this->belongsToMany(Cita::class, 'citas_servicios', 'servicio_id', 'cita_id');
 }
}
