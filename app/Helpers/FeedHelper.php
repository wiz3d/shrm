<?php

namespace App\Helpers;

use App\Contracts\ConverterInterface;
use Illuminate\Support\Facades\Log;
use App\Models\Category as CategoryModel;
use App\Models\Company;
use App\Models\Subcategory;
use App\Models\Tag;
use App\Models\TargetMarket;
use App\Models\Subcategory as SubcategoryModel;

class FeedHelper
{
    const AVAILABLE_FILE_TYPES = ['csv'];

    const INDEX_CATEGORIES = 9;
    const INDEX_SUBCATEGORIES = 10;

    protected function getContentByFileName(string $fileName)
    {
        if (!file_exists($fileName) || !is_readable($fileName)) {
            throw new \Exception("The File '$fileName' has not been found");
        }
        $content = file_get_contents($fileName);
        return $content;
    }

    protected function formaRawArrayData(array $data = [])
    {
        $result = [];
        foreach ($data as $key => $datum) {
            if ($key == 0) {
                #skip header
                continue;
            }
            if (!empty($datum[0]) && !empty($datum[1])) {
                $result[trim($datum[2])][] = [
                    'company' => $datum[0],
                    'website' => '',
                    'description' => !empty($datum[1]) ? $datum[1] : '',
                    'subcategories' => !empty($datum[3]) ? explode(',', $datum[3]) : [],
                    'logo' => !empty($datum[4]) ? $datum[4] : '',
                    'tags' => !empty($datum[5]) ? explode(',', $datum[5]) : [],
                    'target_market' => !empty($datum[6]) ? explode(',', $datum[6]) : [],
                ];
            }
        }
        return $result;
    }

    protected function getAllCategoriesFromArray(array $arrayData = [], int $index = 0)
    {
        $allCategories = [];
        foreach ($arrayData as $key => $datum) {
            if ($key == 0) {
                #skip header
                continue;
            }
            if (!empty($datum[$index])) {
                $allCategories[] = $datum[$index];
            }
        }
        return $allCategories;
    }

    public function ImportDataByFile(string $type, string $fileName)
    {
        try {
            #try get a raw file content;
            $stringData = $this->getContentByFileName($fileName);
            if ($stringData) {
                #get convertor by type
                /** @var ConverterInterface $converter */
                $converter = app(ConverterInterface::class, ['type' => $type]);
                $arrayData = $converter->convertToArray($stringData, '~');
//                return true;
                if (!empty($arrayData)) {
                    $allCategories = $this->getAllCategoriesFromArray($arrayData, self::INDEX_CATEGORIES);
                    $allSubcategories = $this->getAllCategoriesFromArray($arrayData, self::INDEX_SUBCATEGORIES);
                    $categoryModel = app()->make(CategoryModel::class);
                    foreach ($allCategories as $categoryName) {
                        $categoryModel->upsertCategory($categoryName);
                    }
                    $subcategoryModel = app()->make(SubcategoryModel::class);
                    foreach ($allSubcategories as $subcategoryName) {
                        $subcategoryModel->upsertSubcategory($subcategoryName);
                    }
                    $companies = $this->formaRawArrayData($arrayData);
                    foreach ($companies as $categoryName => $companyData) {
                        $categoryId = $categoryModel->upsertCategory($categoryName);
                        foreach ($companyData as $data) {
                            $company = Company::updateOrCreate(
                                [
                                    'name' => $data['company'],
                                    'category_id' => $categoryId
                                ],
                                [
                                    'description' => $data['description'],
                                    'web_site' => $data['website']
                                ]
                            );

                            foreach ($data['subcategories'] as $subcategory) {
                                $subcategoryModel = new SubcategoryModel();
                                $subcategoryId = $subcategoryModel->upsertSubcategory($subcategory);
                                $company->subcategories()->syncWithoutDetaching($subcategoryId);
                            }

                            foreach ($data['tags'] as $tagName) {
                                $tagModel = new Tag();
                                var_dump($tagModel);
                                $tagId = $tagModel->upsertTag($tagName);
                                var_dump("$tagId:{tagId}");
                                $company->tags()->syncWithoutDetaching($tagId);
                            }

                            foreach ($data['target_market'] as $marketName) {
                                $targetMarketModel = new TargetMarket();
                                $marketId = $targetMarketModel->upsertTargetMarket($marketName);
                                $company->targetMarkets()->syncWithoutDetaching($marketId);
                            }

                            $company->save();
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::info($e);
            throw new \Exception("error while importing data by file: {$e->getMessage()}");
        }
    }

}
