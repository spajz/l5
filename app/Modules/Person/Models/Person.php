<?php namespace App\Modules\Person\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;

class Person extends BaseModel
{
    protected $table = 'persons';

    protected $fillable = array(
        'first_name',
        'last_name',
        'job_title',
        'description',
        'order',
        'status'
    );

    public function rulesAll()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'job_title' => 'required|max:255',
        ];
    }

}
