<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;
class CompanyCollection extends ResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        try {
            return [
                'data' => $this->collection->transform(function ($company) {
                    $company->logo = $company->logo ? asset("images/logos/{$company->logo}") : null;
                    if (!empty($company->images)) {
                        $images = is_string($company->images) ? json_decode($company->images, true) : $company->images;
                        $company->images = array_map(function ($imageName) {
                            return asset("images/companies/{$imageName}");
                        }, $images);
                    } else {
                        $company->images = [];
                    }
                    return $company;
                }),
            ];
        } catch (\Exception $e) {
            Log::error($e);
            return ["Exception: category data(s) error:{$e->getMessage()}"];
        }
    }

}
