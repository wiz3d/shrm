<?php

namespace App\Helpers\Portal;

use App\Models\Category as CategoryModel;
use App\Models\Category\Data as CategoryDataModel;
use App\Models\Category\Data\Hashtag as CategoryDataHashtagModel;
use Illuminate\Support\Facades\Request;

class CategoryHelper
{
    const DEFAULT_PERPAGE = 24;

    public function getBuilder(array $filters = [], int $categoryId = null)
    {
        $categoryBuilder = CategoryModel::query();

        ## in case if is being getting one category data by id
        if ($categoryId) {
            $categoryBuilder->whereId($categoryId);
        }

        ## filtering
        if ($filters) {
            #todo implements filtering if need
        }

        ## add meta data sorting per page
        $perPage = !empty($filters['per_page']) ? $filters['per_page'] : self::DEFAULT_PERPAGE;

        ## sort page
        $page = !empty($filters['page']) ? $filters['page'] : 1;

        return $categoryBuilder->paginate($perPage, ['*'], 'page', $page);
    }
}
