<?php
namespace web\directory\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Departement extends \Illuminate\Database\Eloquent\Model
{

    use HasUuids;

    /**
     * déclarations des attributs
     */
    protected $table = 'departement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function personne() {
        return $this->belongsToMany('web\directory\core\domain\entities\Personne',
                                    'perso2dept',
                                    'id_dept',
                                    'id_perso');
    }
}