<?php
namespace web\directory\api\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Fonction extends \Illuminate\Database\Eloquent\Model
{

    use HasUuids;

    /**
     * déclarations des attributs
     */
    protected $table = 'fonction';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function personne() {
        return $this->belongsToMany('gift\appli\core\domain\entities\Personne',
                                    'perso2fonction',
                                    'id_fonction',
                                    'id_perso');
    }

    public function service() {
        return $this->hasMany('gift\appli\core\domain\entities\Service', 'id_service');
    }

}