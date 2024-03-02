<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\YoutubeKey;
use App\Traits\FirebaseNotification;
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

    public function getActiveKey(): JsonResponse
    {
        try {
            $key = YoutubeKey::query()
                ->select('key', 'limit')
                ->where('limit', '<', '9900')
                ->latest()->first();

            if ($key) {
                return self::returnResponseDataApi($key, 'تم الحصول علي البيانات بنجاح', 200);
            } else {
                return self::returnResponseDataApi(null, 'لا يوجد بيانات حاليا', 422);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getActiveKey

    public function updateActiveKey(Request $request)
    {
        try {
            $key = $request->key;
            $youtubeKey = YoutubeKey::query()
                ->where('key', $key)->first();
            $youtubeKey->limit += 1;
            $youtubeKey->save();

            if ($youtubeKey) {

                $youtubeKeyData = YoutubeKey::query()
                    ->select('key', 'limit')
                    ->where('key', $key)
                    ->first();

                return self::returnResponseDataApi($youtubeKeyData, 'تم تحديث البيانات بنجاح', 200);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // end function updateActiveKey
}
