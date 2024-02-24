<?php

namespace App\Helpers\Portal;

use App\Models\Subcategory as SubcategoryModel;
use Illuminate\Support\Facades\Request;

class SubcategoryHelper
{
    const DEFAULT_PERPAGE = 24;

    public function getBuilder(array $filters = [], int $categoryId = null)
    {
        $builder = SubcategoryModel::query();

        ## in case if is being getting one category data by id
        if ($categoryId) {
            $builder->whereId($categoryId);
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
