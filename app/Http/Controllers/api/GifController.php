<?php

namespace App\Http\Controllers\api;

use App\Exceptions\GifApiException;
use App\ExternalServices\GiphyExternalService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GifRequests\SaveGifToFavoritesRequest;
use App\Http\Requests\GifRequests\SearchGifRequest;
use App\Models\Gif;
use Illuminate\Http\JsonResponse;

class GifController extends Controller
{
    const DEFAULT_SEARCH_LIMIT = 5;
    const DEFAULT_SEARCH_OFFSET = 0;

    public function search(SearchGifRequest $request): JsonResponse
    {
        try {
            $query = $request->input('query');
            $limit = $request->limit ?? self::DEFAULT_SEARCH_LIMIT;
            $offset = $request->offset ?? self::DEFAULT_SEARCH_OFFSET;

            $giphy = new GiphyExternalService();
            $response = $giphy->search($query, $limit, $offset)->data;
            return $this->apiResponse('List of gifs', 200, $response);

        } catch (GifApiException $e) {
            return $this->apiResponse($e->getMsg(), $e->getCode(), $e->getData());
        }
    }

    public function show($gif_id): JsonResponse
    {
        try {
            $giphy = new GiphyExternalService();
            $response = $giphy->getById($gif_id);
            return $this->apiResponse("Show gif id: $gif_id", 200, $response->data);

        } catch (GifApiException $e) {
            return $this->apiResponse($e->getMsg(), $e->getCode(), $e->getData());
        }
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
