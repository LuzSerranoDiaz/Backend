<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
   /** @use HasFactory<\Database\Factories\UserFactory> */
   use HasFactory, Notifiable, HasApiTokens;

   /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'contrasena',
        'tlf',
        'direccion',
        'municipio',
        'provincia',
    ];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
   protected $hidden = [
       'contrasena',
   ];

   /**
    * Get the empleado associated with the Usuario
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function empleado(): HasOne
   {
       return $this->hasOne(Empleado::class);
   }

   /**
    * Get the cliente associated with the Usuario
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function cliente(): HasOne
   {
       return $this->hasOne(Cliente::class);
   }

   /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
   protected function casts(): array
   {
        return [
           'email_verified_at' => 'datetime',
           'password' => 'hashed',
        ];
   }
}
