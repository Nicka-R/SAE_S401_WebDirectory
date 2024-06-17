<?php
namespace web\directory\api\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Service extends \Illuminate\Database\Eloquent\Model
{

    use HasUuids;

    /**
     * déclarations des attributs
     */
    protected $table = 'service';
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    public function fonction() {
        return $this->belongsTo('web\directory\api\core\domain\entities\Fonction', 'id');
    } 

    public function service() {
        return $this->belongsToMany('web\directory\api\core\domain\entities\Personne',
                                    'perso2service',
                                    'id_service',
                                    'id_perso');
    }

}