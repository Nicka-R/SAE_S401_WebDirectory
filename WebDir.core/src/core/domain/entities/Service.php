<?php
namespace web\directory\core\domain\entities;

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
        return $this->belongsTo('gift\appli\core\domain\entities\Fonction', 'id');
    } 

}