<?php
namespace web\directory\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Personne extends \Illuminate\Database\Eloquent\Model
{

    use HasUuids;

    /**
     * déclarations des attributs
     */
    protected $table = 'personne';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function numero() {
        return $this->hasMany('web\directory\core\domain\entities\Numero', 'id_perso');
    }

    public function departement() {
        return $this->belongsToMany('web\directory\api\core\domain\entities\Departement',
                                    'perso2dept',
                                    'id_perso',
                                    'id_dept');
    }
    
    public function fonction() {
        return $this->belongsToMany('web\directory\api\core\domain\entities\Fonction',
                                    'perso2fonction',
                                    'id_perso',
                                    'id_fonction');
    } 

}