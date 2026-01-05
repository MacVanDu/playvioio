<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'name'=>$data->name,
                    'slug'=>$data->slug,
                    'url_thumb'=>$data->linkImgThumb(),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
