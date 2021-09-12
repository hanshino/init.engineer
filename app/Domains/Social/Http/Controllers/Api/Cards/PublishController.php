<?php

namespace App\Domains\Social\Http\Controllers\Api\Cards;

use App\Domains\Social\Http\Requests\Api\Publish\PublishArticleRequest;
use App\Domains\Social\Http\Requests\Api\Publish\PublishPictureRequest;
use App\Domains\Social\Http\Resources\CardResource;
use App\Domains\Social\Models\Ads;
use App\Domains\Social\Services\AdsService;
use App\Domains\Social\Services\CardsService;
use App\Domains\Social\Services\Image\ImagesGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Container\Container;

/**
 * Class PublishController.
 */
class PublishController extends Controller
{
    /**
     * @var CardsService
     */
    protected $service;

    /**
     * PublishController constructor.
     *
     * @param CardsService $service
     */
    public function __construct(CardsService $service)
    {
        $this->service = $service;
    }

    /**
     * @param PublishArticleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function article(PublishArticleRequest $request)
    {
        /**
         * 整理圖片投稿資訊
         */
        $data = $request->validated();
        $data['model_id'] = $request->user()->id;

        /**
         * 透過 ImagesGenerator 去產生圖片
         */
        $container = Container::getInstance();
        $generator = $container->make(ImagesGenerator::class);
        $picture = $generator->content($data['content'])
            ->theme($data['config']['theme'])
            ->font($data['config']['font'])
            ->build();

        /**
         * 處理投稿資訊的圖片資訊
         */
        $data['picture'] = array(
            'local' => $picture['picture'],
            'storage' => null,
            'imgur' => null,
        );

        /**
         * 處理投稿資訊的設定資訊
         */
        $data['config'] = array(
            'type' => 'article',
            'theme' => $data['config']['theme'],
            'font' => $data['config']['font'],
            'ads' => $picture['ads'],
        );

        /**
         * 將圖片投稿寫入
         */
        $card = $this->service->store($data);

        if ($picture['ads']['result']) {
            $adsService = $container->make(AdsService::class);
            $adsService->deploy(Ads::find($picture['ads']['data']['id']), $card);
        }

        return new CardResource($card);
    }

    /**
     * @param PublishPictureRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function picture(PublishPictureRequest $request)
    {
        /**
         * 將圖片儲存到 Local 當中
         */
        $path = $request->file('picture')->store('public/cards/custom');
        $path = str_replace('public', 'storage', $path);

        /**
         * 整理圖片投稿資訊
         */
        $data = $request->validated();
        $data['model_id'] = $request->user()->id;
        $data['picture'] = array(
            'local' => $path,
            'storage' => null,
            'imgur' => null,
        );
        $data['config'] = array(
            'type' => 'picture',
        );

        /**
         * 將圖片投稿寫入
         */
        $card = $this->service->store($data);

        return new CardResource($card);
    }
}
