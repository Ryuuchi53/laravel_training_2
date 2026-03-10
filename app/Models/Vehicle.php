<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'model',
        'color',
        'make',
        'year',
        'brand',
        'license_plate',
    ];

    public function setLicensePlateAttribute(string $value){
        $this->attributes['license_plate'] = strtoupper(str_replace(' ', '', trim($value)));
    }
}
