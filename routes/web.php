//
<?php
  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\PostController;
use Illuminate\Support\Carbon;
use App\Http\Controllers\LikeController;


 
Route::get('/', function () {
    return view('welcome');
});
 
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
});
 
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/upload', function (Request $request) {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Retrieve the user's authenticated username
        $username = Auth::user()->name;
    
        // Get the current timestamp
        $timestamp = time();
    
        // Generate a unique filename for the uploaded image
        $filename = $username . '_' . $timestamp . '.jpg';
    
        // Store the uploaded file in the "uploads" folder
        $request->file('image')->storeAs('public/uploads', $filename);
    
        // Return a success message
        return 'Image uploaded successfully!';
    })->name('upload')->middleware('auth');

});
Route::get('/images', function () {
    return view('images');
})->name('images')->middleware('auth');


Route::post('/like/{imageName}', [LikeController::class, 'store'])->name('like.store')->middleware('auth');

















// Route::get('/images', function () {
//     // Get the current date
//     $today = Carbon::now();

//     // Calculate the date one week ago
//     $oneWeekAgo = $today->subWeek();

//     // Get all files in the uploads folder
//     $files = Storage::disk('public')->files('uploads');

//     // Filter the files to get only the ones uploaded within a week
//     // $filteredFiles = array_filter($files, function ($file) use ($oneWeekAgo) {
//     //     $filePath = storage_path('app\public\\' . $file);
//     //     $fileDate = filemtime($filePath);
//     //     return Carbon::parse($fileDate)->greaterThanOrEqualTo($oneWeekAgo);
//     // });

//     // Return the filtered files to the view
//     return view('images.index', ['files' => $files]);
// })->name('images')->middleware('auth');;

