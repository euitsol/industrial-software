<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\InstallmentDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'additional_fee', 'user_id', 'updated_at'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function installment_dates()
    {
        return $this->hasMany(InstallmentDate::class);
    }
    public function get_due($pm_id)
    {
        $payments = Payment::where('account_id', $this->id)->get();
        $count = $payments->count();
        $due = 0;
        $paid = 0;
        $course_fee = $this->course->fee;

        if (isset($this->discount_percent) && $this->discount_percent > 0) {
            $total_fee = $course_fee - (($course_fee * $this->discount_percent) / 100);
        } elseif (isset($this->discount_amount) && $this->discount_amount > 0) {
            $total_fee = $course_fee - $this->discount_amount;
        } else {
            $total_fee = $course_fee;
        }

        $payment = Payment::findOrFail($pm_id);
        $current = $payment->created_at;
        foreach ($payments as $p) {
            if ($current >= $p->created_at) {
                $paid += $p->amount;
            }
        }

        return $total_fee - $paid;
    }

    public function get_student_type($stu_id)
    {
        $accounts = Account::where('student_id', $stu_id)->get();
        $count = $accounts->count();
        $result = 'New Student';
        if ($count > 1) {
            $account = Account::findOrFail($this->id);
            // dd($account);
            $current = $account->created_at;
            // dd($current);
            foreach ($accounts as $account) {
                // dd($account->created_at);
                if ($current > $account->created_at) {
                    $result = 'Previous student';
                }
            }
        } elseif ($count == 1) {
            $result = 'New student';
        } else {
            $result = 'Other';
        }
        return $result;
    }

    public function get_payment_type($acc_id = false, $pmt_id)
    {
        $acc_id = $this->id;
        $payments = Payment::where('account_id', $acc_id)->get();
        $count = $payments->count();
        $result = 'Installment Payment';
        if ($count == 0) {
            $result = 'Empty Payment';
        } elseif ($count == 1) {
            $result = 'First Payment';
        } else {
            $payment = Payment::findOrFail($pmt_id);
            $current = $payment->created_at;
            foreach ($payments as $p) {

                if ($current < $p->created_at) {
                    $result = 'First Payment';
                }
            }
        }
        return $result;
    }


    public function scopeWithDuePayments(Builder $query)
    {
        return $query->whereHas('course', function (Builder $query) {
            // Calculate the actual course fee considering discounts
            $query->where(function (Builder $query) {
                $query->whereRaw('
                    (
                        courses.fee 
                        - COALESCE(accounts.discount_amount, 0) 
                        - COALESCE(
                            (courses.fee * accounts.discount_percent / 100), 0
                        )
                        - COALESCE(
                            (SELECT SUM(amount) FROM payments WHERE payments.account_id = accounts.id), 0
                        )
                    ) > 0
                ');
            });
        });
    }
}
