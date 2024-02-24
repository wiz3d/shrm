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
class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->hasMany(CompanyModel::class, 'category_id', 'id');
    }

    public function upsertCategory($name)
    {
        $name = trim($name);
        $category = $this->where('name', $name)->first();
        if (!$category) {
            $category = $this->create([
                'name' => $name,
            ]);
        }
        return $category->id;
    }

//    public function upsertCategoryData($categoryId, $data)
//    {
//        foreach ($data as $datum) {
//            $categoryData = CategoryData::updateOrCreate(
//                ['category_id' => $categoryId, 'name' => $datum['name']],
//                $datum
//            );
//            $this->upsertCategoryDataHashtags($categoryData->id, $datum['hashtags'] ?? '');
//        }
//    }

//    protected function upsertCategoryDataHashtags($categoryDataId, $hashtagsString)
//    {
//        $hashtags = explode('#', $hashtagsString);
//        $hashtags = array_filter($hashtags);
//        CategoryDataHashtag::where('category_data_id', $categoryDataId)->delete();
//        foreach ($hashtags as $hashtag) {
//            CategoryDataHashtag::create([
//                'category_data_id' => $categoryDataId,
//                'hashtag' => '#' . trim($hashtag)
//            ]);
//        }
//    }
}
