<?php

namespace App\Http\Services\Advert;

use App\Events\AdvertPriceChangedEvent;
use App\Http\Requests\Adverts\Advert\AdvertAttributesRequest;
use App\Http\Requests\Adverts\CreateAdvertRequest;
use App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;

class AdvertService
{
    public function create($userId, $categoryId, $regionId, CreateAdvertRequest $request)
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        /** @var Category $category */
        $category = Category::findOrFail($categoryId);
        /** @var Region $region */
        $region = $regionId ? Region::findOrFail($regionId) : null;

        return \DB::transaction(function () use ($request, $user, $category, $region) {

            /** @var Advert $advert */
            $advert = Advert::make([
                'title' => $request['title'],
                'content' => $request['content'],
                'price' => $request['price'],
                'address' => $request['address'],
                'status' => Advert::STATUS_DRAFT
            ]);

            $advert->user()->associate($user);
            $advert->category()->associate($category);
            $advert->region()->associate($region);

            $advert->saveOrFail();

            foreach ($category->allAttributes() as $attribute) {
                $value = $request['attributes'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value
                    ]);
                }
            }

            return $advert;
        });
    }

    public function edit($id, \Request $request)
    {
        $advert = $this->getAdvert($id);
        $old = $advert->price;

        $advert->update($request->only([
            'title',
            'content',
            'price',
            'address',
        ]));

        // TODO: добавить в очередь
//        if ($advert->price !== $old) {
//            event(new AdvertPriceChangedEvent($advert, $old));
//        }
    }

    public function editAttributes(int $id, AdvertAttributesRequest $request)
    {
        $advert = $this->getAdvert($id);

        \DB::transaction(function () use ($advert, $request) {
           $advert->values()->delete();

           foreach ($advert->category->allAttributes() as $attribute) {
               $value = $request['attributes'][$attribute->id] ?? null;
               if (!empty($value)) {
                   $advert->values()->create([
                       'attribute_id' => $attribute->id,
                       'value' => $value
                   ]);
               }
           }
//           Обновляет поле updated_at
            $advert->update();
        });
    }

    public function addPhotos(int $id, PhotosRequest $request)
    {
        $advert = $this->getAdvert($id);

        \DB::transaction(function () use ($advert, $request) {
            foreach ($request['files'] as $file) {
                $advert->photos()->create([
                    'file' => $file->store('adverts')
                ]);
            }
            $advert->update();
        });
    }

    public function sendToModeration(int $id): void
    {
        $advert = $this->getAdvert($id);
        $advert->sendToModeration();
    }

    public function moderate(int $id): void
    {
        $advert = $this->getAdvert($id);
        $advert->moderate(Carbon::now());
    }

    public function reject(int $id, RejectRequest $request)
    {
        $advert = $this->getAdvert($id);
        $advert->reject($request['reason']);
    }

    public function expire(Advert $advert): void
    {
        $advert->expirre();
    }

    public function remove(int $id): void
    {
        $advert = $this->getAdvert($id);
        $advert->photos()->delete();
        $advert->delete();
    }

    private function getAdvert(int $id): Advert
    {
        return Advert::findOrFail($id);
    }


}
