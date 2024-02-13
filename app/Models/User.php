<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasStatus;

// use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable,HasRoles,SoftDeletes,HasStatus;

    public const PERMISSION_LIST = 'List users';
    public const PERMISSION_VIEW = 'View users';
    public const PERMISSION_UPDATE = 'Update users';
    public const PERMISSION_CREATE = 'Create users';
    public const PERMISSION_DELETE = 'Delete users';

    public const PERMISSION_ASSIGN_ROLE = 'Assign Role';

    public const PERMISSION_LIST_STAFF = 'List users';
    public const PERMISSION_VIEW_STAFF = 'View users';
    public const PERMISSION_UPDATE_STAFF = 'Update users';
    public const PERMISSION_CREATE_STAFF = 'Create users';
    public const PERMISSION_DELETE_STAFF = 'Delete users';

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     
     
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $guarded = ['id']; 

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function setPhoneCodeAttribute($value)
    {
        $this->attributes['phone_code'] = str_replace('+', '', $value);
    }
    protected static function cleanPhoneNumber($phoneNumber)
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }

    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = static::cleanPhoneNumber($value);
    }
    public function getFullNameAttribute()
    {
        return ucFirst($this->first_name." ".$this->last_name);
    }
    public function getFullPhoneNumberAttribute()
    {
        if($this->phone_code != null){
            return '+ '.$this->phone_code." ".$this->phone_number;
        }else{
            return "";
        }
    }
    public function getUserTypeLabelAttribute()
    {
        if($this->user_type == Role::USER_TYPE_SU){
            return __('Super Admin');
        }
        elseif($this->user_type == Role::USER_TYPE_ADMIN){
             return  (count( $this->roles) > 0 ? $this->roles[0]->name :__('No Roles')  );
        }
        elseif($this->user_type == Role::USER_TYPE_STUDENT){
            return __('Student');
        }
        else{
            return __('No info');
        }
    }
    public function getPermissions()
    {
        $permissions = collect();
        foreach ($this->roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }
        return $permissions;
    }
    
    public function scopeGenderLabel()
    {
        return ($this->gender == null ? "Not Given" :  ( $this->gender == true ? "Male" : "Female"  ) );
    }
    public function isSuperAdmin()
    {
        return ($this->user_type == Role::USER_TYPE_SU );
    }
    public function isStaff()
    {
        return ($this->user_type == Role::USER_TYPE_STAFF );
    }
    public function isAdmin()
    {
        return ($this->user_type == Role::USER_TYPE_ADMIN);
    }
    
    public function scopeFilterFromRequest(Builder $query)
    {
        if (request()->filled('search')) {
            if(request()->get('search')['value']!=null){
            $query->filterByName(request()->get('search')['value'])
            ->orWhere('email', 'LIKE', '%'.request()->get('search')['value'].'%')
            ->orWhere('phone_number', 'LIKE', '%'.request()->get('search')['value'].'%');
            }


        }
        if (request()->filled('status_id')) {
            $query->filterByStatus(request('status_id'));
        }
        
        if (request()->has('role') && request('role') != "") { 
            $query->whereHas('roles', function ($q) {
                $q->where('id', request('role'));
            });
        }
        // if (request()->has('kacha_id') && request('kacha_id') != "") { 
        //     if (request()->has('class_count') && request('class_count') != "") { 
        //         $query->filterByKacha(  request('kacha_id') , request('class_count')  );
        //     }else{
        //         $query->filterByKacha(request('kacha_id'));
        //     }
        // }
        
        if (request()->has('location_id') && request('location_id') != "" &&  (request('batch_id')==null) ) { 
                return $query->filterByLocation(  request('location_id') );
        }
        // if (request()->has('batch_id') && request('batch_id') != "") { 
            return $query->filterStudent( );
        // }
       
        // if (request()->has('role') && request('role') != "") {
        //     $query->whereHas('roles', function ($q) {
        //         $q->where('id', request('role'));
        //     });
        // }
    }
    public function scopeFilterByName(Builder $query, $text): Builder
    {
        $search_text = '%'.$text.'%';

        return $query->where(function ($q) use($search_text) {
            $q->where('first_name', 'LIKE', $search_text)
            ->orWhere('last_name', 'LIKE', $search_text);
        });
    } 
    public function loginSecurity()
    {
        return $this->hasOne(LoginSecurity::class);
    }
    public function scopeSU(Builder $query)
    {
        return $query->where('user_type', Role::USER_TYPE_SU);
    }
    public function scopeStaff(Builder $query)
    {
        return $query->where('user_type', Role::USER_TYPE_STAFF);
    }
    public function scopeStudentType(Builder $query)
    {
        return $query->where('user_type', Role::USER_TYPE_STUDENT);
    }
    public function scopeAdminType(Builder $query)
    {
        return $query->whereIn('user_type',[  Role::USER_TYPE_SU, Role::USER_TYPE_ADMIN ] );
    }
    
   
    public function scopeBranchWise(Builder $query)
    {
        if(auth()->user()->location_id !=null){
            return $query->filterByLocation( auth()->user()->location_id );
        }
        return $query;
    }
    public function scopeFilterByLocation(Builder $query, $location_id): Builder
    {
        // $nameToFilter = '%'.$text.'%';
        if( $location_id == ""){
            $location_id = auth()->user()->location_id ;
        }
        return $query->whereHas('location', function ($query) use ($location_id) {
            $query->where('location_id',  $location_id);
        });
    } 
    public function scopeFilterBatchAllStatus(Builder $query ): Builder
    {
        return $query->whereHas('student', function ($query)  { 
            if (request()->has('batch_id') && request('batch_id') != "") { 
                $batch_id = request('batch_id') ;
                $query->whereHas('allbatch', function ($query) use ($batch_id) {
                    $query->where('batch_id', $batch_id);
                });
            }
            if (request()->has('kacha_id') && request('kacha_id') != "") { 
                $kacha =   request('kacha_id') ;
                if (request()->has('class_count') && request('class_count') != "") { 
                    $class_count =  request('class_count')  ;
                            $query->whereHas('kachaStudents', function ($query) use ($kacha, $class_count) {
                                $query->where('kacha_id', $kacha)
                                      ->where('class_count', $class_count);
                            });
                }else{
                        $query->where('kacha_id',  $kacha );
                }
            }
           
        });
    } 
    public function scopeFilterStudent(Builder $query ): Builder
    {
        if(request('batch_id')!="" || request('kacha_id')!=""){

        return $query->whereHas('student', function ($query)  { 
            if (request()->has('batch_id') && request('batch_id') != "") { 
                $batch_id = request('batch_id') ;
                $query->whereHas('batch', function ($query) use ($batch_id) {
                    $query->where('batch_id', $batch_id);
                });
            }
            if (request()->has('kacha_id') && request('kacha_id') != "") { 
                $kacha =   request('kacha_id') ;
                if (request()->has('class_count') && request('class_count') != "") { 
                    $class_count =  request('class_count')  ;
                            $query->whereHas('kachaStudents', function ($query) use ($kacha, $class_count) {
                                $query->where('kacha_id', $kacha)
                                      ->where('class_count', $class_count);
                            });
                }else{
                        $query->where('kacha_id',  $kacha );
                }
            }
           
        });
    }
    return $query ;
    } 

    // public function scopeFilterByKacha(Builder $query, $kacha , $class_count = 0): Builder
    // {
    //     if( $class_count > 0  ){
    //         return $query->whereHas('student', function ($query) use ($kacha, $class_count) { 
    //             $query->whereHas('kachaStudents', function ($query) use ($kacha, $class_count) {
    //                 $query->where('kacha_id', $kacha)
    //                       ->where('class_count', $class_count);
    //             });
    //         });
         
    //     }else{
    //         return $query->whereHas('student', function ($query) use ($kacha) {
    //             $query->where('kacha_id',  $kacha );
    //         });
         
    //     }
      
    // } 
    public function getProfilePhotoUrlAttribute()
    {
        if($this->attributes['profile_photo'] == ""){
            $path = 'placeholder/dp.png';
            return asset($path);
        }
        $path = 'uploads/' . $this->attributes['profile_photo'];
        return asset($path);
    }
     public function getGenderLabelAttribute()
    {
        return  ($this->gender ==1 ? "Male" : "Female");
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    // Define the relationship with the Location model
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
  
    public function getStudentIDAttribute()
    {
        return ($this->attributes['ID_Number']?$this->attributes['ID_Number'] :$this->attributes['id'] );
    }
    public function fee()
    {
        return $this->hasOne(Fee::class);
    }
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }
    public function branch()
    {
        return $this->hasOne(Branch::class);
    }
}

