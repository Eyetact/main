<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Psy\SuperglobalsEnv;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed avatar
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'website',
        'avatar',
        'user_id',
        'group_id',
        'ugroup_id',
        'username',
        'access_table'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfileUrlAttribute()
    {
        return asset('uploads/users/' . $this->avatar);
    }

    public function setAvatarAttribute($value)
    {
        if ($value) {
            // dd($value);
            $ext = $value->getClientOriginalExtension();
            $file_name = time() . mt_rand(1000, 9000) . '.' . $ext;
            $value->move(public_path('uploads/users/'), $file_name);
            $this->attributes['avatar'] = $file_name;
        }
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function vendors()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function admins()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function settings()
    {
        return $this->hasOne(Setting::class, 'created_by');
    }

    public function groups()
    {
        return $this->hasMany(UCGroup::class, 'user_id');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }


    public function setAccessTableAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['access_table'] = "Individual";
        }
        $this->attributes['access_table'] = $value;

    }

    public function getAccessTableAttribute()
    {
        if ($this->attributes['access_table'] == null) {
            return "Individual";
        }

        return $this->attributes['access_table'];

    }

    public function getCountAttribute()
    {
        $super = $this->hasRole('super');
        if ($super) {

            return 1000;

        }
        //employee case
        if (count($this->subscriptions) == 0) {

            if (auth()->user()->user_id == 1) {
                return 1000;

            }
        }

        if ($this->hasRole('vendor') || $this->hasRole('admin')) {

            $sub_id = $this->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->id;

            $sum=Limit::where('subscription_id',$sub_id)->sum('data_limit');

        }
        else{

            $customer = User::find($this->user_id);
            $sub_id = $customer->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->id;
            $sum=Limit::where('subscription_id',$sub_id)->sum('data_limit');

        }

        return $sum;
    }


    protected function getDefaultGuardName(): string
    {
        return 'web';
    }



    public function getModelLimitAttribute() // $user->model_limit
    {

        $super = $this->hasRole('super');
        if ($super) {

            return 1000;

        }
        //employee case
        if (count($this->subscriptions) == 0) {

            if (auth()->user()->user_id == 1) {
                return 1000;

            }

            $customer = User::find($this->user_id);
            return $customer->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->plan?->model_limit;
        }

        return (int) $this->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->plan?->model_limit;

    }

    public function getDataLimitAttribute() // $user->model_limit
    {
        $super = $this->hasRole('super');
        if ($super) {

            return 2000;

        }
        //employee case
        if (count($this->subscriptions) == 0) {

            if (auth()->user()->user_id == 1) {
                return 2000;

            }

            $customer = User::find($this->user_id);
            return $customer->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->plan?->data_limit;
        }

        return $this->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->plan?->data_limit;

    }


    public function getDataLimitByModel($module_id)
    {
        $super = $this->hasRole('super');
        if ($super) {
            return 1000;
        }
        //employee case
        if (count($this->subscriptions) == 0) {

            if (auth()->user()->user_id == 1) {
                return 1000;

            }

            $customer = User::find($this->user_id);
            $current_plan = $customer->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->plan;

            $limit = Limit::where('plan_id', $current_plan->id)->where('module_id', $module_id)->first()->data_limit;

            return $limit;

        }
        
        if($this->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()){
            $current_plan = $this->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first()?->plan;

            $limit = Limit::where('plan_id', $current_plan->id)->where('module_id', $module_id)->first();

            if($limit){

                return $limit?->data_limit;;
            }
        }
        
        return 0;


    }

    public function getCurrentModelLimitAttribute()
    {
        return count($this->modules);
    }

    //$user->model_limit < $user->current_model_limit

    //$user->data_limit < count(unit::all())


}
