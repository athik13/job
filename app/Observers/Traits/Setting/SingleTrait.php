<?php


namespace App\Observers\Traits\Setting;

use App\Models\Post;

trait SingleTrait
{
    /**
     * Updating
     *
     * @param $setting
     * @param $original
     */
    public function singleUpdating($setting, $original)
    {
        $this->autoReviewedExistingPostsIfApprobationIsEnabled($setting);
    }

    /**
     * Auto approve all the existing posts,
     * If the Posts Approbation feature is enabled
     *
     * @param $setting
     */
    private function autoReviewedExistingPostsIfApprobationIsEnabled($setting)
    {
        // Enable Posts Approbation by User Admin (Post Review)
        if (array_key_exists('posts_review_activation', $setting->value)) {
            // If Post Approbation is enabled,
            // then set the reviewed field to "true" for all the existing Posts
            if ((int)$setting->value['posts_review_activation'] == 1) {
                Post::where(function ($query) {
                    $query->where('reviewed', '!=', 1)->orWhereNull('reviewed');
                })->update(['reviewed' => 1]);
            }
        }
    }
}
