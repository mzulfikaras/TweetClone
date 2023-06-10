<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Repositories\TweetRepository;

class TweetController extends Controller
{
    protected $tweetRepository;

    public function __construct(TweetRepository $tweetRepository)
    {
        $this->tweetRepository = $tweetRepository;
    }

    public function index()
    {
        try {
            $sort_by = request()->sort_by ?? "created_at";
            $sort_by_order = request()->sort_by_order ?? "DESC";
            $per_page = request()->per_page ?? 10;

            $data = $this->tweetRepository->indexTweet($sort_by, $sort_by_order, $per_page);

            return response()->json([
                'success'   => true,
                'message'   => 'Successfully to get data',
                'data'      => $data
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => $th->getMessage(),
                'data'      => null,
            ], 500);
        }

    }

    public function store(TweetRequest $request)
    {
        try {

            $data = $this->tweetRepository->storeTweet($request->all());

            return response()->json([
                'success'   => true,
                'message'   => 'Successfully to save data',
                'data'      => $data
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => $th->getMessage(),
                'data'      => null,
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tweetRepository->deleteTweet($id);

            return response()->json([
                'success'   => true,
                'message'   => 'Successfully to delete data',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => $th->getMessage(),
            ], 500);
        }
    }
}
