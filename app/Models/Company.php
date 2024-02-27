<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag as TagModel;
use App\Models\Subcategory as SubcategoryModel;
use App\Models\TargetMarket as TargetMarket;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class Company
 * @package App\Models
 *
 * @property $id
 *
 * @property $category_id
 * @property $name
 * @property $web_site
 * @property $logo
 * @property $description
 *
 * @property $created_at
 * @property $updated_at
 *
 */
class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = ['category_id', 'name', 'web_site', 'logo', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategories()
    {
        return $this->belongsToMany(SubcategoryModel::class, 'company_subcategory');
    }

    public function tags()
    {
        return $this->belongsToMany(TagModel::class, 'company_tag');
    }

    public function targetMarkets()
    {
        return $this->belongsToMany(TargetMarket::class, 'company_target_market');
    }

    protected function images(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                return $value ? json_decode($value, true) : [];
            }
        );
    }
}
