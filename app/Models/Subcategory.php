<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * Class Category
 * @package App\Models
 *
 * @property $id
 *
 * @property $name
 *
 * @property $created_at
 * @property $updated_at
 *
 */
class Subcategory extends Model
{
    protected $table = 'subcategories';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_subcategory');
    }

    public function upsertSubcategory($name)
    {
        $name = trim($name);
        $subcategory = $this->where('name', $name)->first();
        if (!$subcategory) {
            $subcategory = $this->create([
                'name' => $name,
            ]);
        }
        return $subcategory->id;
    }

}
