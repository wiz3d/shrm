<?php

namespace App\Helpers\Portal;

use Illuminate\Support\Facades\Request;
use App\Models\Company as CompanyModel;
use App\Models\Tag as TagModel;
use App\Models\TargetMarket as TargetMarketModel;
use App\Models\Category as CategoryModel;
use App\Models\Subcategory as Subcategoryodel;

class CompanyHelper
{
    const DEFAULT_PERPAGE = 24;

    public function getBuilder(array $filters = [], int $companyId = null)
    {
        $builder = CompanyModel::with(['tags', 'targetMarkets', 'subcategories']);

        ## in case if is being getting one category data by id
        if ($companyId) {
            $builder->whereId($companyId);
        }

        ## filtering
        if ($filters) {
            #todo implements filtering if need
        }

        ## add meta data sorting per page
        $perPage = !empty($filters['per_page']) ? $filters['per_page'] : self::DEFAULT_PERPAGE;

        ## sort page
        $page = !empty($filters['page']) ? $filters['page'] : 1;

        return $builder->paginate($perPage, ['*'], 'page', $page);
    }
}
