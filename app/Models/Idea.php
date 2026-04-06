<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Idea extends Model
{
    use HasFactory;

     //esto sirve para proteger la bbdd solo mete los datos que estan aqui incluidos
    protected $fillable = ['user_id','title','description', 'likes', 'dislikes']; 
    
    //para poder hacer cambios en columnas a la hora de mostrarlas en la web no en la bbdd
    protected $casts = ['created_at'=> 'datetime'];

    //creamos las relaciones
    public function user(): BelongsTo{

         return $this->belongsTo(User::class);
    }

    //creamos las relaciones
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


   public function scopeMyIdeas(Builder $query, $filter): void // no devuelve ningun valor
    {
        if (!empty($filter) && $filter == 'mis-ideas') {
            $query->where('user_id', auth()->id());
        }
    }


    public function scopeTheBest(Builder $query, $filter) : void
    {
        if(!empty($filter) == 'las-mejores'){
            $query->orderBy('likes', 'desc');
        }
        
    }

    public function usersDisliked(): BelongsToMany
        {
            return $this->belongsToMany(User::class, 'idea_user_dislike');
        }


}

  

 