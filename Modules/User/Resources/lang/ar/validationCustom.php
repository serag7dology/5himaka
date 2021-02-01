<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute  يجب ان يفيل.',
    'active_url' => 'The :attribute هذا غير نشط.',
    'after' => 'The :attribute يجب ان يكون تاريخ بعد هذا التاريخ :date.',
    'after_or_equal' => 'The :attribute يجب ان يكون بعد هذا التاريخ او مساو له  :date.',
    'alpha' => 'The :attribute يجب ان يحتوى على حروف.',
    'alpha_dash' => 'The :attribute ربما يحتوى على حروف وارقام او _ او - .',
    'alpha_num' => 'The :attribute ربما تحتوى على حروف او ارقام.',
    'array' => 'The :attribute يجب ان يكون مصفوفة.',
    'before' => 'The :attribute يجب ان يكون قبل هذا التاريخ :date.',
    'before_or_equal' => 'The :attribute يجب ان يكون قبل هذا التاريخ او مساو له :date.',
    'between' => [
        'numeric' => 'The :attribute يجب ان يكون  رقم :min and :max.',
        'file' => 'The :attribute يجب ان يكون ملف :min and :max kilobytes.',
        'string' => 'The :attribute يجب ان يكون حروف:min and :max characters.',
        'array' => 'The :attribute يجب ان يكون مصفوفة :min and :max items.',
    ],
    'boolean' => 'The :attribute يجب ان يكون صح او خطأ.',
    'confirmed' => 'The :attribute غير متطابقين.',
    'date' => 'The :attribute تاريخ غير صالح .',
    'date_equals' => 'The :attribute التاريخ يجب ان يساوى هذا التاريخ:date.',
    'date_format' => 'The :attribute صيغة التاريخ مختلفة  :format.',
    'different' => 'The :attribute و :يجب ان يكونوا مختلفين .',
    'digits' => 'The :attribute  يجب ان يكون :digits خانات.',
    'digits_between' => 'The :attribute يجب ان يكون n :min and :max digits.',
    'dimensions' => 'The :attribute غير صالحة الابعاد.',
    'distinct' => 'The :attribute fالقيمتين متشابهتين.',
    'email' => ' يجب ان يكون بريد الكترونى صالح ',
    'ends_with' => 'The :attribute يجب ان ينتهى باحد هذه القيم : :values.',
    'exists' => 'هذه القيمة غير موجوده.',
    'file' => 'The :attribute يجب ان يكون ملف .',
    'filled' => 'The :attribute يجب ان يحتوى على قيمة.',
    'gt' => [
        'numeric' => 'The :attribute يجب ان يكون اكبر من  :value.',
        'file' => 'The :attribute يجب ان يكون اكبر من :value kilobytes.',
        'string' => 'The :attribute يجب ان يكون اكبر من  :value characters.',
        'array' => 'The :attribute يجب ان يكون اكبر من  :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute يجب ان يكون اكبر من او مساو ل :value.',
        'file' => 'The :attribute يجب ان يكون اكبر من او مساو ل  :value kilobytes.',
        'string' => 'The :attribute يجب ان يكون اكبر من او مساو ل  :value characters.',
        'array' => 'The :attribute يجب ان يكون اكبر من او مساو ل .',
    ],
    'image' => 'The :attribute يجب ان تكون صوره.',
    'in' => ' قيمة  :attribute غير صالحة ',
    'in_array' => 'The :attribute هذه القيمة غير موجوده :other.',
    'integer' => 'The :attribute يجب ان تكون عدد صحيح .',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute يجب ان تكون اقل من  :value.',
        'file' => 'The :attribute يجب ان تكون اقل من  :value kilobytes.',
        'string' => 'The :attribute يجب ان تكون اقل من  :value characters.',
        'array' => 'The :attribute يجب ان تكون اقل من   :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute يجب ان تكون اقل من او مساو ل :value.',
        'file' => 'The :attribute يجب ان تكون اقل من او مساو ل :value kilobytes.',
        'string' => 'The :attribute يجب ان تكون اقل من او مساو ل :value characters.',
        'array' => 'The :attribute يجب ان تكون اقل من او مساو ل :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute ربما تكون اكبر من  :max.',
        'file' => 'The :attribute ربما تكون اكبر من  :max kilobytes.',
        'string' => 'The :attribute ربما تكون اكبر من  :max characters.',
        'array' => 'The :attribute ربما تكون اكبر من  :max items.',
    ],
    'mimes' => 'The :attribute يجب ان يكون من نوع : :values.',
    'mimetypes' => 'The :attribute يجب ان يكون من نوع : :values.',
    'min' => [
        'numeric' => 'The :attribute يجب ان لا يقل  عن  :min.',
        'file' => 'The :attribute يجب ان يكون اقل من  :min kilobytes.',
        'string' => 'The :attribute يجب ان يكون اقل من  :min characters.',
        'array' => 'The :attribute يجب ان يكون اقل من  :min items.',
    ],
    'not_in' => 'قيمة  :attribute غير صالحة .',
    'not_regex' => 'The :attribute الصيغة غير مناسبة .',
    'numeric' => 'The :attribute يجب ان يكون رقم .',
    'password' => 'كلمة المرور غير مطابقة للمواصفات .',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute  الصيغة غير مناسبة',
    'required' => 'The :attribute  يرجى ادخال ',
    'required_if' => 'The :attribute القيمة مطلوبة عندما :other is :value.',
    'required_unless' => 'The :attribute القيمة مطلوبة الا اذا  :other is in :values.',
    'required_with' => ' :attribute تكون مطلوبة عندما تكون :values موجوده.',
    'required_with_all' => 'The :attribute القيمة مطلوبة عندما :values are present.',
    'required_without' => 'The :attribute القيمة مطلوبة عندما :values is not present.',
    'required_without_all' => 'The :attribute القيمة مطلوبة عندما عندما يكون  :values ليس parents.',
    'same' => 'The :attribute and :other يجب ان نفس الشئ.',
    'size' => [
        'numeric' => 'The :attribute يجب ان يكون بحجم  :size.',
        'file' => 'The :attribute يجب ان يكون بحجم :size kilobytes.',
        'string' => 'The :attribute يجب ان يكون بحجم :size characters.',
        'array' => 'The :attribute يجب ان يحتوى على حجم  :size items.',
    ],
    'starts_with' => 'The :attribute يجب ان يبدأ ب  :values.',
    'string' => 'The :attribute يجب ان يكون حروف .',
    'timezone' => 'The :attribute يجب ان يكون توقيت منطقة صحيح .',
    'unique' => 'The :attribute هذا القيمة موجوده من قبل .',
    'uploaded' => 'The :attribute فشل فى الرفع .',
    'url' => 'The :attribute غير صالح .',
    'uuid' => 'The :attribute يجب ان يكون UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'email' => [
            'required'          => 'يرجى ادخال البريد الالكترونى',
            'email'             => 'يجب ان يكون بريد الكترونى صالح',
            'unique'            => 'هذا  البريد موجود بالفعل',
        ],
        'password' => [
            'required'          => 'كلمة المرور مطلوبه',
            'string'            => 'يجب ان تكون كلمة المرور حرف او حروف واررقام ورموز',
            'min'               =>'يجب ان تتكون كلمة السر على الاقل من :min ارقام  او احرف ' ,
            'confirmed'         => 'كلمة المرور غير متطابقة'
        ],
        'name' => [
            'required'          => 'يرجى ادخال الاسم',
            'max'               => ' يجب ان يزيد الاسم عن :max حروف او ارقام',
            'min'               =>'يجب ان يتكون الاسم  على الاقل من :min ارقام  او احرف ',
            'string'           => 'يجب ان يكون الاسم  نصى',
        ],   
        'mobile' => [
            'required'          => 'يرجى ادخال رقم الهاتف',
            'unique'            => 'هذا الهاتف مستخدم من قبل ',
            'min'               =>'يجب ان يتكون الهاتف  على الاقل من :min ارقام  او احرف ',
            'regex'             =>'يجب ان يكون ارقام من 0 إلى 9'
        ], 
        'user_id'=>[
            'required'           => ' رقم المستخدم مطلوب ',
            'exists'             => 'هذا المستخدم غير موجود',
        ],  
        'update_password'=>[
            'confirmed'           => ' كلمة المرور غير متطابقة',
            'min'               =>'يجب ان تتكون كلمة السر على الاقل من :min ارقام  او احرف '
        ], 
        'current_password'=>[
            'required_with'           => ' كلمة المرور الحالية مطلوبة عند تحديث كلمة المرور',
        ],     
        'code' => [
            'required'          => ' يرجى ادخال كود otp المرسل الى البريد',
            'numeric'            =>'الكود المرفق غير صالح',
        ], 
        'name_en' => [
            'required'          => 'برجاء ادخال الاسم باللغة الانجليزية  ',
            'regex'            =>  'الاسم باللغة  الانجليزية فقط ',
        ], 
        'name_ar' => [
            'required'          => 'برجاء الاسم باللغة العربية ',
            'regex'            =>  ' الاسم باللغة العربية فقط',
        ], 
        'name_ar' => [
            'required'          => 'برجاء ادخال الاسم باللغة العربية ',
        ], 
        'name_en' => [
            'required'          => 'برجاء ادخال الاسم  باللغة الانجليزية ',
        ], 
        'photos' => [
            'required'          => 'يرجى ادخال صور العقار',
            'array'          => 'يجب ان ان تكون صور العقار عبارة عن مجموعة',
        ],    
        'photos.*' => [
            'mimes'          => 'يجب ان ان تكون الملفات صور ',
        ],  
        'photo_id' => [
            'required'          => 'برجاء اختيار الصوره',
            'exists'            => 'هذه الصورة غير موجودة',
        ],
        'username' => [
            'required'          => 'يرجى ادخال اسم المستخدم او رقم الهاتف',
            'max'               => ' يجب ان يزيد الاسم عن :max حروف او ارقام',
            'regex'             => 'يجب ان لا يحتوى الاسم على اى مسافات',
            'min'               => 'يجب ان يتكون الاسم  على الاقل من :min ارقام  او احرف ',
            'unique'            =>'اسم المستخدم موجود بالفعل'
        ],
        'identify' => [
            'required'          => 'يرجى ادخال اسم المستخدم او رقم الجوال',
        ],
        'current_password' => [
            'required_with'       =>'كلمة السر الحالية مطلوبة عند تغير كلمة السر ',
        ],           
        'is_owner' => [
            'in'                    =>'يجب ان تكون القيمة 1',
        ],
        'type' => [
            'required'          => 'يرجى اختيار العقار',
            'between'           => 'يجب ان يكون بين 0 و4 ',
        ], 
        'district' => [
            'required'          => 'يرجى  ادخال اسم الحى',
            'string'            => 'يجب ان يكون اسم متاح',
        ], 
        'city' => [
            'required'          => 'يرجى  ادخال اسم المدينة',
            'string'            => 'يجب ان يكون اسم متاح',
        ], 
        'suk_number' => [
            'required'          => 'يرجى  ادخال رقم الصك ',
            'integer'           => ' يجب ان يكون رقم',
        ],
        'suk_date' => [
            'required'          => 'يرجى  ادخال  تاريخ الصك',
            'date_format'      => 'يجب ان تاريخ الصك بصيغة يوم شهر سنة ',
        ],
        'address' => [
            'required'          => 'يرجى ادخال  العنوان', 
            'string'            => 'يجب ان يكون اسم متاح' ,
            'min'               =>' هذا العنوان قصير' ,
            'max'               =>'يجب ان لا يزيد عن 255 حرف'   
        ], 
        'longitude' => [
            'required'          =>'يرجى ادخال خط الطول', 
        ], 
        'latitude' => [
            'required'          =>'يرجى ادخال خط العرض', 
        ], 
        'area' => [
            'required'          => 'يرجى  ادخال مساحة العقار ',
            'numeric'            => 'يجب ان تكون المساحة رقم',
        ], 
        'benefits_nearby' => [
            'required'          => 'يرجى  ادخال تفاصيل المنافع القريبة ',
            'string'            => 'يجب ان تكون نص  ',
        ],
        'price' => [
            'required'          => 'يرجى  ادخال سعر العقار ',
            'numeric'           => 'يجب ان تكون سعر العقار رقم',
        ], 
        'street_type' => [
            'required'          => 'يرجى  ادخال نوع الشارع ',
            'numeric'           => 'يجب ان تكون اسم الشارع  رقم',
            'in'                => ' يجب ان تكون نوع العقار بين 0 او 1 او 2',
        ],
        'street_name' => [
            'required'          => 'يرجى  ادخال ااسم الشارع  ',
            'string'            => 'يجب ان تكون نص  ',
        ],
        'street_view' => [
            'required'          => 'يرجى  ادخال عرض الشارع ',
            'numeric'           => 'يجب ان تكون عرض الشارع  رقم',
        ],
        'interfaces_number' => [
            'required'          => 'يرجى  ادخال  عدد الواجهات ',
            'numeric'           => 'يجب ان يكون  عدد الواجهات رقم ',
        ],
        'meter_price' => [
            'required'          => 'يرجى  ادخال سعر متر الارض ',
            'numeric'           => 'يجب ان يكون  سعر المتر  رقم ',
        ],
        'street_name' => [
            'required'          => 'يرجى  ادخال اسم الشارع  ',
            'string'            => 'يجب ان تكون نص  ',
        ],
        'floor_number' => [
            'required'          => 'يرجى  ادخال  رقم الدور ',
            'integer'           => 'يجب ان يكون رقم الدور  رقم صحيح',
        ],
        'bedrooms' => [
            'required'          => 'يرجى  ادخال  عدد غرف النوم  ',
            'integer'           => 'يجب ان يكون عدد غرف النوم رقم صحيح',
        ],
        
        'bathrooms' => [
            'required'          => 'يرجى  ادخال  عدد دورات المياه  ',
            'integer'           => 'يجب ان يكون عدد دورات المياه  رقم صحيح',
        ],
        
        'halls_number' => [
            'required'          => 'يرجى  ادخال عدد الصالات  ',
            'integer'           => 'يجب ان يكون عدد الصالات رقم صحيح',
        ],
        
        'session_rooms' => [
            'required'          => 'يرجى  ادخال  عدد المجالس  ',
            'integer'           => 'يجب ان يكون  عدد المجالس رقم صحيح',
        ],
        
        'kitchens' => [
            'required'          => 'يرجى  ادخال  عدد المطابخ  ',
            'integer'           => 'يجب ان يكون  عدد المطابخ رقم صحيح',
        ],
        'maid_room' => [
            'required'          => ' يرجى اختيار هل يوجد غرفة خادمة ام لا ',
            'numeric'           => 'يجب ان يكون رقم ',
            'in'                => ' يجب ان تكون الاختيار بين 0 او 1  ',
        ],
        'driver_room' => [
            'required'          => ' يرجى اختيار هل يوجد غرفة للسائق ام لا ',
            'numeric'           => 'يجب ان يكون رقم ',
            'in'                => ' يجب ان تكون الاختيار بين 0 او 1  ',
        ], 
        'indoor_parking' => [
            'required'          => ' يرجى اختيار هل يوجد موقف داخلى  ام لا ',
            'numeric'           => 'يجب ان يكون رقم ',
            'in'                => ' يجب ان تكون الاختيار بين 0 او 1  ',
        ],
        'date' => [
            'required'          => 'يرجى ادخال تاريخ الصيانة ',
            'date_format'       => 'يجب ان يكون التاريخ بصيغة يوم شهر سنة ',
        ], 
        'time' => [
            'required'          => 'يرجى ادخال وقت الصيانة ',
            'date_format'       => 'يجب  ان  يكون وقت الصيانة بصيغة ساعة  و دقائق',
        ],
        'pictures' => [
            'required'          => ' يرجى ارفاق صور لغرض الاصلاح ',
            'array'             => 'يجب ان تكون مجموعة صور',
        ],
        'pictures.*' => [
            'mimes'             => 'يجب  ان  يكون الملف صوره باحد هذه الصيغ  jpg او png او jpeg او gif  ',
        ],
        'picture' => [
            'required'          => 'يرجى ادخال  صورة ',
            'mimes'             => 'يجب  ان  يكون الملف صوره باحد هذه الصيغ  jpg او png او jpeg او gif  ',
        ],
        'type' => [
            'required'          => 'يرجى اختيار نوع الصيانة ',
            'string'            => 'يجب  ان  يكون نوع الصيانة حروف',
        ],
        'maintenance_id' => [
            'required'          => 'يرجى  ادخال رقم طلب الصيانة ',
            'exists'            => 'هذا الطلب غير موجود',
        ],
        'aqar_type' => [
            'required'          => 'يرجى اختيار نوع العقار ',
            'numeric'            => 'يجب  ان  يكون نوع العقار رقم',
            'in'            => 'يجب  ان  نوع العقار بين  0 ل 3',
        ],
        'floors_number' => [
            'required'          => 'يرجى  ادخال  عدد الطوابق ',
            'integer'           => 'يجب ان يكون  عدد الطوابق رقم صحيح',
        ],            
        'land_area' => [
            'required'          => 'يرجى  ادخال  مساحة الارض  ',
            'numeric'           => 'يجب ان يكون  مساحة الارض رقم ',
        ],  
        'building_area' => [
            'required'          => 'يرجى  ادخال  مساحة المبنى  ',
            'numeric'           => 'يجب ان يكون  مساحة المبنى رقم ',
        ],  
        'garage_floor' => [
            'required'          => ' يرجى ادخال هل المبنى يحتوى جراج ام لا ',
            'in'                => 'يجب ان يكون الاختيار بين 0 او 1 ',
        ], 
        'apartments_number' => [
            'required'          => 'يرجى ادخال عدد الشقق ',
            'integer'           => 'يجب ان يكون  عدد الشقق رقم صحيح',
        ], 
        'driver_room_number' => [
            'required'          => 'يرجى  ادخال  عدد غرف السائق ',
            'integer'           => 'يجب ان يكون  عدد غرف السائق رقم صحيح',
        ],
        'full_name' => [
            'required'          => 'يرجى ادخال الاسم بالكامل ',
            'string'            => 'يجب  ان  يكون الاسم  حروف',
        ],
        'bank_salary' => [
            'required'          => 'يرجى ادخال  الراتب المحول من البنك',
            'numeric'            => 'يجب  ان  يكون الراتب  رقم',
        ],
        'salary' => [
            'required'          => 'يرجى ادخال  الراتب الاساسى  ',
            'numeric'            => 'يجب  ان  يكون الراتب الاساسى  رقم',
        ],
        'total_salary' => [
            'required'          => 'يرجى ادخال اجمالى الراتب ',
            'numeric'            => 'يجب  ان  يكون اجمالى الراتب  رقم',
        ],
        'deduction' => [
            'required'          => 'يرجى ادخال  قيمة الاستقطاع',
            'numeric'            => 'يجب  ان  يكون   قيمة الاستقطاع  رقم',
        ],          
        'employer' => [
            'required'          => 'يرجى ادخال  جهة العمل ',
            'string'            => 'يجب  ان  يكون جهة العمل  نص',
        ],
        'occupation' => [
            'required'          => 'يرجى ادخال الوظيفة ',
            'string'            => 'يجب  ان  تكون الوظيفة  نص',
        ],
        'service_length' => [
            'required'          => 'يرجى ادخال  مدة الخدمة ',
            'string'            => ' يجب  ان  تكون مدة الخدمة نص ',
        ],
        'remain_service_life' => [
            'required'          => 'يرجى ادخال   مدة الخدمة المتبقية ',
            'string'            => 'يجب  ان  يكون  مدة الخدمة المتبقية  نص',
        ],
        'hand_commitment' => [
            'required'          => 'يرجى ادخال جهة الالتزام ',
            'string'            => 'يجب  ان  تكون جهة الالتزام  نص',
        ],
        'monthly_amount' => [
            'required'          => 'يرجى ادخال المبلغ المستقطع شهريا ',
            'numeric'           => ' يجب  ان يكون المبلغ  رقم ',
        ],
        'remaining_months' => [
            'required'          => 'يرجى ادخال  عدد الشهور  المتبقية لدفع الاستقطاع ',
            'numeric'           => ' يجب  ان  يكون  عدد الشهور  رقم ',
        ],
         'finance_id' => [
            'required'          => 'يرجى  ادخال رقم طلب التمويل ',
            'exists'            => 'هذا الطلب غير موجود',
        ],
        'setting_id' => [
            'required'          => 'يرجى  ادخال رقم  الاعداد ',
            'exists'            => 'هذا الاعداد غير موجود',
        ],
        'logo' => [
            'required'          => 'يرجى  ادخال  اللوجو ',
            'mimes'             => 'يجب ان ان تكون الايقونات  صور ',
        ], 
        'app_name' => [
            'required'          => 'يرجى ادخال اسم التطييق  ',
            'string'            => 'يجب  ان  يكون اسم التطييق  نص',
        ],
        'app_version' => [
            'required'          => 'يرجى ادخال رقم اصدار التطييق  ',
            'string'            => 'يجب  ان  يكون رقم اصدار التطييق  نص',
        ],
        'link'  => [
            'required'          => 'يرجى ادخال رابط  موقع التواصل  ',
            'url'               => 'يجب  ان  يكون  رابط صالح   ',
        ],
        'social_id' => [
            'required'          => 'يرجى  ادخال رقم موقع التواصل ',
            'exists'            => 'هذا الموقع غير موجود',
        ] ,
        'details' => [
            'required'          => 'يرجى  ادخال  التفاصيل  ',
            'string'            => 'يجب ان يكون التفاصيل  نص',
            'max'               => 'نص الرسالة كبير للغاية',
        ],   
        'contact_id' => [
            'required'          => 'يرجى  ادخال رقم  رسالة التواصل ',
            'exists'            => 'هذه رسالة غير موجودة',
        ] ,  
        'aqar_id' => [
            'required'          => 'يرجى ادخال رقم العقار ',
        ] ,
        'company_id' => [
            'required'          => 'يرجى اختيار الشركة ',
            'exists'            => 'هذه الشركة  غير موجودة',
        ] ,
        'consultant_id' => [
            'required'          => 'يرجى اختيار الاستشارى ',
            'exists'            => 'هذا الاستشارى  غير موجود',
        ] ,
        'execution_speed' => [
            'required'          => 'يرجى تقييم سرعة التنفيذ   ' ,
            'numeric'           => 'يجب ان تكون القيمة رقم',
            'between'           => 'يجب ان تكون قيمة التقييم بين 1 الى 5'
        ],
        'execution_quality' => [
            'required'          => 'يرجى   تقييم جودة التنفيذ ' ,
            'numeric'           => 'يجب ان تكون القيمة رقم',
            'between'           => 'يجب ان تكون قيمة التقييم بين 1 الى 5'
        ], 
        'explanation_clarification' => [
            'required'          => 'يرجى تقييم الشرح والتواصل   ' ,
            'numeric'           => 'يجب ان تكون القيمة رقم',
            'between'           => 'يجب ان تكون قيمة التقييم بين 1 الى 5'
        ], 
        'permanent_presence' => [
            'required'          => 'يرجى تقييم التواجد الدائم   ' ,
            'numeric'           => 'يجب ان تكون القيمة رقم',
            'between'           => 'يجب ان تكون قيمة التقييم بين 1 الى 5'
        ], 
        'effective_communication' => [
            'required'          => 'يرجى  تقييم التواصل الفعال ' ,
            'numeric'           => 'يجب ان تكون القيمة رقم',
            'between'           => 'يجب ان تكون قيمة التقييم بين 1 الى 5'
        ],  
        'comment' => [
            'required'         => 'برجاء  كتابة تعليق على هذا المستشار' ,
            'string'           => 'يجب ان يكون التعليق حروف',
            'max'              => 'يجب ان لا يزيد التعليق 200 حرف',
            'min'              => 'يجب ان لا يقل التعليق عن حرفين '
        ], 
        'profile_pic' => [
            'required'          => 'يرجى  ادخال  صورة الحساب الشخصى ',
            'mimes'             => 'يجب ان ان تكون الايقونات  صور ',
        ], 
         'contractor_id' => [
            'required'          => 'يرجى اختيار المقاول ',
            'exists'            => 'هذا المقاول  غير موجود',
         ],

         'construction_status' => [
            'required'          => 'يرجى  ادخال نوع الشارع ',
            'numeric'           => 'يجب ان تكون اسم الشارع  رقم',
            'in'                => ' يجب ان تكون نوع العقار بين 0 او 1 او 2',
        ],
        'finishing_type' => [
            'required'          => 'يرجى  ادخال نوع الشارع ',
            'numeric'           => 'يجب ان تكون اسم الشارع  رقم',
            'in'                => ' يجب ان تكون نوع العقار بين 0 او 1 او 2',
        ], 
        'offer_id' => [
            'required'          => 'يرجى اختيار العرض ',
            'exists'            => 'هذا العرض  غير موجود',
         ],
         'salary_transferred_to_bank' => [
            'required'          => 'يرجى  ادخال البنك المحول اليه الراتب ',
            'string'           => 'يجب ان  يكون نص ',
            'in'                => ' يجب ان تكون نوع العقار بين 0 او 1 او 2',
        ],
        'funding_amount' => [
            'required'          => '  يرجى ادخال قيمة التمويل',
            'numeric'           => 'يجب ان تكون  قيمة التمويل رقم',
        ],
        'profits' => [
            'required'          => '  يرجى ادخال قيمة الارباح',
            'numeric'           => 'يجب ان تكون  قيمة الارباح  رقم',
        ],
        'total_amount_support' => [
            'required'          => '  يرجى ادخال اجمالى قيمة التمويل',
            'numeric'           => 'يجب ان تكون اجمالى قيمة التمويل رقم',
        ],
        'loan_repayment_period' => [
            'required'          => '  يرجى ادخال  مدة سداد القرض            ',
            'numeric'           => 'يجب ان تكون   مدة سداد القرض رقم',
        ],
        'years_number_loan_repayment_period' => [
            'required'          => '  يرجى ادخال  عدد سنوان مدة سداد القرض',
            'numeric'           => 'يجب ان يكون عدد سنوات مدة سداد القرض رقم',
        ],
        'month_number_loan_repayment_period' => [
            'required'          => '  يرجى ادخال  عدد شهور مدة سداد القرض',
            'numeric'           => 'يجب ان يكون عدد شهور مدة سداد القرض رقم',
        ],
        'first_installment' => [
            'required'          => '  يرجى ادخال  القسط الاول ',
            'numeric'           => 'يجب ان تكون   مدة سداد القرض رقم',
        ],
        'second_installment' => [
            'required'          => '  يرجى ادخال  القسط الثانى ',
            'numeric'           => 'يجب ان يكون عدد سنوات مدة سداد القرض رقم',
        ],
        'month_number_first_installment' => [
            'required'          => '  يرجى ادخال  عدد شهور القسط الاول',
            'numeric'           => 'يجب ان يكون عدد شهور القسط الاول رقم',
        ],
        'month_number_second_installment' => [
            'required'          => '  يرجى ادخال  عدد شهور القسط الثانى',
            'numeric'           => 'يجب ان يكون عدد شهور القسط الثانى رقم',
        ],
        'purchase_order_id' => [
            'required'          => 'يرجى اختيار طلب الشراء ',
            'exists'            => 'هذا الطلب  غير موجود',
         ],
         'file' => [
            'required'          => 'يرجى  ادخال مستند الطلب',
            'mimes'             => 'يجب ان  المستند بصيغة pdf ',
        ], 
        'key' => [
            'required'          => 'برجاء ادخال مفتاح او الكلمة المراد البحث عنها  ',
        ],
        'value_name' => [
            'required'          => 'برجاء ادخال الكلمة المراد البحث عنها  ',
        ], 
    ],
    
                   

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'current_password' =>'كلمة السر الحالية ',
        'update_password' =>'كلمة السر الجديده'
    ],

];
