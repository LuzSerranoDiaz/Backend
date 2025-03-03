<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Usuario extends Model
{
   /** @use HasFactory<\Database\Factories\UserFactory> */
   use HasFactory, Notifiable;

   /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
   protected $fillable = [
       'name',
       'email',
       'contrasena',
   ];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
   protected $hidden = [
       'password',
       'remember_token',
   ];

   /**
    * Get the empleado that owns the Usuario
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function empleado(): BelongsTo
   {
       return $this->belongsTo(Empleado::class);
   }

   /**
    * Get the cliente that owns the Usuario
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function cliente(): BelongsTo
   {
       return $this->belongsTo(Cliente::class);
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
