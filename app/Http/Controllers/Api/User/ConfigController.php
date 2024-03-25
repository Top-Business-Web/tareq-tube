<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\YoutubeKey;
use App\Models\YoutubeKeyEach;
use App\Traits\FirebaseNotification;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    use FirebaseNotification;

    protected UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    } // constructor

    public function getInterests(): JsonResponse
    {
        return $this->userRepositoryInterface->getInterests();
    } // getInterests

    public function getCities(): JsonResponse
    {
        return $this->userRepositoryInterface->getCities();
    } // getCities

    public function setting(): JsonResponse
    {
        return $this->userRepositoryInterface->setting();
    } // getCities

    public function testFcm(Request $request)
    {
        $data = [
            'title' => $request->title,
            'body' => $request->body,
        ];
        return $this->sendFirebaseNotification($data, null);
    } // get FirebaseNotification

    public function getActiveKey()
    {
        try {
            $key = YoutubeKey::query()
                ->where('limit', '<', '9900')
                ->latest()->first();


            if ($key) {
                $key->limit += 1;
                $newEach = new YoutubeKeyEach();
                $newEach->key_id = $key->id;
                $key->save();
                $newEach->save();
                return self::returnResponseDataApi($key, 'تم الحصول علي البيانات بنجاح', 200);
            } else {
                return self::returnResponseDataApi(null, 'لا يوجد بيانات حاليا', 422);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getActiveKey
}
