<?php


// use App\Models\Batch;
// use App\Models\Category;
// use App\Models\Country;
// use App\Models\Location;
// use App\Models\User;
// use App\Models\Fee;
// use App\Models\Payment;
use App\Models\{
    Batch,
    Country,
    Location,
    User,
    Fee,
    Payment,
    Kacha,
    Status
};


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

// function customAudit($event, $model, $old, $new)
// {
//     $model->auditEvent = $event;
//     $model->isCustomEvent = true;
//     $model->auditCustomOld = $old;
//     $model->auditCustomNew = $new;
//     Event::dispatch(AuditCustom::class, [$model]);
// }

// /**
//  * @throws ContainerExceptionInterface
//  * @throws NotFoundExceptionInterface
//  */
// function getActivityLogs(LengthAwarePaginator $logs = null): LengthAwarePaginator
// {
//     $data = [];
//     /** @var Audit $timeline */
//     foreach ($logs as $timeline) {
//         $timeline->memoizedLoad();
//         $auditable = $timeline->auditable;
//         $event = $timeline->event;
// //        $user_id = $timeline->user_id;
// //        $date_time = $timeline->created_at->format('Y-m-d H:i');
//         $type = class_basename($timeline->auditable_type);
//         if (Str::is('*Translation', $timeline->auditable_type)) {
//             $type = ($auditable->locale === 'en' ? 'English' : 'Arabic').' '
//                 .'Translation of '.str_replace('Translation', '', $type);
//         }
//         //Generalize all other events into updated
//         $event = in_array($event, ['created', 'updated', 'deleted']) ? $event : 'updated';
//         $key = $timeline->_id;
//         if (!isset($data[$key])) {
//             $data[$key] = [
//                 'name' => $auditable?->name ?? $auditable?->title,
//                 'created_at' => $timeline->created_at,
//                 'user' => $timeline->user,
//                 'event' => $event,
//                 'type' => $type,
//                 'crunched' => 0,
//                 'attributes' => []
//             ];
//         }
//         $data[$key]['crunched']++; //Just a counter to keep track of how many audit entries are compressed into this one output.
//         $data[$key]['attributes'] = array_merge($timeline->getModified(), $data[$key]['attributes']);
//     }
//     return (new LengthAwarePaginator($data, $logs->total(), $logs->perPage(), request()->get('page', 1),
//         $logs->getOptions()))->appends(request()->except(['_token', '_method']));
// }

function array_xor($array1, $array2): array
{
    return array_unique(array_merge(array_diff($array1, $array2), array_diff($array2, $array1)));
}

// /**
//  * Function to generate a unique slug
//  *
//  * @param $slug
//  * @param $model
//  * @param  string  $language
//  * @param  null  $ignore
//  * @param  int  $iteration
//  * @return string
//  */
// function generateUniqueSlug($slug, $model, $ignore = null, string $language = 'en', int $iteration = 1): string
// {
//     $slug = Str::slug($slug, '-', $language);

//     if (!is_string($slug)) {
//         throw new InvalidArgumentException('First parameter to generateUniqueSlug function should be a string!');
//     }

//     if (!class_exists($model) || !is_subclass_of($model, Model::class)) {
//         throw new InvalidArgumentException('Second parameter to generateUniqueSlug function should be a valid model class!');
//     }

//     $the_slug = $iteration > 1 ? $slug.'-'.$iteration : $slug;
//     $query = $model::query();

//     /** @var Builder $slugCheck */
//     $slugCheck = (clone $query)->where('slug', $the_slug)
//         ->withTrashed();
//     //Ignore currently updating model if any
//     if ($ignore) {
//         $slugCheck->whereNotIn('id', (array) $ignore);
//     }

//     if (!$slugCheck->exists()) {
//         return $the_slug;
//     }

//     return generateUniqueSlug($slug, $model, $ignore, $language, $iteration + 1);
// }

 

// /**
// * Function to get category listing
// *
// * @return array
// */
// function categoryList($model_id=null){
//     $List =Category::defaultFilters();
//     if($model_id !=null){
//         $List =  $List->orWhere('categories.id', $model_id);
//     }
//     return $List->get();
// }

// /**
// * Function to get category listing
// *
// * @return array
// */
// function tutorList($model_id=null){
//    $List =Tutor::defaultFilters();
//    if($model_id !=null){
//        $List =  $List->orWhere('tutors.id', $model_id);
//    }
//    return $List->get();
// }
// /**
//  * Function to get country listing
//  *
//  * @return array
//  */
// function countryList(){
//     return Country::get();
// }

// function getImagePaths($url = null)
// {
//     $images = ['path' => null, 'h_path' => null, 'm_path' => null, 'l_path' => null, 'wp_path' => null, 'key' => null];

//     if ($url) {
//         $path = parse_url($url, PHP_URL_PATH);
//         $file_name = basename($url);
//         $key = pathinfo($path, PATHINFO_FILENAME);

//         $images = [
//             'path' => env('AWS_BUCKET_CDN') . "/public/RAW/{$file_name}",
//             'h_path' => env('AWS_BUCKET_CDN') . "/public/H_" . preg_replace('/.jpeg|.jpg|.png/i', '', $key) . ".jpg",
//             'm_path' => env('AWS_BUCKET_CDN') . "/public/M_" . preg_replace('/.jpeg|.jpg|.png/i', '', $key) . ".jpg",
//             'l_path' => env('AWS_BUCKET_CDN') . "/public/L_" . preg_replace('/.jpeg|.jpg|.png/i', '', $key) . ".jpg",
//             'wp_path' => env('AWS_BUCKET_CDN') . "/public/" . preg_replace('/.jpeg|.jpg|.png/i', '', $key) . ".webp",
//             'key' => $key
//         ];

//     }
//     return $images;
// }

// function getVideoPaths($url = null, $folder = null)
// {
//     $video = ['path' => null, 'key' => null, 'file_name' => null];

//     if ($url && $folder) {
//         $path = parse_url($url, PHP_URL_PATH);
//         $key = pathinfo($path, PATHINFO_FILENAME);
//         $file_name = basename($url);

//         $video = [
//             'path' => env('AWS_BUCKET_CDN') . '/' . $folder . '/' . $key . '/' . $key . '.m3u8',
//             'key' => $key,
//             'file_name' => $file_name
//         ];
//     }

//     return $video;
// }

 
// function reindex($table, $course_id = null): void
// {
//     if (isset($course_id)) {
//         $query = DB::table($table)
//             ->where('course_id', $course_id)
//             ->orderBy('index', 'asc')
//             ->latest('updated_at')
//             ->get();
//     } else {
//         $query = DB::table($table)
//             ->orderBy('index', 'asc')
//             ->latest('updated_at')
//             ->get();
//     }

//     $ids = [];
//     $cases = [];
//     $index = 1;

//     foreach ($query as $row) {
//         $cases[] = sprintf("WHEN id = %d THEN %d ", $row->id, $index);
//         $ids[] = $row->id;
//         $index++;
//     }

//     $updateQuery = "UPDATE $table SET `index` = CASE " . implode(" ", $cases) . " ELSE `index` END, `updated_at` = `updated_at` WHERE id IN (" . implode(",", $ids) . ")";
//     DB::statement($updateQuery);
// }


// function shortNumber($num) 
// {
//     $units = ['', 'K', 'M', 'B', 'T'];
//     for ($i = 0; $num >= 1000; $i++) {
//         $num /= 1000;
//     }
//     return round($num, 1) . $units[$i];
// }

 function countryList(){
    return Country::select('id','name','code')->get();
}

function batchList($location=null){
    if($location != null ){
        return Batch::select('id','location_id','batch_name','batch_time','status_id')->where("location_id",$location)->get();
    }
    return Batch::get();
}
function locationList($filter =[]){
    if( count( $filter)> 0 ){
        if(isset( $filter['location_id'] )){
            return Location::where('id',  $filter['location_id']  )->get();
        }
    }

    return Location::get();
}
function recpientList($active = true){
    return User::StudentType()->get();
}
function feeTypelist(){
    return Fee::list();
}
function paymentModeList(){
    return Payment::list();
}
function kachaList(){
    return Kacha::get();
}
function statusList(){
    return Status::list();
}
// function calculateContrastColor($color)
// {
//     list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
//     $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
//     return $brightness > 128 ? '#FFFF' : '#000000';
// }