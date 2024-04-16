<?php

namespace App\Http\Controllers\api;

use App\ExternalServices\GiphyExternalService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GifRequests\SaveGifToFavoritesRequest;
use App\Http\Requests\GifRequests\SearchGifRequest;
use App\Models\Gif;
use Illuminate\Http\JsonResponse;

class GifController extends Controller
{
    public function search(SearchGifRequest $request): JsonResponse
    {
        $query = $request->input('query');
        $limit = $request->limit;
        $offset = $request->offset;

        $giphy = new GiphyExternalService();
        $response = $giphy->search($query, $limit, $offset)->data;
        return $this->apiResponse('List of gifs',200,$response);
    }

    public function show($gif_id): JsonResponse
    {
        $giphy = new GiphyExternalService();
        $response = $giphy->getById($gif_id)->data;

        return $this->apiResponse("Show gif id: $gif_id",200,$response);
    }

    public function saveGifToFavorites(SaveGifToFavoritesRequest $request): JsonResponse
    {
        $gif = new Gif();
        $gif->gif_id = $request->gif_id;
        $gif->alias = $request->alias;
        $gif->user_id = $request->user_id;
        $gif->save();

        return $this->apiResponse('Gif saved to favorites',201, $gif);
    }
}
