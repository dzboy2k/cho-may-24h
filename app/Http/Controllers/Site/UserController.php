<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\Address\AddressRepository;
use App\Repositories\Image\ImageInterface;
use App\Repositories\Post\PostInterface;
use App\Repositories\SavedPost\SavedPostRepository;
use App\Repositories\User\UserInterface;
use App\Http\Requests\EditProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $userRepo, $addressRepo, $upload_path, $root_path, $imageRepo, $postRepo, $savedPostRepo;

    public function __construct(UserInterface $userRepo, AddressRepository $addressRepo, ImageInterface $imageRepo, PostInterface $postRepo, SavedPostRepository $savedPostRepo)
    {
        $this->userRepo = $userRepo;
        $this->addressRepo = $addressRepo;
        $this->imageRepo = $imageRepo;
        $this->postRepo = $postRepo;
        $this->upload_path = config('constants.USERS_UPLOAD_DIR');
        $this->root_path = config('constants.USERS_ROOT_PATH');
        $this->savedPostRepo = $savedPostRepo;
    }

    public function showUserInfo(Request $request)
    {
        try {
            $type = $request->showType ?? config('constants.SHOW_TYPES')['SHOWING'];
            if (!in_array($type, config('constants.SHOW_TYPES'))) {
                abort(404);
            }
            $currentUser = Auth::user();
            $currentUserId = $currentUser?->id;
            $is_sold = config('constants.POST_STATUS')['SOLD'];
            if ($request->id) {
                $user = $this->userRepo->findByReferralCode($request->id);
            } else {
                if (!Auth::check()) {
                    return redirect()->route('auth.login.form');
                }
                $user = $currentUser;
            }
            if (!$user) {
                abort(404);
                return;
            }
            $isFollowing = $this->userRepo->isFollowing($user->id, $currentUserId);
            $user->amountFollowers = $this->userRepo->getListUserIdFollowing($user->id)->count();
            $user->amountFollowed = $this->userRepo->getListUserIdFollowed($user->id)->count();
            $posts = $this->postRepo->getPostByUserWithShowType($user->id, $type)?->appends(['showType' => $type]);
            $isAuthorized = $currentUserId == $user->id;
            return view('site.user.user_info', compact('user', 'posts', 'isFollowing', 'isAuthorized', 'type', 'is_sold'));
        } catch (\Exception $exception) {
            abort(404);
        }
    }

    public function toggleFollow($id)
    {
        try {
            $currentUserId = Auth::id();

            $isFollowing = $this->userRepo->isFollowing($id, $currentUserId);

            if (!$isFollowing) {
                $this->userRepo->followUser($id, $currentUserId);
            } else {
                $this->userRepo->unfollowUser($id, $currentUserId);
            }
            return redirect()->back();
        } catch (\Exception $exception) {
            abort(404);
        }
    }

    public function showEditProfileForm()
    {
        $user = Auth::user();
        return view('site.user.edit_profile', compact('user'));
    }

    public function editProfile(EditProfileRequest $request)
    {
        try {
            $user = Auth::user();
            $avt_path = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = now()->unix() . '-' . Str::slug($request->name, '-') . '.' . $avatar->extension();
                if ($avatar->storeAs($this->upload_path, $filename)) {
                    $avt_path = $this->root_path . '/' . $filename;
                }
            }
            $dataUser = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'introduce' => $request->introduce,
                'avatar' => $avt_path ?? $user->avatar ?? config('constants.DEFAULT_AVT_PATH')
            ];
            $this->userRepo->update($user, $dataUser);

            $dataIdCards = [
                'issue' => $request->issue,
                'address' => $request->address,
                'identify_code' => $request->identify_code,
            ];
            if ($dataIdCards['issue'] && $dataIdCards['address'] && $dataIdCards['identify_code']) {
                $this->userRepo->saveIdCards($user, $dataIdCards);
            }

            $addressData = [
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'street_address' => $request->street_address,
                'full_address' => $request->full_address,
            ];

            if ($addressData['province_id'] && $addressData['district_id'] && $addressData['ward_id']) {
                $this->addressRepo->saveAddressUser($user->id, $addressData);
            }

            return redirect()->route('user.info', ['id' => $user->referral_code])->with('message', ['content' => __('message.update_success', ['name' => __('message.profile')]), 'type' => 'success']);
        } catch (\Exception $e) {
            return back()->with('message', ['content' => __('message.update_failed', ['name' => __('message.profile')]), 'type' => 'error']);
        }
    }

    public function showChangePasswordForm()
    {
        return view('site.auth.change_password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->userRepo->changePassword($request);
    }

    public function showSavedPosts()
    {
        $userId = Auth::id();
        $savedPosts = $this->savedPostRepo->isSavedPostsByUserID($userId);

        if ($savedPosts) {
            $listSavedPosts = $this->savedPostRepo->getListSavedPostsByUserID($userId);
            return view('site.saved-posts.index', compact('listSavedPosts'));
        }
        return view('site.saved-posts.blank-saved-posts');
    }
}
