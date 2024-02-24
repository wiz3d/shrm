<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Models\Company as CompanyModel;

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
class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_tag');
    }

    public function upsertTag($name)
    {
        $name = trim($name);
        $tag = $this->where('name', $name)->first();
        if (!$tag) {
            $tag = $this->create([
                'name' => $name,
            ]);
        }
        return $tag->id;
    }
}
