<?php
namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Models\Company as CompanyModel;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class TargetMarket
 * @package App\Models
 *
 * @property $company_id
 * @property $target_market_id
 *
 */
class TargetMarket extends Pivot
{
    protected $table = 'company_target_market';

}
