<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    } #|> constructor

    public function getHome(): JsonResponse
    {
        return $this->userRepositoryInterface->getHome();
    } #|> getHome

    public function configCount(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->configCount($request);
    } #|> config count actions

    public function addTube(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addTube($request);
    } #|> add tubes

    public function addMessage(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addMessage($request);
    } #|> add message

    public function notification(): JsonResponse
    {
        return $this->userRepositoryInterface->notification();
    } #|> notification

    public function mySubscribe(): JsonResponse
    {
        return $this->userRepositoryInterface->mySubscribe();
    } #|> my subscribe

    public function myViews(): JsonResponse
    {
        return $this->userRepositoryInterface->myViews();
    } #|> my views

    public function myProfile(): JsonResponse
    {
        return $this->userRepositoryInterface->myProfile();
    } #|> my profile

    public function addChannel(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addChannel($request);
    } #|> my views

    public function getPageCoinsOrMsg(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->getPageCoinsOrMsg($request);
    } #|> my views

    public function getVipList(): JsonResponse
    {
        return $this->userRepositoryInterface->getVipList();
    } #|> get Vip List

    public function getLinkInvite(): JsonResponse
    {
        return $this->userRepositoryInterface->getLinkInvite();
    } #|> get Link Invite

    public function addLinkPoints(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->AddLinkPoints($request);
    } #|> get Link Invite

    public function addPointSpin(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addPointSpin($request);
    } #|> addPointSpin

    public function checkPointSpin(): JsonResponse
    {
        return $this->userRepositoryInterface->checkPointSpin();
    } #|> addPointSpin

    public function addPointCopun(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addPointCopun($request);
    } #|> addPointCopun

    public function getTubeRandom(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->getTubeRandom($request);
    }

    public function getTubeViewAndSub(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->getTubeViewAndSub($request);
    } #|> get tube random

    public function myMessages(): JsonResponse
    {
        return $this->userRepositoryInterface->myMessages();
    } #|> user messages
    public function myDownloads(): JsonResponse
    {
        return $this->userRepositoryInterface->myDownloads();
    } #|> user downloads

    public function getMessages(): JsonResponse
    {
        return $this->userRepositoryInterface->getMessages();
    } #|> get messages

    public function userViewTube(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->userViewTube($request);
    } #|> userViewTube

    public function checkUser(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->checkUser($request);
    } #|> check user
    public function checkDevice(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->checkDevice($request);
    } #|> check user

    public function withdraw(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->withdraw($request);
    } #|> withdraw user

    public function rewardBoxes(): JsonResponse
    {
        return $this->userRepositoryInterface->rewardBoxes();
    } #|> rewardBoxes
    public function openDailyBox(): JsonResponse
    {
        return $this->userRepositoryInterface->openDailyBox();
    } #|> openDailyBox
    public function addLuckyBoxPoints(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addLuckyBoxPoints($request);
    } #|> addLucky
 public function openAdsWithPoints(): JsonResponse
    {
        return $this->userRepositoryInterface->openAdsWithPoints();
    } #|> openAds
    public function collectAdsWithPoints(): JsonResponse
    {
        return $this->userRepositoryInterface->collectAdsWithPoints();
    } #|> collect Ads with Points

}
###############|> Made By https://github.com/eldapour (eldapour) 🚀
