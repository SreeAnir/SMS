<?php

namespace App\Http\Controllers;

use App\Models\LoginSecurity;
use App\Models\User;
use App\Notifications\ResetAuth;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Exception;
class LoginSecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show 2FA Setting form
     */
    public function show2faForm(Request $request){

        $user =Auth::guard('admin')->user(); 
        $google2fa_url = "";
        $secret_key = "";
        if($user->loginSecurity()->exists()){
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'Authenticate Kalari',
                $user->email,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );

        return view('auth.2fa_settings')->with('data', $data);
    }

    /**
     * Generate 2FA secret key
     */
    public function generate2faSecret(Request $request){
        $user = Auth::guard('admin')->user();
        // Initialise the 2FA class
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        // Add the secret key to the registration data
        $login_security = LoginSecurity::firstOrNew(array('user_id' => $user->id));
        $login_security->user_id = $user->id;
        $login_security->google2fa_enable = 0;
        $login_security->google2fa_secret = $google2fa->generateSecretKey();
        $login_security->save();

        return redirect()->route('enable2FaForm')->with('success',"Secret key is generated.");
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request){
        $user = Auth::user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);

        if($valid){
            $user->loginSecurity->google2fa_enable = 1;
            $user->loginSecurity->save();
            return redirect()->route('enable2FaForm')->with('success',"2FA is enabled successfully.");
        }else{
            return redirect()->route('enable2FaForm')->with('error',"Invalid verification Code, Please try again.");
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your password does not matches with your account password. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::user();
        $user->loginSecurity->google2fa_enable = 0;
        $user->loginSecurity->save();
        return redirect()->route('enable2FaForm')->with('success',"2FA is now disabled.");
    }
    public function verifyRedirect2Fa(Request $request){
        $previousRouteName = Route::currentRouteName();

        if ( $previousRouteName === '2faVerify' ) {
            return redirect()->route('admin.dashboard');
        }else{
            return redirect(URL()->previous());
        }
    }
    public function drop2fa($email){
        try {

        $user = User::where('email',$email)->first();
         $loginSecurity =   $user->loginSecurity ;
         if($loginSecurity){
            $loginSecurity->delete();
            $user->loginSecurity()->dissociate();
            $user->save();
            echo "You can start 2Fa Again";
         }else{
            echo "No Security Found";
         }

    }catch (Exception $e) {  
        print_r($loginSecurity);
        echo "Exception";
    } 
    }
    
     public function sendMailToNew2F(User $user){
        try {
            $user?->notify(new ResetAuth( $user  ));
        return redirect()->route('admin.dashboard');
        // ->with('success',"Please check your email.");

    }catch (Exception $e) {  
        return redirect(URL()->previous());
    } 
    }
    public function sendMailToNew2Fconfirm( $id){
        try {
            
            $user = User::where('id',decrypt($id))->first();
            
            $loginSecurity =   $user->loginSecurity ;
            if($loginSecurity!=null){
               $loginSecurity->delete();
               $user->loginSecurity()->dissociate();
               $user->save();
            }else{
            }
             return redirect()->route('admin.dashboard');

    }catch (Exception $e) {  
        return redirect()->route('admin.dashboard');
    } 
    }
    
    // public function newAuthentor($email){
    //     try {

    //     $user = User::where('email',$email)->first();
    //      $loginSecurity =   $user->loginSecurity ;
    //      if($loginSecurity){
    //         $loginSecurity->delete();
    //         $user->loginSecurity()->dissociate();
    //         $user->save();
    //      } 
    //      return redirect()->route('home');

    // }catch (Exception $e) {  
    //     return redirect(URL()->previous());
    // } 
    // }
    
}