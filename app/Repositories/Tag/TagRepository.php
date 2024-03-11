<?php

namespace App\Repositories\Tag;

use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;

class TagRepository extends Controller implements TagInterface
{
    private Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function get($request)
    {
        return $this->tag::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->tag::find($id);
    }

    public function store($request)
    {
        $this->tag::insertGetId($request);
    }

    public function update($request, $id)
    {
        $tag = $this->tag::find($id);
        $tag->fill($request);
        $tag->save();
    }

    public function destroy($id)
    {
        $this->tag::find($id)->delete();
    }

    public function savePostTag($params)
    {
        $tags = explode(',', $params['tags']);
        $tags_id = [];
        foreach ($tags as $tag) {
            $inserted_tag = $this->tag::firstOrCreate([
                'name' => strip_tags(html_entity_decode($tag)),
            ]);
            $tags_id[] = $inserted_tag->id;
        }
        $post = Post::find($params['id']);
        foreach ($tags_id as $id) {
            $post->tags()->attach($id);
        }
    }
}
