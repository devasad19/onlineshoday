<?php 




if (!function_exists('fileUpload')) {
    function fileUpload($file, $path)
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = $fileName.'_'.time().'.'.$extension;
        $thumbnails = $file->move($path, $filename);

        return $filename;

    }
}

function isValidMobile($mobile, $method)
{
    // remove spaces or unwanted chars
    $mobile = preg_replace('/\D/', '', $mobile);

    if (strtolower($method) === 'rocket') {
        return preg_match('/^\d{12}$/', $mobile);
    }

    // for others (bkash, nagad, etc)
    return preg_match('/^\d{11}$/', $mobile);
}

	if (!function_exists('bnNum')) {
	    function bnNum($number)
	    {
	        $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
	        return str_replace(range(0, 9), $bn_digits, $number);
	    }
	}


    function bnMonthYear($engDate)
    {
        // $engDate = date('d F Y'); //Monday 10 2023

        $search_array= array("Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $replace_array= array("শনিবার","রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
 

        // convert all bangle char to English char 
        $bangla_date = str_replace($search_array, $replace_array, $engDate);   
        $bangla_date =  explode(" ",$bangla_date);
       
        return $bangla_date[1].' '.$bangla_date[2];
    }
    function bnDate($engDate)
    {
        // $engDate = date('d F Y'); //Monday 10 2023

        $search_array= array("Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $replace_array= array("শনিবার","রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
 

        // convert all bangle char to English char 
        $bangla_date = str_replace($search_array, $replace_array, $engDate);   
        $bangla_date =  explode(" ",$bangla_date);
       
        return $bangla_date[0].' '.$bangla_date[1].' '.$bangla_date[2];
    }


	function daysCount($date){
		$from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $date);
		$to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', now());

		$diff_in_days = $to->diffInDays($from);

		return $diff_in_days; // Output: days
	}
