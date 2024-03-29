<?php

namespace App\Helpers\Portal;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Models\Company as CompanyModel;
use App\Models\Tag as TagModel;
use App\Models\TargetMarket as TargetMarketModel;
use App\Models\Category as CategoryModel;
use App\Models\Subcategory as Subcategoryodel;

class CompanyHelper
{
    const DEFAULT_PERPAGE = 24;

    public function getBuilder(array $filters = [], int $companyId = null, array $paginations = [])
    {
        $builder = CompanyModel::with(['tags', 'targetMarkets', 'subcategories']);

        ## in case if is being getting one category data by id
        if ($companyId) {
            $builder->whereId($companyId);
        }

        ## filtering
        if (!empty($filters['category'])) {
            $categoryIds = explode(',', $filters['category']);
            $builder->whereIn('category_id', $categoryIds);
        }

        if (!empty($filters['subcategory'])) {
            $builder->whereHas('subcategories', function ($query) use ($filters) {
                $query->whereIn('subcategory_id', explode(',', $filters['subcategory']));
            });
        }

        if (!empty($filters['tags'])) {
            $tags = explode(',', $filters['tags']);
            $builder->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', $tags);
            });
        }

        if (!empty($filters['company_name'])) {
            $companyName = '%' . trim($filters['company_name']) . '%';
            $builder->where('name', 'LIKE', $companyName);
        }

        ## add meta data sorting per page
        $perPage = !empty($paginations['per_page']) ? $paginations['per_page'] : self::DEFAULT_PERPAGE;

        ## sort page
        $page = !empty($paginations['page']) ? $paginations['page'] : 1;

        return $builder->paginate($perPage, ['*'], 'page', $page);
    }
}
