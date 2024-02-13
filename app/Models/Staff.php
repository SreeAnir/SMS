<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staffs'; 
    protected $fillable = ['user_id',
        'present_address',
    'permanent_address',
    'alt_phone_number',
    'alt_phone_code',
    'home_phone_number',
    'home_phone_code',
    'emergency_phone_number',
    'emergency_phone_code',
    'emergency_contact_person',
    'emergency_contact_person_relation',
    'visa_uid',
    'visa_file_no',
    'visa_issue_date',
    'visa_expiry_date',
    'passport_number',
    'passport_issue_date',
    'passport_expiry',
    'emirates_id',
    'emirates_id_expiry',
    'iban_no',
    'bank_name',
    'bank_branch',
    'insurance_provider',
    'policy_no',
    'policy_plan',
    'policy_expiry_date',
    ];

    
    public function scopeStaff(Builder $query)
    {
        return $query->where('user_type', Role::USER_TYPE_STAFF);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
