<?php
namespace web\directory\api\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Numero extends \Illuminate\Database\Eloquent\Model
{

    use HasUuids;

    /**
     * déclarations des attributs
     */
    protected $table = 'numero';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function personne() {
        return $this->belongsTo('web\directory\api\core\domain\entities\Personne', 'id');
    } 

}