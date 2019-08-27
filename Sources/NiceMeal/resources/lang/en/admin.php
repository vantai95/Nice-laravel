<?php

return [
    'confirm' => [
        'delete' => [
            'text' => 'Are you sure you want to delete? You won\'t be able to revert this!',
            'confirm_button' => 'Yes',
            'cancel_button' => 'Cancel'
        ],
        'duplicate' => [
            'text' => 'Are you sure you want to duplicate this record?'
        ]
    ],
    'day_name' => [
        'sun' => 'Sunday',
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday'
    ],
    'tooltip_title' => [
        'edit' => 'Edit',
        'delete' => 'Delete',
        'duplicate' => 'Duplicate',
        'change_sequence' => 'Drag and drop to change sequence'
    ],
    'buttons' => [
        'create' => 'Create',
        'update' => 'Update',
        'save' => 'Save',
        'edit' => 'Edit',
        'cancel' => 'Cancel',
        'upload' => 'Upload Image',
        'save_change' => 'Save Change',
        'back' => 'Back'
    ],
    'layouts' => [
        'header' => [
            'logout' => 'Logout',
            'my_profile' => 'My Profile'
        ],
        'aside_left' => [
            'group' => [
                'staff' => 'Staff',
                'customer' => 'Foodies',
                'restaurant' => 'Restaurant',
                'menu' => 'Menu',
                'service' => 'Service',
                'orders' => 'Orders',
                'configuration' => 'Configuration',
                'rule' => 'Rule',
                'general_info' => 'General Info',
                'printers' => 'Printers',
                'report' => 'Report',
                'vouchers' => 'Vouchers',
                'promotions' => 'Promotions',
                'reviews' => 'Reviews',
                'time_setting' => 'Time Setting',
                'exchange_rate' => 'Exchange Rate',
                'location' => 'Location'
            ],
            'section' => [
                'events' => 'Events',
                'galleries' => 'Galleries',
                'sequence' => 'Change Sequence'
            ],
            'menu' => [
                'staff' => [
                    'staff' => 'Staff',
                    'users' => 'Users',
                    'uploads' => 'Uploads',
                    'galleries' => 'Galleries',
                    'departments' => 'Departments',
                    'employees' => 'Employees',
                    'roles' => 'Roles',
                    'permissions' => 'Permissions'
                ],
                'customer' => [
                    'customer' => 'Foodies',
                    'address_info' => 'Address Info'
                ],
                'restaurant' => [
                    'categories' => 'Categories',
                    'restaurants_categories' => 'Assign Categories to Restaurant',
                    'cuisines' => 'Cuisines',
                    'tags' => 'Tags',
                    'order_reject_reason' => 'Reject Reason',
                    'restaurants_cuisines' => 'Assign Cuisines to Restaurant',
                    'restaurants' => 'Brands',
                    'deliveries' => 'Delivery',
                    'working_times' => 'Working times',
                    'groups' => 'Groups',
                    'top' => 'VIP'
                ],
                'dishes' => [
                    'dishes' => 'Food',
                    'customization' => 'Requests',
                    'time_base_display' => 'Time Base Display',
                    'time_base_pricing' => 'Time Base Pricing',
                ],
                'orders' =>'Orders Histories',
                'orders_live' =>'Live Orders',
                'general_info' => [
                    'detail_info' => 'Detail Info',
                    'intro' => 'Infomation',
                    'payment_setting' => 'Payment Setting',
                    'tax' => 'Taxes',
                    'tags' => 'Tags',
                    'otp_setting' => 'OTP Setting',
                ],
                'contacts' => 'Contacts',
                'faqs' => 'Faqs',
                'faqs_type' => 'Faqs Type',
                'printers' =>'Printers Management',
                'reports' => [
                    'sales' => 'Sales',
                    'invoices' => 'Invoice'
                ],
                'time_setting' => [
                  'available_time' => 'Available Time',
                  'showed_time' => 'Showed Time',
                  'priced_time' => 'Priced Time',
                ],
                'reviews' => 'Reviews Management',
                'rules' => [
                    'commission' => 'Commission Rules',
                    'order_reject_reason' => 'Reject Reason'
                ],
                'location' => [
                    'district' => 'District',
                    'ward' => 'Ward'
                ],
            ],
        ],
        'breadcrumbs' => [
            'change_sequence' => 'Change sequence'
        ]
    ],
    'faq' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'question_en' => 'English Question',
            'question_vi' => 'Vietnamese Question',
            'anwser_en' => 'English Answer',
            'anwser_vi' => 'Vietnamese Answer',
            'image' => 'Image',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'question_en' => 'English Question',
            'question_vi' => 'Vietnamese Question',
            'anwser_en' => 'English Answer',
            'anwser_vi' => 'Vietnamese Answer',
            'status' => 'Status',
            'active' => 'Active',
            'chosen_faq' => 'Choose FAQ Type to display'
        ],
        'breadcrumbs' => [
            'title' => 'FAQ',
            'all' => 'Tất Cả',
            'faq_index' => 'FAQ list',
            'new_faq' => 'New FAQ',
            'data_of_faq' => 'Data of FAQ',
            'add_faq' => 'Add FAQ',
            'edit_faq' => 'Edit FAQ',
            'delete_faq' => 'Delete FAQ'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'FAQ created!',
            'update' => 'FAQ updated!',
            'destroy' => 'FAQ deleted!',
            'can\'t_destroy' => 'Can not delete because FAQ is in used'
        ],
        'not_found' => 'Don\'t have any FAQ!'
    ],
    'faq_type' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vn' => 'Vietnamese Name',
            'image' => 'Image',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_vn' => 'Vietnamese Name',
            'anwser_en' => 'English Answer',
            'anwser_vi' => 'Vietnamese Answer',
            'status' => 'Status',
            'active' => 'Active',
            'chosen_faq' => 'List FAQs'
        ],
        'breadcrumbs' => [
            'title' => 'FAQ Type',
            'all' => 'Tất Cả',
            'faq_index' => 'FAQ Type list',
            'new_faq' => 'New FAQ Type',
            'data_of_faq' => 'Data of FAQ',
            'add_faq' => 'Add FAQ Type',
            'edit_faq' => 'Edit FAQ Type',
            'edit' => 'Edit FAQ',
            'delete_faq' => 'Delete FAQ Type'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'FAQ Type created!',
            'update' => 'FAQ Type updated!',
            'destroy' => 'FAQ Type deleted!',
            'can\'t_destroy' => 'Can not delete because FAQ Type is in used'
        ],
        'not_found' => 'Don\'t have any FAQ!'
    ],
    'users' => [
        'search' => [
            'status' => 'Status',
            'role' => 'Role',
            'place_holder_text' => 'Search by name or email...'
        ],
        'title' => [
            "details" => 'Personal Detail',
            "role" => 'Role and Permission',
            'update_profile' => 'Update Profile',
            'message' => 'Message',
            'settings' => 'Settings'
        ],
        'columns' => [
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'dob' => 'Day of Birth',
            'address' => 'Address',
            'role' => 'Role',
            'locked' => 'Locked',
            'status' => 'Status',
            'action' => 'Action',
            'restaurant' => 'Restaurant',
            'select_restaurant' => 'Select restaurant',
        ],
        'breadcrumbs' => [
            'title' => 'Admin',
            'user_index' => 'Admin',
            'my_profile' => 'My profile'
        ],
        'statuses' => [
            'all' => 'All',
            'locked' => 'Locked',
            'active' => 'Active'
        ],
        'roles' => [
            'all' => 'All',
            'select_role' => 'Select Role',
            'user' => 'Restaurant',
            'admin' => 'Operator',
            'customer' => 'Foodies'
        ],
        'not_found' => 'Don\'t have any user!'
    ],
    'restaurants' => [
        'search' => [
            'status' => 'Status',
            'restaurants_type' => 'New Blog',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'res_id' => 'Restaurant ID',
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            'news_type' => 'News Restaurant',
            'status' => 'Status',
            'action' => 'Action',
            'image' => 'Image',
            'vip' => 'VIP'
        ],
        'forms' => [
            'news_type' => 'New Restaurant',
            'name_en' => 'English name',
            'name_ja' => 'Japanese name',
            'highlight_label_en' => 'English Highlight label',
            'highlight_label_ja' => 'Japanese Highlight label',
            'title_brief_en' => 'English title brief',
            'title_brief_ja' => 'Japanese title brief',
            'description_en' => 'English Info',
            'description_ja' => 'Japanese Info',
            'note' => 'Note',
            'address_en' => 'English Address',
            'address_ja' => 'Japanese Address',
            'province_id' => 'Province Id',
            'province' => 'Province',
            'district_id' => 'District Id',
            'district' => 'District',
            'ward_id' => 'Ward Id',
            'phone' => 'Phone',
            'email' => 'Email',
            'banner' => 'Banner',
            'image' => 'Image',
            'review_rate' => 'Review rate',
            'otp' => 'For Previous order under',
            'otp_value' => 'For Order value over',
            'status' => 'Status',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'online_payment' => 'Online payment',
            'cod_payment' => 'Cod payment',
            'delivery' => 'Delivery',
            'pickup' => 'Pickup',
            'active' => 'Active',
            'slug' => 'Slug',
            'choose_province' => 'Choose Province',
            'choose_district' => 'Choose District',
            'choose_ward' => 'Choose Ward',
            'choose_status' => 'Choose Status',
            'ward' => 'Ward',
            'vip_restaurant' => 'Vip Restaurant',
            'tags' => 'Tags',
            'choose_tags' => 'Choose Tags',
            'address' => 'Address',
            'published' => 'Published',
            'file_import' => 'File Import',
            'choose_online_payment' => 'You should choose at least 1 type of payment!',
        ],
        'detail_info' => [
            'res_id' => 'Restaurant ID',
            'restaurant_name' => 'Restaurant Name',
            'restaurant_address' => 'Restaurant Address',
            'restaurant_phone' => 'Restaurant phone',
            'restaurant_email' => 'Restaurant Email',
            'restaurant_link' => 'Restaurant Website',
            'owner_name' => 'Owner Name',
            'owner_phone' => 'Owner Phone',
            'owner_email' => 'Owner Email',
            'delivery_setting' => 'Delivery Setting',
            'payment_setting' => 'Payment Setting',
            'maximum_discount' => 'Maximum Discount',
            'active' => 'Active',
            'setting' => 'Setting',
            'paypal' => 'Paypal',
            'ngan_luong' => 'Ngan Luong',
            'no_setting' => 'No setting',
            'chosen_faq' => 'Choose FAQ Type to display',
        ],
        'exchange_rate' => [
            'usd_vnd' => 'Exchange rate of 1 USD to'
        ],
        'form_title' => [
            'res_detail' => 'Restaurant Info',
            'owner_detail' => 'Owner Info',
            'res_work_time' => 'Restaurant Working Time',
            'res_delivery' => 'Restaurant Delivery Info',
            'location' => 'Location',
            'minimum' => 'Minimum',
            'fee' => 'Fee',
            'exchange_rate' => 'Exchange Rate'
        ],
        'breadcrumbs' => [
            'title' => 'Restaurant',
            'restaurants_type' => 'Restaurant type',
            'all' => 'All',
            'restaurants_index' => 'Restaurant list',
            'new_restaurants' => 'New Restaurant',
            'import_restaurants' => 'Import Restaurant',
            'data_of_restaurants' => 'Data of Restaurant',
            'add_restaurant' => 'Add Restaurant',
            'edit_restaurant' => 'Edit Restaurant',
            'delete_restaurants' => 'Delete Restaurant',
            'detail_info' => 'Restaurant Detail Info',
            'general_info' => 'Restaurant General Info',
            'tags' => 'Tags',
            'tag_info' => 'Tag Info',
            'otp' => 'OTP Setting',
            'otp_info' => 'OTP Setting Info',
            'exchange_rate' => 'Exchange Rate',
            'payment' => 'Payment Setting',
            'payment_info' => 'Payment Info'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'restaurant_status' => [
            'popular' => 'Popular',
            'new' => 'New',
            'promotion' => 'Promotion',
            'high_quality' => 'High quality',
            'no_status' => 'No status',
            'success' => 'Success',
            'error' => 'Error'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel',
            'import' => 'Import'
        ],
        'flash_messages' => [
            'new' => 'Restaurant created!',
            'update' => 'Restaurant updated!',
            'update_top' => 'Success',
            'destroy' => 'Restaurant deleted!',
            'can\'t_destroy' => 'Can not delete because Restaurant is in used',
            'duplicate' => 'Restaurant duplicated!',
            'update_detail' => 'Detail info has been updated!',
            'update_tag' => 'Tag info updated!',
            'update_otp' => 'Otp setting updated!',
            'new_error' => 'Import Restaurant failed!',
            'exchange_rate_error' => 'Exchange Rate failed!',
            'exchange_rate' => 'Exchange Rate updated!',
            'update_intro' => 'Infomation updated!',
        ],
        'maximum_selection' => 'You can only select 3 tags, please remove one tag to reselect'
    ],
    'dishes' => [
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            'status' => 'Status',
            'price' => 'Dishes Price',
            'group' => 'Group',
            'sequence' => 'Sequence'
        ],
        'breadcrumbs' => [
            'new_dish' => 'New Dish',
            'title' => 'Dish',
            'dishes_index' => 'Dish list',
            'edit_dish' => 'Edit dish'
        ],
        'statuses' => [
            'all' => 'All'
        ],
        'dish_status' => [
            'success' => 'Success',
            'error' => 'Error'
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name',
            'category' => 'Category'
        ],
        'forms' => [
            'restaurant' => 'Restaurant',
            'category' => 'Category',
            'choose_restaurant' => 'Choose restaurant',
            'choose_category' => 'Choose category',
            'category_first' => 'Please choose category first',
            'price' => 'Price',
            'customization' => 'Please drag customization on the right menu',
            'group' => 'Group',
            'group_first' => 'Please choose group first'
        ],
        'flash_messages' => [
            'new' => 'Dish created!',
            'update' => 'Dish updated!',
            'destroy' => 'Dish deleted!',
            'can\'t_destroy' => 'Can not delete because Dish is in used',
            'duplicate' => 'Dish duplicated!',
            'change_sequence' => 'Sequence has been changed',
            'change_sequence_error' => 'Something wrong, please try again later!'
        ],
        'not_found' => 'Don\'t have any dishes!',
    ],
    'uploads' => [
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload',
            'file_name' => 'File name',
            'url' => 'URL',
        ],
        'breadcrumbs' => [
            'title' => 'Image List',
            'upload_index' => 'Images Management'
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'add_new' => 'Add New',
            'delete' => 'Delete',
            'close' => 'Close',
            'cancel' => 'Cancel',
        ],
        'flash_messages' => [
            'new' => 'Image created!',
            'update' => 'Image updated!',
            'destroy' => 'Image deleted!',
            'can\'t_destroy' => 'Can not delete because Image is in used'
        ],
    ],
    'categories' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'image' => 'Image',
            'title_en' => 'English Name',
            'title_ja' => 'Japanese Name',
            'status' => 'Status',
            'action' => 'Action',
            'sequence' => 'Sequence'
        ],
        'forms' => [
            'title_en' => 'English name',
            'title_ja' => 'Japanese name',
            'status' => 'Status',
            'active' => 'Active',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'restaurant' => 'Restaurant',
            'image' => 'Image'
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload'
        ],
        'breadcrumbs' => [
            'title' => 'Categories',
            'category_index' => 'Categories list',
            'new_category' => 'New category',
            'data_of_category' => 'Data of category',
            'add_category' => 'Add category',
            'edit_category' => 'Edit category',
            'delete_category' => 'Delete category'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'category_status' => [
            'success' => 'Success',
            'error' => 'Error'
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Category created!',
            'update' => 'Category updated!',
            'destroy' => 'Category deleted!',
            'can\'t_destroy' => 'Can not delete because category is in used',
            'duplicate' => 'Category duplicated!',
            'change_sequence' => 'Sequence has been changed',
            'change_sequence_error' => 'Something wrong, please try again later!'
        ],
        'not_found' => 'Don\'t have any categories!',
    ],
    'customizations' => [
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            'status' => 'Status',
            'price' => 'Customizations Price',
        ],
        'breadcrumbs' => [
            'new_customization' => 'New Customization',
            'title' => 'Customization',
            'customizations_index' => 'Customization list',
            'edit_customization' => 'Edit customization'
        ],
        'statuses' => [
            'all' => 'All'
        ],
        'customization_status' => [
            'success' => 'Success',
            'error' => 'Error'
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            'description_en' => 'English description',
            'description_ja' => 'Japanese description',
            'status' => 'Status',
            'active' => "Active",
            'max_quantity' => "Max quantity",
            'min_quantity' => "Min quantity",
            'selection_type' => 'Selection type',
            'required' => 'Required',
            'has_options' => 'Has Options',
            'radio_yes' => 'Yes',
            'radio_no' => 'No',
            'restaurant' => 'Restaurant',
            'category' => 'Category',
            'choose_restaurant' => 'Choose restaurant',
            'choose_category' => 'Choose category',
            'restaurant_first' => 'Please choose restaurant first',
            'price' => 'Price',
            'quantity_changeable' => 'Allow change quantity'
        ],
        'flash_messages' => [
            'new' => 'Customization created!',
            'update' => 'Customization updated!',
            'destroy' => 'Customization deleted!',
            'can\'t_destroy' => 'Can not delete because Customization is in used'
        ],
        'not_found' => 'Don\'t have any customizations!',
    ],
    'time_base_display_rules' => [
        'breadcrumbs' => [
            'title' => 'Time Base Display Rule',
            'time_base_display_rules_index' => 'Time base display rule list',
            'time_base_display_rules_create' => 'Create time base display rule',
            'time_base_display_rules_update' => 'Edit time base display rule'
        ],
        'search' => [
            'place_holder_text' => 'Search by name...'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'time_base_display_rule_status' => [
            'success' => 'Success',
            'error' => 'Error',
        ],
        'createButton' => 'Create Rules',
        'columns' => [
            'restaurant_id' => 'Restaurant',
            'name' => 'Rule Name',
            'active' => 'Status',
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',
            'period_type' => 'Choose Period Type',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'all_times' => 'Display Base On Time',
            'from_time' => 'From',
            'to_time' => 'To',
            'action' => 'Action',
            'all_days' => 'Choose day in week'
        ],
        'tooltip_title' => [
            'edit' => 'Edit',
            'delete' => 'Delete'
        ],
        'select' => [
            'forever' => 'Forever',
            'specific_period' => 'Specific Period',
            'all_days' => 'All days',
            'specific_days' => 'Specific day',
            'all_time' => 'All time',
            'specific_time' => 'Specific time'
        ],
        'flash_message' => [
            'update' => 'Rules has been updated!',
            'new' => 'Rules has been created!',
            'destroy' => 'Rules has been deleted!',
            'duplicate_success' => 'Selected items have been successfully duplicated',
            'duplicate_error' => 'The items selected duplicated failed',
            'delete_success' => 'Selected items have been successfully deleted',
            'delete_coming_soon' => 'This feature will launch in the future',
            'duplicate' => 'Rule duplicated!'
        ],
        'validation_message' => [
            'at_least_one' => 'You must choose at least one day',
            'from_date' => 'Start day must be after or equal today',
            'to_date' => 'Finish day must be after start day',
            'from_time' => 'Start time must be after current time',
            'to_time' => 'Finish time must be after start time',
        ],
        'detail' => [
            'period' => 'Period',
            'specific_period' => 'Specific period',
            'forever' => 'Forever',
            'from_date' => 'From date',
            'to_date' => 'To date',
            'days_in_week' => 'Days in week',
            'all_days' => 'All days',
            'display_time' => 'Display time',
            'all_times' => 'All time',
            'specific_time' => 'Specific time',
            'from_time' => 'From',
            'to_time' => 'To',
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',

        ],
        'not_found' => 'Don\'t have any rules'
    ],
    'cuisines' => [
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            // 'status' => 'Status',
            'action' => 'Action',
        ],
        'breadcrumbs' => [
            'cuisines_index' => 'Cuisines list',
            'title' => 'Cuisines',
            'new_cuisines' => 'New Cuisine',
            'add_cuisines' => 'Add Cuisine',
            'edit_event' => 'Edit cuisine',
            'delete_event' => 'Delete cuisine',
            'edit_cuisine' => 'Edit Cuisine',
        ],
        'statuses' => [
            'all' => 'All',
            // 'active' => 'Active',
            // 'inactive' => 'Inactive',
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_ja' => 'Japanese name',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel',
        ],
        'flash_messages' => [
            'new' => 'Cuisine created!',
            'update' => 'Cuisine updated!',
            'destroy' => 'Cuisine deleted!',
            'can\'t_destroy' => 'Can not delete because Cuisine is in used'
        ],
        'not_found' => 'Don\'t have any cuisines'
    ],
    'restaurant_work_times' => [
        'search' => [
            'status' => 'Status',
            'restaurants_type' => 'New Blog',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'working_date_en' => 'Working Date',
            'working_date_ja' => 'Working Date Japanese Name',
            'working_time' => 'Working Time',
            'restaurant_id' => 'Restaurant Name',
            'action' => 'Action',
            'opening_hours' => 'Opening Hours',
            'closing_hours' => 'Closing Hours'
        ],
        'forms' => [
            'restaurant_id' => 'Restaurant Name',
            'choose_restaurant' => 'Choose restaurant',
            'working_date_en' => 'Working Date',
            'working_date_ja' => 'Working Date Japanese Name',
            'opening_hours' => 'Opening Hours',
            'closing_hours' => 'Closing Hours',
            'select_option' => 'Choose Day'
        ],
        'breadcrumbs' => [
            'title' => 'Restaurant Working Time',
            'all' => 'All',
            'restaurants_index' => 'Restaurant Working Time list',
            'new_restaurants' => 'New Restaurant Working Time',
            'add_restaurant' => 'Add Restaurant Working Time',
            'edit_restaurant' => 'Edit Restaurant Working Time',
            'delete_restaurants' => 'Delete Restaurant Working Time'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Restaurant Working Time created!',
            'error' => 'You must add more time!',
            'update' => 'Restaurant Working Time updated!',
            'destroy' => 'Restaurant Working Time deleted!',
            'can\'t_destroy' => 'Can not delete because Restaurant Working Time is in used'
        ],
        'not_found' => 'Don\'t have any works time'
    ],
    'restaurants_categories' => [
        'breadcrumbs' => [
            'category_index' => 'Assign Categories to Restaurant',
            'new_category' => 'Assign Categories to Restaurant',
        ]
    ],
//    'restaurants_cuisines' => [
//        'breadcrumbs' => [
//            'cuisine_index' => 'Assign Cuisines to Restaurant',
//            'new_cuisine' => 'Assign Cuisines to Restaurant',
//        ]
//    ],
    'restaurant_delivery_settings' => [
        'breadcrumbs' => [
            'title' => 'Restaurant Delivery Settings',
            'restaurant_delivery_settings_index' => 'Restaurant Delivery Settings List',
            'restaurant_delivery_settings_create' => 'Create Restaurant Delivery Setting',
            'restaurant_delivery_settings_update' => 'Update Restaurant Delivery Setting'
        ],
        'search' => [
            'restaurant_id' => 'Restaurant'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'createButton' => 'Create Restaurant Delivery Settings',
        'columns' => [
            'restaurant_id' => 'Restaurant',
            'district_id' => 'District',
            'ward_id' => 'Ward',
            'from' => 'Total bill from',
            'to' => 'Total bill to',
            'delivery_cost' => 'Delivery cost',
            'min_order_amount' => 'Min order amount',
            'action' => 'Action',
            'time_delivery' => 'Delivery Time',
        ],
        'tooltip_title' => [
            'edit' => 'Edit',
            'delete' => 'Delete'
        ],
        'flash_message' => [
            'update' => 'Restaurant delivery settings has been updated!',
            'error'  => 'Restaurant delivery settings failed! Require: Total bill from less than Total bill to',
            'new' => 'Restaurant delivery settings has been created!',
            'destroy' => 'Restaurant delivery settings has been deleted!',
            'error_delivery_cost' => 'Restaurant delivery settings failed! Require: Delivery Cost, Total bill and Total bill to more than 0'
        ],
        'validation_message' => [
            'delivery_time' => 'Delivery time must be after current time',
        ],
        'not_found' => 'Don\'t have any restaurant delivery settings'
    ],
    'orders' => [
        'search' => [
            'status' => 'Status',
            'restaurants_type' => 'New Blog',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'order_number' => 'Order Number',
            'full_name' => 'Customer Name',
            'phone' => 'Phone',
            'total_amount' => 'Total Amount',
            'restaurant_id' => 'Restaurant Name',
            'payment_method' => 'Payment Method',
            'status' => 'Status',
            'otp_verified' => 'OTP Verified',
            'action' => 'Action'
        ],
        'forms' => [
            'status' => 'Status',
            'choose_status' => 'Choose Status',
            'notes' => 'Notes',
            'reject_reason' => 'Reject reason',
            'opening_hours' => 'Opening Hours',
            'closing_hours' => 'Closing Hours'
        ],
        'breadcrumbs' => [
            'title' => 'Order',
            'all' => 'All',
            'orders_index' => 'Order List',
            'new_order' => 'New Order',
            'add_order' => 'Add Order',
            'edit_order' => 'Edit Order',
            'delete_order' => 'Delete Order',
            'change_status' => 'Change Status',
            'show_order' => 'Order Details'
        ],
        'statuses' => [
            'all' => 'All',
            'new' => 'New',
            'confirmed' => 'Confirmed',
            'admin_accepted' => 'Admin Accepted',
            'finished' => 'Finished',
            'rejected' => 'Rejected',
            'success' => 'Success',
            'received' => 'Received',
            'accepted' => 'Accepted',
            'going' => 'Going',
            'delivered' => 'Delivered',
            'canceled' => 'Canceled',
            'error' => 'Error',
            'payment_fail' => 'Payment Fail'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Order Created!',
            'update' => 'Order Updated!',
            'destroy' => 'Order Deleted!',
            'can\'t_destroy' => 'Can not delete because order is in used'
        ],
        'not_found' => 'Don\'t have any order!',
    ],
    'restaurants_cuisines' => [
        'breadcrumbs' => [
            'title' => 'Assign Cuisines to Restaurant',
            'cuisines_index' => 'Cuisines list',
            'cuisine_index' => 'Assign Cuisines to Restaurant',
            'new_cuisine' => 'Add Assign Cuisines to Restaurant',
            'edit_cuisine' => 'Edit Assign Cuisines to Restaurant',
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            // 'status' => 'Status',
            'action' => 'Action',
        ],
        'statuses' => [
            'all' => 'All',
            // 'active' => 'Active',
            // 'inactive' => 'Inactive',
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_ja' => 'Japanese name',
            'restaurant' => 'Choose restaurant',
            'cuisines' => 'Choose cuisines'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel',
            'assign' => 'Assign'
        ],
        'flash_messages' => [
            'new' => 'Assign Cuisines to Restaurant created!',
            'update' => 'Assign Cuisines to Restaurant updated!',
            'destroy' => 'Assign Cuisines to Restaurant deleted!',
            'can\'t_destroy' => 'Can not delete because Cuisines to Restaurant is in used'
        ],
        'not_found' => 'Don\'t have any Cuisines to Restaurant'
    ],
    'tags' => [
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            'type' => 'Type',
            'action' => 'Action',
        ],
        'breadcrumbs' => [
            'tags_index' => 'Tag list',
            'title' => 'Tags',
            'new_tags' => 'New Tag',
            'add_tags' => 'Add Tag',
            'edit_event' => 'Edit tag',
            'delete_event' => 'Delete tag',
            'edit_tags' => 'Edit tag',
        ],
        'statuses' => [
            'all' => 'All',
            // 'active' => 'Active',
            // 'inactive' => 'Inactive',
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_ja' => 'Japanese name',
            'type' => 'Type',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel',
        ],
        'flash_messages' => [
            'new' => 'Tag created!',
            'update' => 'Tag updated!',
            'destroy' => 'Tag deleted!',
            'can\'t_destroy' => 'Can not delete because Tag is in used',
            'duplicate' => 'Tag duplicated!'
        ],
        'not_found' => 'Don\'t have any Tags'
    ],
    'order_reject_reason' => [
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japanese Name',
            'type' => 'Type',
            'action' => 'Action',
        ],
        'breadcrumbs' => [
            'order_reject_reason_index' => 'reject reason list',
            'title' => 'Order reject reason',
            'new_order_reject_reason' => 'New reject reason',
            'add_order_reject_reason' => 'Add reject reason',
            'edit_event' => 'Edit reject reason',
            'delete_event' => 'Delete reject reason',
            'edit_order_reject_reason' => 'Edit reject reason',
        ],
        'statuses' => [
            'all' => 'All',
            // 'active' => 'Active',
            // 'inactive' => 'Inactive',
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_ja' => 'Japanese name',
            'type' => 'Type',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel',
        ],
        'flash_messages' => [
            'new' => 'reject reason created!',
            'update' => 'reject reason updated!',
            'destroy' => 'reject reason reasong deleted!',
            'can\'t_destroy' => 'Can not delete because reject reason is in used',
            'duplicate' => 'Tareject reasong duplicated!'
        ],
        'not_found' => 'Don\'t have any reject reason'
    ],
    'time_base_pricing_rules' => [
        'breadcrumbs' => [
            'title' => 'Time Base Pricing Rule',
            'time_base_pricing_rules_index' => 'Time base pricing rule list',
            'time_base_pricing_rules_create' => 'Create time base pricing rule',
            'time_base_pricing_rules_update' => 'Edit time base pricing rule'
        ],
        'search' => [
            'place_holder_text' => 'Search by name...'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'time_base_pricing_rule_status' => [
            'success' => 'Success',
            'error' => 'Error'
        ],
        'createButton' => 'Create Rules',
        'columns' => [
            'restaurant_id' => 'Restaurant',
            'name' => 'Rule Name',
            'active' => 'Status',
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',
            'period_type' => 'Choose Period Type',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'all_times' => 'Display Base On Time',
            'from_time' => 'From',
            'to_time' => 'To',
            'action' => 'Action',
            'all_days' => 'Choose day in week',
            'type' => 'Choose type',
            'value' => 'Value',
            'inscrease' => 'Direction'
        ],
        'tooltip_title' => [
            'edit' => 'Edit',
            'delete' => 'Delete'
        ],
        'select' => [
            'forever' => 'Forever',
            'specific_period' => 'Specific Period',
            'all_days' => 'All days',
            'specific_days' => 'Specific day',
            'all_time' => 'All time',
            'specific_time' => 'Specific time',
            'percent' => 'By Percent',
            'price' => 'By Price',
            'increase' => 'Increase',
            'decrease' => 'Decrease'
        ],
        'flash_message' => [
            'update' => 'Rules has been updated!',
            'new' => 'Rules has been created!',
            'destroy' => 'Rules has been deleted!',
            'duplicate_success' => 'Selected items have been successfully duplicated',
            'duplicate_error' => 'The items selected duplicated failed',
            'delete_success' => 'Selected items have been successfully deleted',
            'delete_coming_soon' => 'This feature will launch in the future',
            'duplicate' => 'Rule duplicated!'
        ],
        'validation_message' => [
            'at_least_one' => 'You must choose at least one day',
            'from_date' => 'Start day must be after or equal today',
            'to_date' => 'Finish day must be after start day',
            'from_time' => 'Start time must be after current time',
            'to_time' => 'Finish time must be after start time',
            'percent_value' => 'Percent value can\' greater than 100'
        ],
        'detail' => [
            'period' => 'Period',
            'specific_period' => 'Specific period',
            'forever' => 'Forever',
            'from_date' => 'From date',
            'to_date' => 'To date',
            'days_in_week' => 'Days in week',
            'all_days' => 'All days',
            'display_time' => 'Display time',
            'all_times' => 'All time',
            'specific_time' => 'Specific time',
            'from_time' => 'From',
            'to_time' => 'To',
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',
            'type' => 'Choose type',
            'value' => 'Value',
            'percent' => 'By percent',
            'price' => 'By price'
        ],
        'not_found' => 'Don\'t have any rules'
    ],
    'groups' => [
        'columns' => [
            'name' => 'Name',
            'status' => 'Status',
        ],
        'breadcrumbs' => [
            'new_group' => 'New Group',
            'title' => 'Group',
            'groups_index' => 'Group list',
            'edit_group' => 'Edit group'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive'
        ],
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name'
        ],
        'forms' => [
            'restaurant' => 'Restaurant',
            'customization' => 'Please drag customization on the right menu',
            'name' => 'Name',
            'status' => 'Status',
            'active' => 'Active'
        ],
        'flash_messages' => [
            'new' => 'Group created!',
            'update' => 'Group updated!',
            'destroy' => 'Group deleted!',
            'can\'t_destroy' => 'Can not delete because Group is in used'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel',
        ],
    ],
    'intro' => [
        'breadcrumbs' => [
            'intros' => 'Infomation',
            'intro_detail' => 'Detail Infomation'
        ],
        'form' => [
            'intro' => 'Infomation'
        ]
    ],
    'taxes' => [
        'breadcrumbs' => [
            'tax_info' => 'Tax Info',
            'tax_detail' => 'Tax Detail Info'
        ],
        'forms' => [
            'type' => 'Type',
            'rate' => 'Rate',
            'inclusive' => 'Inclusive',
            'exclusive' => 'Exclusive'
        ],
        'flash_messages' => [
            'create' => 'Tax info has been created!',
            'update' => 'Tax info has been updated!',
        ],
    ],
    'contacts' => [
        'breadcrumbs' => [
            'title' => 'Contacts',
            'contacts_index' => 'Contacts List',
            'show_event' => 'View',
            'delete_event' => 'Delete',
            'show_contact' => 'Contact Detail',
        ],
        'columns' => [
            'name' => 'Name',
            'title' => 'Title',
            'email' => 'Email',
            'phone' => 'Phone',
            'action' => 'Action',
        ],
        'forms' => [
            'exclusive' => 'Exclusive'
        ],
        'flash_messages' => [
            'destroy' => 'Contact deleted!',
        ],
    ],
    'printers' => [
        'search' => [
            'status' => 'Status',
            'restaurant' => 'Restaurant',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name' => 'Name',
            'restaurant' => 'Restaurant',
            'status' => 'Status',
            'action' => 'Action',
        ],
        'forms' => [
            'name' => 'Name',
            'printer_status' => 'Status',
            'restaurant' => 'Restaurant',
            'check_interval' => 'Time Check Interval',
            'token' => 'Token',
            'page_header' => 'Page Header',
            'page_footer' => 'Page Footer',
            'auto_print' => 'Auto Print',
            'reject_reason' => 'Reject Reason',
            'ip' => 'IP or Domain Name',
            'port' => 'Port',
            'polling_url' => 'Polling URL',
            'callback_url' => 'Callback URL',
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload'
        ],
        'breadcrumbs' => [
            'title' => 'Printers',
            'printer_index' => 'Printers list',
            'new_printer' => 'New printer',
            'data_of_printer' => 'Data of printer',
            'add_printer' => 'Add printer',
            'edit_printer' => 'Edit printer',
            'delete_printer' => 'Delete printer',
            'save_printer' => 'Export ini file'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'printer_status' => [
            'success' => 'Success',
            'error' => 'Error'
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Printer created!',
            'update' => 'Printer updated!',
            'destroy' => 'Printer deleted!',
            'can\'t_destroy' => 'Can not delete because printer is in used',
            'duplicate' => 'printer duplicated!',
            'change_sequence_error' => 'Something wrong, please try again later!'
        ],
        'not_found' => 'Don\'t have any printers!',
    ],
    'reports' => [
        'sale' => [
            'breadcrumbs' => [
                'title' => 'Sale Report',
                'sale_index' => 'Report',
            ]
        ],
        'invoice' => [
            'breadcrumbs' => [
                'title' => 'Invoice Report',
                'invoice_index' => 'Report',
            ]
        ]
    ],
    'promotions' => [
        'search' => [
            'status' => 'Status',
            'restaurant' => 'Restaurant',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japan Name',
            'restaurant' => 'Restaurant',
            'code' => 'Code',
            'status' => 'Status',
            'action' => 'Action',
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_ja' => 'Japan Name',
            'description_en' => 'English Description',
            'description_ja' => 'Japan Description',
            'promotion_code' => 'Promotion Code',
            'is_global' => 'Global',
            'value' => 'Value',
            'free_item' => 'Free Item',
            'created_by' => 'Created By',
            'maximun_discount' => 'Maximum Discount',
            'number_usage' => 'Number Usage',
            'apply_to' => 'Apply To',
            'min_order_value' => 'Sub Total From',
            'max_order_value' => 'Sub Total To',
            'item_value_from' => 'Item Value From',
            'item_value_to' => 'Item Value To',
            'active' => 'Active',
            'restaurant' => 'Restaurant',
            'dish' => 'Dish',
            'category' => 'Category',
            'image' => 'Image',
            'include_request' => 'Include Request'
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload'
        ],
        'breadcrumbs' => [
            'title' => '{1} Promotions|{0} Vouchers',
            'promotion_index' => '{1} Promotions list|{0} Vouchers list',
            'new_promotion' => '{1} New promotion|{0} New voucher',
            'data_of_promotion' => '{1} Data of promotion|{0} Data of voucher',
            'add_promotion' => '{1} Add promotion|{0} Add voucher',
            'edit_promotion' => '{1} Edit promotion|{0} Edit voucher',
            'delete_promotion' => '{1} Delete promotion|{0} Delete voucher',
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'Promotion_status' => [
            'success' => 'Success',
            'error' => 'Error'
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => '{1} Promotion created!|{0} Voucher created!',
            'update' => '{1} Promotion updated!|{0} Voucher updated!',
            'destroy' => '{1} Promotion deleted!|{0} Voucher deleted!',
            'can\'t_destroy' => '{1} Can not delete because promotion is in used|{0} Can not delete because voucher is in used',
            'duplicate' => '{1} Promotion duplicated!|{0} Voucher duplicated!',
            'change_sequence_error' => 'Something wrong, please try again later!'
        ],
        'not_found' => '{1} Don\'t have any promotions!|{0} Don\'t have any vouchers!',
    ],
    'reviews' => [
        'search' => [
            'status' => 'Status',
            'restaurants_type' => 'New Blog',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
        ],
        'columns' => [
            'order_number' => 'Order Number',
            'full_name' => 'Customer Name',
            'comment' => 'Comment',
            'id' => '#',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'status' => 'Status',
        ],
        'breadcrumbs' => [
            'title' => 'Review',
            'all' => 'All',
            'reviews_index' => 'Reviews List',
            'new_review' => 'New Review',
            'add_review' => 'Add Review',
            'edit_review' => 'Edit Review',
            'delete_review' => 'Delete Review',
            'change_status' => 'Change Status',
            'show_review' => 'Review Details'
        ],
        'statuses' => [
            'all' => 'All',
            'new' => 'New',
            'received' => 'Received',
            'confirmed' => 'Confirmed',
            'solved' => 'Solved',
            'reported' => 'Reported',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Review Created!',
            'update' => 'Review Updated!',
            'destroy' => 'Review Deleted!',
            'can\'t_destroy' => 'Can not delete because review is in used'
        ],
        'not_found' => 'Don\'t have any review!',
    ],
    'commission_rules' => [
        'columns' => [
            'level' => 'Level',
            'total_from' => 'Total From',
            'total_to' => 'Total To',
            'rate' => 'Rate',
            'action' => 'Action',
        ],
        'forms' => [
            'level' => 'Level',
            'total_from' => 'Total From',
            'total_to' => 'Total To',
            'rate' => 'Rate',
        ],
        'createBtn' => 'Create Commission Rule',
        'breadcrumbs' => [
            'title' => 'Commission Rules',
            'commission_index' => 'Commission rules list',
            'add_commission' => 'Create commission rule',
            'edit_commission' => 'Update commission rule',
        ],
        'flash_messages' => [
            'new' => 'Commission rule created!',
            'update' => 'Commission rule updated!',
            'destroy' => 'Commission rule deleted!',
        ],
        'not_found' => 'Don\'t have any rules!',
    ],
];
