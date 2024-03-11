<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Tag\TagInterface;
use Mockery\Exception;

class TagController extends Controller
{
    private $tagRepo;

    public function __construct(TagInterface $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function postsByTag($id)
    {
        try {
            $tag = $this->tagRepo->getById($id);
            if (!$tag) {
                abort(404);
            }
            $postsByTag = $tag->posts->paginate(config('constants.DATA_PER_PAGE'));
            return view('site.tags.posts', compact('tag', 'postsByTag'));
        } catch (Exception $exception) {
            abort(404);
        }
    }
}
