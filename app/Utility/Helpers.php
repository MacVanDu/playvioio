<?php
use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        $setting = Setting::where('name', $key)->first();
        return $setting->content ?? $default;
    }
}
if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('' . $path, $secure);
    }
}


function translate($key, $lang = null, $addslashes = false)
{
    return $key;
    if($lang == null){
        $lang = App::getLocale();
    }
    
    $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));
    
    $translations_en = Cache::rememberForever('translations-en', function () {
        return Translation::where('lang', 'en')->pluck('lang_value', 'lang_key')->toArray();
    });
    
    if (!isset($translations_en[$lang_key])) {
        $translation_def = new Translation;
        $translation_def->lang = 'en';
        $translation_def->lang_key = $lang_key;
        $translation_def->lang_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
        $translation_def->save();
        Cache::forget('translations-en');
    }

    // return user session lang
    $translation_locale = Cache::rememberForever("translations-{$lang}", function () use ($lang) {
        return Translation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
    });
    if (isset($translation_locale[$lang_key])) {
        return trim($translation_locale[$lang_key]);
    }

    // return default lang if session lang not found
    $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
        return Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
    });
    if (isset($translations_default[$lang_key])) {
        return trim($translations_default[$lang_key]);
    }

    // fallback to en lang
    if (!isset($translations_en[$lang_key])) {
        return trim($key);
    }
    return trim($translations_en[$lang_key]);
}

if (!function_exists('getBaseURL')) {
    function getBaseURL($part = '')
    {
        $root = '//' . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root.$part;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL') . '/';
        } else {
            return getBaseURL() . '';
        }
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        return null;
        if (($asset = \App\Models\Upload::find($id)) != null) {
            return $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;
        }
        return null;
    }
}

// html btn switch 
if (!function_exists('html_select2')) {
    function html_select2($label, $value,$name,$data,$required = 0,$col_left = 3,$col_right = 9)
    {
   
    $span_danger = $required?'<span class="text-danger">*</span>':'';
    
    $required_attr = $required?'required':'';
    $options = '<option>--</option>';
        
    foreach ($data as $item) {
         $text = @$item->name?@$item->name:'';
        $text = @$text? $text: @$item->title;
        $text = @$text? $text: @$item->category_name; 
        $selected = $value == $item->id ? 'selected':'';
        $options = $options.'<option '.$selected.' value="'.$item->id.'">
                    '.$text.'
                </option>';
      }

       echo '
       <div class="form-group row"  >
       <label class="col-md-'.$col_left.' col-from-label">
           '.$label.'
           '.$span_danger.'
       </label>
       <div class="col-md-'.$col_right.'">
           <select class="form-control aiz-selectpicker" name="'.$name.'" id="'.$name.'" data-live-search="true" '.$required_attr.'>
               '.$options.'
           </select>
       </div>
   </div>

  
  '; 
    }
}

// html btn switch 
if (!function_exists('html_btn_switch')) {
    function html_btn_switch($label, $value,$name,$col_left = 3,$col_right = 9)
    {
   
        $checked = $value?'checked=""':'';
       echo '
       <div class="form-group row">
                                <label class="col-md-'.$col_left.' col-from-label">'.$label.'</label>
                                <div class="col-md-'.$col_right.'">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="'.$name.'" value="1" '.$checked.'>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
  '; 
    }
}

// html btn switch 
if (!function_exists('html_textarea')) {
    function html_textarea($label, $value,$name,$col_left = 3,$col_right = 9)
    {
   
       
       echo '
       <div class="form-group row">
                            <label class="col-md-'.$col_left.' col-from-label">'.$label.'</label>
                            <div class="col-md-'.$col_right.'">
                                <textarea class="aiz-text-editor" name="'.$name.'">'.$value.'</textarea>
                            </div>
                        </div>

  
  '; 
    }
}