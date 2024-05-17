<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
class LoginController extends Controller
{
    use HasFactory, Notifiable, HasApiTokens;
public function login(Request $request)
{
$request->validate([
'email' => 'required|email',
'password' => 'required',
]);
if (Auth::attempt($request->only('email', 'password'))) {
$user = Auth::user();
$token = $user->createToken('token-name')->plainTextToken;

return response()->json([
'status' => true,
'message' => 'User Logged In Successfully',
'token' => $token,
'user' =>$user
], 200);
}
throw ValidationException::withMessages([
'email' => ['The provided credentials are incorrect.'],



]);
}
public function logout(Request $request)
{
$request->user()->tokens()->delete();
return response()->json([
'message' => 'Successfully logged out'
]);

}

}
