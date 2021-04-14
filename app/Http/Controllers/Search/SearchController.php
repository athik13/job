<?php


namespace App\Http\Controllers\Search;

use App\Helpers\Search\PostQueries;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SearchController extends BaseController
{
    public $isIndexSearch = true;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        view()->share('isIndexSearch', $this->isIndexSearch);

        // Search
        $data = (new PostQueries($this->preSearch))->fetch();

        // Get Titles
        $title = $this->getTitle();
        $this->getBreadcrumb();
        $this->getHtmlTitle();

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);

        return appView('search.results', $data);
    }
}
