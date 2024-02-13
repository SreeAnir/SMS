<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationUser;
use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
     //
       /**
     * Display the specified resource.
     */
    public function show()
    {
       $user = auth()->user();
       $notifications = [];
       $student = $user->student ;

       $notification_type = 1;
       $notification_listing = NotificationUser::with(['notification' => function($query) use ( $notification_type ){
                $query->where('notification_type', $notification_type );
       }])->userNotification()->get();
       return view('student.profile.edit', compact('user','notifications','notification_listing','student'));
    }
    
    public function update(StudentRequest $request)
    {
        try{
            // dd(auth()->user());
            // auth()->user()->update($request->all());

            auth()->user()->update($request->getUserData());
            $student_data = $request->getStudentData();
            auth()->user()->student()->update($student_data);
            // $user->save();

            // Redirect back with a success message
            $response = ['status' => 'success', 'message' => 'Profile updated successfully'];
            return redirect()->route('profile.show')->with( $response ) ;
            //'success', 'Profile updated successfully!');
            }catch (Exception $e) { 
                $response = ['status' => 'error', 'message' => 'Failed to update'];
                return redirect()->route('profile.show')->with( $response ) ;
        
                // return redirect()->route('profile.show')->with('error', 'Failed to update!');
            } 
    }
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_photo.image' => 'The file must be an image.',
            'profile_photo.mimes' => 'The image must be in JPEG, PNG, JPG, or GIF format.',
            'profile_photo.max' => 'The image must not exceed 2MB in size.',
        ]);
         
        $user = auth()->user();
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageName = 'dp_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            if ($user->profile_photo) {
                if (file_exists('uploads/' . $user->profile_photo)) {
                    unlink('uploads/' . $user->profile_photo);
                }
            }
        
            // Update user's profile photo in the database
            $user->profile_photo = $imageName;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile photo updated successfully.');
    }
}
