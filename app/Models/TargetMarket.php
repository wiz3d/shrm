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
class TargetMarket extends Model
{
    protected $table = 'target_markets';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_target_market');
    }

    public function upsertTargetMarket($name)
    {
        $name = trim($name);
        $targetMarket = $this->where('name', $name)->first();
        if (!$targetMarket) {
            $targetMarket = $this->create([
                'name' => $name,
            ]);
        }
        return $targetMarket->id;
    }
}
