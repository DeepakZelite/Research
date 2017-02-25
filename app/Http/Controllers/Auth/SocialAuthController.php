<?php

namespace Vanguard\Http\Controllers\Auth;

use Authy;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\RolesController;
use Vanguard\Http\Requests\Auth\Social\LoginRequest;
use Vanguard\Http\Requests\Auth\Social\SaveEmailRequest;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;
use Auth;
use Session;
use Socialite;
use Laravel\Socialite\Contracts\User as SocialUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SocialAuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var RoleRepository
     */
    private $roles;

    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->middleware('guest');

        $this->users = $users;
        $this->roles = $roles;
    }

    /**
     * Redirect user to specified provider in order to complete the authentication process.
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        if (strtolower($provider) == 'facebook') {
            return Socialite::driver('facebook')->with(['auth_type' => 'rerequest'])->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle response authentication provider.
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        $socialUser = $this->getUserFromProvider($provider);

        $user = $this->users->findBySocialId($provider, $socialUser->getId());

        if (! $user) {
            if (! settings('reg_enabled')) {
                return redirect('login')->withErrors(trans('app.only_users_with_account_can_login'));
            }

            // Only allow missing email from Twitter provider
            if (! $socialUser->getEmail()) {
                return strtolower($provider) == 'twitter'
                    ? $this->handleMissingEmail($socialUser)
                    : redirect('login')->withErrors(trans('app.you_have_to_provide_email'));
            }

            $user = $this->createOrAssociateAccountForUser($socialUser, $provider);
        }

        return $this->loginAndRedirect($user);
    }

    /**
     * Display form where users authenticated for the first time via
     * Twitter can provide their emails address.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTwitterEmail()
    {
        $account = $this->getSocialAccountFromSession();

        return view('auth.social.twitter-email', compact('account'));
    }

    /**
     * Save provided email address and log the user in.
     *
     * @param SaveEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTwitterEmail(SaveEmailRequest $request)
    {
        $account = $this->getSocialAccountFromSession();

        $account->email = $request->get('email');

        $user = $this->createOrAssociateAccountForUser($account, 'twitter');

        return $this->loginAndRedirect($user);
    }

    /**
     * Get user from authentication provider.
     *
     * @param $provider
     * @return SocialUser
     */
    private function getUserFromProvider($provider)
    {
        return Socialite::driver($provider)->user();
    }

    /**
     * Create account for user authenticated via social network.
     * If user with the same email address retrieved from social network
     * exists in our database, just associate it with provided social account.
     *
     * @param SocialUser $socialUser
     * @param $provider
     * @return \Vanguard\User
     */
    private function createOrAssociateAccountForUser(SocialUser $socialUser, $provider)
    {
        $user = $this->users->findByEmail($socialUser->getEmail());

        if (! $user) {

            // User with email retrieved from social auth provider does not
            // exist in our database. That means that we have to create new user here
            list($firstName, $lastName) = $this->parseUserFullName($socialUser);

            $user = $this->users->create([
                'email' => $socialUser->getEmail(),
                'password' => str_random(10),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'status' => UserStatus::ACTIVE,
                'avatar' => $socialUser->getAvatar()
            ]);

            $this->users->updateSocialNetworks($user->id, []);

            $role = $this->roles->findByName('User');
            $this->users->setRole($user->id, $role->id);
        }

        // Associate social account with user account inside our application
        $this->users->associateSocialAccountForUser($user->id, $provider, $socialUser);

        return $user;
    }

    /**
     * Parse User's name from his social network account.
     *
     * @param SocialUser $user
     * @return array
     */
    private function parseUserFullName(SocialUser $user)
    {
        $name = $user->getName();

        if (strpos($name, " ") !== FALSE) {
            return explode(" ", $name, 2);
        }

        return [$name, ''];
    }

    /**
     * Redirect user to page where he can provide an email,
     * since email is not provided inside oAuth response.
     *
     * @param $socialUser
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleMissingEmail($socialUser)
    {
        Session::set('social.user', $socialUser);

        return redirect()->to('auth/twitter/email');
    }

    /**
     * Log provided user in and redirect him to intended page.
     *
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginAndRedirect($user)
    {
        if (settings('2fa.enabled') && Authy::isEnabled($user)) {
            session()->put('auth.2fa.id', $user->id);
            return redirect()->route('auth.token');
        }

        Auth::login($user);

        return redirect()->intended('/');
    }

    /**
     * Get social account from session or display 404
     * page if someone is trying to access this page directly.
     *
     * @return mixed
     */
    private function getSocialAccountFromSession()
    {
        $account = Session::get('social.user');

        if (! $account) {
            throw new NotFoundHttpException;
        }

        return $account;
    }

}
