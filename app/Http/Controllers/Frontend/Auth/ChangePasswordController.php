<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Http\Requests\Frontend\User\ChangePasswordRequest;

/**
 * Class ChangePasswordController.
 */
class ChangePasswordController extends Controller
{
    /**
   * @var UserRepository
   */
  protected $user;

  /**
   * ChangePasswordController constructor.
   *
   * @param UserRepository $user
   */
  public function __construct(UserRepository $user)
  {
      $this->user = $user;
  }

  /**
   * @param ChangePasswordRequest $request
   *
   * @return mixed
   */
  public function changePassword(ChangePasswordRequest $request)
  {
      $this->user->changePassword($request->all());

      if(access()->user()->user_type == 2) {
        return redirect()->route('frontend.user.sitter.account')->withFlashSuccess(trans('strings.frontend.user.password_updated'));
      } else if(access()->user()->user_type == 1) {
        return redirect()->route('frontend.user.parent.account')->withFlashSuccess(trans('strings.frontend.user.password_updated'));
      } else {
        return redirect()->route('frontend.user.account')->withFlashSuccess(trans('strings.frontend.user.password_updated'));
      }

  }
}
