<?php

namespace Vanguard\Repositories\User;

use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Role;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;
use Laravel\Socialite\Contracts\User as SocialUser;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Log;

class EloquentUser implements UserRepository
{
    /**
     * @var UserAvatarManager
     */
    private $avatarManager;
    /**
     * @var RoleRepository
     */
    private $roles;

    public function __construct(UserAvatarManager $avatarManager, RoleRepository $roles)
    {
        $this->avatarManager = $avatarManager;
        $this->roles = $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findBySocialId($provider, $providerId)
    {
        return User::leftJoin('social_logins', 'users.id', '=', 'social_logins.user_id')
            ->select('users.*')
            ->where('social_logins.provider', $provider)
            ->where('social_logins.provider_id', $providerId)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return User::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function associateSocialAccountForUser($userId, $provider, SocialUser $user)
    {
        return DB::table('social_logins')->insert([
            'user_id' => $userId,
            'provider' => $provider,
            'provider_id' => $user->getId(),
            'avatar' => $user->getAvatar(),
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null,$vendor_code = null,$user = null)
    {
        $query = User::query();

        if ($status) {
            $query->where('users.status', $status);
        }
        if($vendor_code)
        {
        	$query->where('vendors.vendor_code',$vendor_code);
        }

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('users.username', "like", "%{$search}%");
                $q->orWhere('vendors.vendor_code', 'like', "%{$search}%");
                $q->orWhere('users.first_name', 'like', "%{$search}%");
                $q->orWhere('users.last_name', 'like', "%{$search}%");
            });
        }
        $result=null;
        if($user == 1)
        {
        	$result = $query
        	->leftjoin('vendors', 'vendors.id', '=', 'users.vendor_id')
        	->where('users.id', '!=', '1')
        	->select('users.*', 'vendors.vendor_code as vendor_code')
        	->sortable()
        	->orderBy('created_at', 'DESC')
        	->paginate($perPage);
        }
        else
        {
        	$result = $query
        		->leftjoin('vendors', 'vendors.id', '=', 'users.vendor_id')
        		->where('users.vendor_id', '!=', '0')
        		->select('users.*', 'vendors.vendor_code as vendor_code')
        		->sortable()
        		->orderBy('created_at', 'DESC')
        		->paginate($perPage);
        }
        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        return $this->find($id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSocialNetworks($userId, array $data)
    {
        return $this->find($userId)->socialNetworks()->updateOrCreate([], $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $user = $this->find($id);

        $this->avatarManager->deleteAvatarIfUploaded($user);

        return $user->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return User::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newUsersCount()
    {
        return User::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByStatus($status)
    {
        return User::where('status', $status)->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return User::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfNewUsersPerMonth($from, $to)
    {
        $perMonthQuery = $this->getPerMonthQuery();

        $result = User::select([
            DB::raw("{$perMonthQuery} as month"),
            DB::raw('count(id) as count')
        ])
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->lists('count', 'month');

        $counts = [];

        foreach(range(1, 12) as $m) {
            $month = date('F', mktime(0, 0, 0, $m, 1));

            $month = trans("app.months.{$month}");

            $counts[$month] = isset($result[$m])
                ? $result[$m]
                : 0;
        }

        return $counts;
    }

    /**
     * Creates query that will be used to fetch users per
     * month, depending on type of the connection.
     *
     * @return string
     */
    private function getPerMonthQuery()
    {
        $connection = DB::connection();

        if ($connection instanceof SQLiteConnection) {
            return 'CAST(strftime(\'%m\', created_at) AS INTEGER)';
        }

        return 'MONTH(created_at)';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersWithRole($roleName)
    {
        return Role::where('name', $roleName)
            ->first()
            ->users;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserSocialLogins($userId)
    {
        $result = DB::table('social_logins')
            ->where('user_id', $userId)
            ->get();

        return collect($result);
    }

    /**
     * {@inheritdoc}
     */
    public function setRole($userId, $roleId)
    {
        $roleId = is_array($roleId) ?: [$roleId];

        return $this->find($userId)->roles()->sync($roleId);
    }

    /**
     * {@inheritdoc}
     */
    public function findByConfirmationToken($token)
    {
        return User::where('confirmation_token', $token)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function switchRolesForUsers($fromRoleId, $toRoleId)
    {
        return DB::table('role_user')
            ->where('role_id', $fromRoleId)
            ->update(['role_id' => $toRoleId]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function lists($column = 'username', $key = 'id')
    {
    	return User::lists($column, $key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getVendorUsers($vendorId)
    {
    	if($vendorId == '')
    	{
    		$vendorId = -1;
    	}
    	return User::where('vendor_id', $vendorId)->where('status',"Active")->lists('username', 'id');
    }
    
}