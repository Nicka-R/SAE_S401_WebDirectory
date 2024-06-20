<?php
namespace web\directory\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Administrator extends \Illuminate\Database\Eloquent\Model
{

    use HasUuids;

    const ADMIN = 1 ;
    const SUPER_ADMIN = 100;

    /**
     * déclarations des attributs
     */
    protected $table = 'administrator';
    protected $primaryKey = 'id';
    public $timestamps = false;

}