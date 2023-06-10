<?php

namespace App\Repositories;

use App\Models\Tweet;
use App\Traits\ImageTrait;

class TweetRepository
{
    use ImageTrait;

    public function indexTweet($sort_by, $sort_by_order, $per_page)
    {
       $res = Tweet::orderBy($sort_by, $sort_by_order)->paginate($per_page);

       return $res;
    }

    public function storeTweet($request)
    {
        if (isset($request['image'])) {
            $image = $request['image'];

            $request['image'] = $this->uploadImage($image, "tweet");
        }

        $res = Tweet::create($request);

        return $res;
    }

    public function deleteTweet($id)
    {
        $dataId = Tweet::findOrFail($id);

        $deleteImage = $this->deleteImage($dataId->image);
        $dataId->delete();

    }
}
