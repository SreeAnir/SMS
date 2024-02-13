<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Batch;
use App\Models\StaffPayment;
use App\Models\Event;
use App\Models\Notification;
use App\Models\AccountingCategory;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
// use App\Models\StudentFee;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('admin.dashboard'));
});

Breadcrumbs::for('admin.dashboard', function ($trail) {
    // $trail->push('Home', route('admin.dashboard'));
});


Breadcrumbs::for('roles.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('roles.index'));
});
Breadcrumbs::for('roles.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('roles.index');
});
Breadcrumbs::for('roles.show', function (BreadcrumbTrail $trail, Role $role): void {
    $trail->parent('roles.index');
    $trail->push($role->name, route('roles.show', $role));
});

Breadcrumbs::for('roles.edit', function (BreadcrumbTrail $trail, Role $role): void {
    $trail->parent('roles.index');
    $trail->push($role->name, route('roles.show', $role));
    $trail->push("Edit", route('roles.edit', $role));
});

Breadcrumbs::for('students.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Student', route('students.index'));
});
Breadcrumbs::for('students.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('students.index');
});

Breadcrumbs::for('students.show', function (BreadcrumbTrail $trail, User $user): void {
    $trail->parent('students.index');
    $trail->push($user->first_name, route('students.show', $user));
});
// Breadcrumbs::for('students.edit', function (BreadcrumbTrail $trail, User $id): void {
//     $trail->parent('students.index');
//     $trail->push($user->name, route('students.show', $id));
//     $trail->push("Edit", route('students.edit', $id));
// });

Breadcrumbs::for('students.edit', function (BreadcrumbTrail $trail, $user_id): void {
    $trail->parent('students.index');
    $trail->push('View', url()->previous());
    $trail->push('Edit', url()->previous());
});

// students
Breadcrumbs::for('users.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('users.show', function (BreadcrumbTrail $trail, User $model): void {
    $trail->parent('users.index');
    $trail->push($model->first_name, route('users.show', $model));
});
Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('users.index');
});
Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, User $model): void {
    $trail->parent('users.index');
    $trail->push($model->first_name, route('users.show', $model));
    $trail->push("Edit", route('users.edit', $model));
});
Breadcrumbs::for('staffs.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Staff', route('staffs.index'));
});
Breadcrumbs::for('staffs.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('staffs.index');
});
Breadcrumbs::for('staffs.show', function (BreadcrumbTrail $trail, User $user): void {
    $trail->parent('staffs.index');
    $trail->push($user->first_name, route('staffs.show', $user));
});

// Breadcrumbs::for('staffs.edit', function (BreadcrumbTrail $trail, User $user): void {
//     $trail->parent('staffs.index');
//     $trail->push($user->first_name, route('staffs.edit', $user));
// });
Breadcrumbs::for('staffs.edit', function (BreadcrumbTrail $trail, $staff_id): void {
    $trail->parent('staffs.index');
    $trail->push('View', url()->previous());
    $trail->push('Edit', url()->previous());
});

Breadcrumbs::for('staffs.update', function (BreadcrumbTrail $trail, User $user): void {
    $trail->parent('staffs.index');
    $trail->push($user->first_name, route('staffs.edit', $user));
});

Breadcrumbs::for('batches.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Batches', route('batches.index'));
});

Breadcrumbs::for('batches.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('batches.index');
});
Breadcrumbs::for('batches.show', function (BreadcrumbTrail $trail, Batch $batch): void {
    $trail->parent('batches.index');
    $trail->push($batch->batch_name, route('batches.show', $batch));
});
Breadcrumbs::for('batches.edit', function (BreadcrumbTrail $trail, Role $role): void {
    $trail->parent('batches.index');
    $trail->push($role->name, route('batches.show', $role));
    $trail->push("Edit", route('roles.edit', $role));

});

Breadcrumbs::for('staff-payments.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Staff Payments', route('staff-payments.index'));
});

Breadcrumbs::for('staff-payments.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('staff-payments.index');
});
Breadcrumbs::for('staff-payments.show', function (BreadcrumbTrail $trail, StaffPayment $staff_payment): void {
    $trail->parent('staff-payments.index');
    $trail->push("#".$staff_payment->id, route('staff-payments.show', $staff_payment));
});

Breadcrumbs::for('staff-payments.edit', function (BreadcrumbTrail $trail, StaffPayment $staff_payment ): void {
    $trail->parent('staff-payments.index');
    $trail->push('#'.$staff_payment->id, route('staff-payments.show', $staff_payment));
    $trail->push("Edit", route('staff-payments.edit', $staff_payment));

});




Breadcrumbs::for('events.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Events', route('events.index'));
});

Breadcrumbs::for('events.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('events.index');
});

Breadcrumbs::for('events.show', function (BreadcrumbTrail $trail, Event $event): void {
    $trail->parent('events.index');
    $trail->push("#".$event->id, route('events.show', $event));
});
Breadcrumbs::for('events.edit', function (BreadcrumbTrail $trail, Event $event ): void {
    $trail->parent('events.index');
    $trail->push('#'.$event->id, route('events.show', $event));
    $trail->push("Edit", route('events.edit', $event));

});

Breadcrumbs::for('events.calendar', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Events Calendar', route('events.index'));
});


Breadcrumbs::for('notifications.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Notifications', route('notifications.index'));
});

Breadcrumbs::for('notifications.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('notifications.index');
});

Breadcrumbs::for('notifications.show', function (BreadcrumbTrail $trail, Notification $notification): void {
    $trail->parent('notifications.index');
    $trail->push("#".$notification->id, route('notifications.show', $notification));
});

Breadcrumbs::for('notifications.edit', function (BreadcrumbTrail $trail, Notification $notification ): void {
    $trail->parent('notifications.index');
    $trail->push('#'.$notification->id, route('notifications.show', $notification));
    $trail->push("Edit", route('notifications.edit', $notification));

});

Breadcrumbs::for('change-password', function ($trail) {
    $trail->parent('home');
    $trail->push('Change Password', route('change-password'));
});
 

Breadcrumbs::for('web.dashboard', function ($trail) {
    $trail->push('Home', route('web.dashboard'));
});



Breadcrumbs::for('student-fees.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Student Fees', route('student-fees.index'));
});

// Breadcrumbs::for('admin.student-fees.manage', function (BreadcrumbTrail $trail): void {
//     $trail->parent('student-fees.index');
// });

Breadcrumbs::for('admin.student-fees.manage', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Student Fee', route('student-fees.index'));
    $trail->push('Manage Fee', "");
    // $trail->parent('accounting.index' ,route('accounting.index'));
    // $trail->push('Income & Expense', route('accounting.index'));

});


Breadcrumbs::for('accounting-categories.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Accounting Categories', route('accounting-categories.index'));
});
 

Breadcrumbs::for('accounting-categories.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('accounting-categories.index');
});
Breadcrumbs::for('accounting-categories.show', function (BreadcrumbTrail $trail, AccountingCategory $accountingCategory): void {
    $trail->parent('accounting-categories.index');
    $trail->push("#".$accountingCategory->category_label, route('accounting-categories.show', $accountingCategory));
});

Breadcrumbs::for('accounting-categories.edit', function (BreadcrumbTrail $trail, AccountingCategory $accountingCategory ): void {
    $trail->parent('accounting-categories.index');
    $trail->push('#'.$accountingCategory->category_label, route('accounting-categories.show', $accountingCategory));
    $trail->push("Edit", route('accounting-categories.edit', $accountingCategory));

});

Breadcrumbs::for('accounting.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Income & Expense', route('accounting.index'));
});
Breadcrumbs::for('accounting.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Income & Expense', route('accounting.index'));
    $trail->push('Add New', "");
    // $trail->parent('accounting.index' ,route('accounting.index'));
    // $trail->push('Income & Expense', route('accounting.index'));

});

Breadcrumbs::for('admin.profile', function ($trail) {
    $trail->parent('home');
    $trail->push('Profile', route('admin.profile'));
});

Breadcrumbs::for('student.attendance.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Student\'s Attendance', route('student.attendance.index'));
});
Breadcrumbs::for('staff.attendance.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Staff\'s  Attendance', route('staff.attendance.index'));
});