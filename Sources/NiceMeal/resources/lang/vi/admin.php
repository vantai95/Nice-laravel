<?php

return [
    'confirm' => [
        'delete' => [
            'text' => 'Bạn có chắc chắn muốn xóa dữ liệu?',
            'confirm_button' => 'Có',
            'cancel_button' => 'Hủy Bỏ'
        ],
        'duplicate' => [
            'text' => 'Bạn có muốn sao chép dữ liệu này?'
        ]
    ],
    'day_name' => [
        'sun' => 'Chủ nhật',
        'mon' => 'Thứ 2',
        'tue' => 'Thứ 3',
        'wed' => 'Thứ 4',
        'thu' => 'Thứ 5',
        'fri' => 'Thứ 6',
        'sat' => 'Thứ 7'
    ],
    'tooltip_title' => [
        'edit' => 'Chỉnh Sửa ',
        'delete' => 'Xóa',
        'duplicate' => 'Sao chép',
        'change_sequence' => 'Kéo thả để thay đổi thứ tự'
    ],
    'buttons' => [
        'create' => 'Tạo mới',
        'update' => 'Cập nhật',
        'edit' => 'Chỉnh sửa',
        'cancel' => 'Huỷ',
        'upload' => 'Chọn Ảnh',
        'save_change' => 'Lưu Thay Đổi',
        'back' => 'Quay lại'
    ],
    'layouts' => [
        'header' => [
            'logout' => 'Đăng Xuất',
            'my_profile' => 'Hồ sơ của tôi'
        ],
        'aside_left' => [
            'group' => [
                'staff' => 'Nhân Viên',
                'customer' => 'Khách Hàng',
                'restaurant' => 'Nhà Hàng',
                'menu' => 'Thực Đơn',
                'service' => 'Dịch vụ',
                'orders' =>'Quản lý đơn hàng',
                'configuration' => 'Cấu hình',
                'rule' => 'Tiêu Chí',
                'general_info' => 'Thông tin chung',
                'printers' => 'Máy In',
                'report' => 'Báo cáo',
                'vouchers' => 'Vouchers',
                'promotions' => 'Promotions'

            ],
            'section' => [
                'events' => 'Sự Kiện',
                'galleries' => 'Thư Viện',
                'sequence' => 'Đổi Thứ Tự'
            ],
            'menu' => [
                'staff' => [
                    'staff' => 'Nhân Viên',
                    'users' => 'Người Dùng',
                    'uploads' => 'Uploads',
                    'galleries' => 'Thư Viện Ảnh',
                    'departments' => 'Vị Trí',
                    'employees' => 'Nhân Viên',
                    'roles' => 'Roles',
                    'permissions' => 'Permissions'
                ],
                'customer' => [
                    'customer' => 'Khách hàng',
                    'address_info' => 'Danh sách địa chỉ'
                ],
                'restaurant' => [
                    'categories' => 'Categories',
                    'restaurants_categories' => 'Tạo Categories cho Nhà Hàng',
                    'cuisines' => 'Nghệ Thuật Ẩm Thực',  
                    'tags' => 'Tags',              
                    'order_reject_reason' => 'Reject Reason',
                    'restaurants_cuisines' => 'Thêm Nghệ Thuật Ẩm Thực cho Nhà Hàng',
                    'restaurants' => 'Danh sách nhà hàng',
                    'deliveries' => 'Giao Nhận',
                    'working_times' => 'Giờ làm việc',
                ],
                'dishes' => [
                    'dishes' => 'Món ăn',
                    'customization' => 'Yêu Cầu',
                    'time_base_display' => 'Thời gian hiển thị',
                    'time_base_pricing' => 'Thời gian hiển thị theo giá cả',
                ],
                'orders' =>'Quản lý đơn hàng',
                'general_info' => [
                    'detail_info' => 'Thông tin chi tiết',
                    'tax' => 'Thuế',
                    'tags' => 'Thẻ',
                    'otp_setting' => 'Thiết lập OTP'
                ],
                'printers' =>'Quản lý máy in',
                'reports' => [
                    'sales' => 'Bán hàng',
                    'invoices' => 'Hóa đơn'
                ],
                'rules' => [
                    'commission' => 'Quy định hoa hồng',
                    'order_reject_reason' => 'Lí do hủy đơn hàng'
                ]
            ],
        ],
        'breadcrumbs' => [
            'change_sequence' => 'Thay đổi thứ tự'
        ]
    ],
    'users' => [
        'search' => [
            'status' => 'Trạng thái',
            'role' => 'Quyền',
            'place_holder_text' => 'Tìm theo tên và email...'
        ],
        'title' => [
            "details" => 'Thông tin cá nhân',
            "role" => 'Quyền hạn',
            'update_profile' => 'Cập nhật hồ sơ',
            'message' => 'Tin nhắn',
            'settings' => 'Cài đặt'
        ],
        'columns' => [
            'full_name' => 'Họ Tên',
            'email' => 'Email',
            'phone' => 'Số Điện Thoại',
            'dob' => 'Ngày Sinh',
            'address' => 'Địa Chỉ',
            'role' => 'Quyền',
            'locked' => 'Khóa',
            'status' => 'Trạng Thái',
            'action' => 'Tùy Chọn',
            'restaurant' => 'Nhà Hàng',
            'select_restaurant' => 'Chọn nhà hàng',
        ],
        'breadcrumbs' => [
            'title' => 'Người dùng',
            'user_index' => 'Danh sách người dùng',
            'my_profile' => 'Hồ sơ của tôi'
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            'locked' => 'Khóa',
            'active' => 'Hoạt Động'
        ],
        'roles' => [
            'all' => 'Tất Cả',
            'select_role' => 'Chọn Quyền',
            'user' => 'Nhà Hàng',
            'admin' => 'Quản Trị',
            'customer' => 'Thực Khách'
        ],
        'not_found' => 'Không tìm thấy người dùng!'
    ],
    'restaurants' => [
        'search' => [
            'status' => 'Trạng thái',
            'restaurants_type' => 'Blog mới',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hoặc click vào để đăng tải'
        ],
        'columns' => [
            'res_id' => 'ID Nhà Hàng',
            'name_en' => 'Tên Tiếng Anh',
            'name_ja' => 'Tên Tiếng Nhật',
            'news_type' => 'News Restaurant',
            'status' => 'Trạng Thái',
            'action' => 'Tùy Chọn',
            'image' => 'Hình',
            'vip' => 'VIP'
        ],
        'forms' => [
            'news_type' => 'New Restaurant',
            'name_en' => 'Tên tiếng anh',
            'name_ja' => 'Tên tiếng nhật',
            'highlight_label_en' => 'English Highlight label',
            'highlight_label_ja' => 'Japanese Highlight label',
            'title_brief_en' => 'Tiêu đề tóm tắt tiếng Anh',
            'title_brief_ja' => 'Tiêu đề tóm tắt tiếng Nhật',
            'description_en' => 'Mô tả tiếng Anh',
            'description_ja' => 'Mô tả tiếng Nhật',
            'address_en' => 'Địa chỉ tiếng Anh',
            'address_ja' => 'Địa chỉ tiếng Nhật',
            'province_id' => 'Tỉnh',
            'province' => 'Tỉnh',
            'district' => 'Quận',
            'district_id' => 'Quận',
            'ward_id' => 'Phường',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'banner' => 'Banner',
            'image' => 'Hình',
            'review_rate' => 'Review rate',
            'otp' => 'Otp',
            'otp_value' => 'Giá trị Otp',
            'status' => 'Trạng thái',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'online_payment' => 'Thanh toán trực tuyến',
            'cod_payment' => 'Thanh toán COD',
            'delivery' => 'Giao hàng',
            'pickup' => 'Đến nhận',
            'active' => 'Active',
            'slug' => 'Slug',
            'choose_province' => 'Chọn Tỉnh',
            'choose_district' => 'Chọn Quận',
            'choose_ward' => 'Chọn Phường',
            'choose_status' => 'Chọn Trạng Thái',
            'ward' => 'Phường',
            'vip_restaurant' => 'Vip Restaurant',
            'tags' => 'Tags',
            'choose_tags' => 'Choose Tags',
            'address' => 'Địa chỉ',
            'published' => 'Published',
            'file_import' => 'File Import',
            'choose_online_payment' => 'Bạn nên chọn ít nhất 1 loại thanh toán!',
        ],
        'detail_info' => [
            'res_id' => 'Restaurant ID',
            'restaurant_name' => 'Tên Nhà Hàng',
            'restaurant_address' => 'Địa Chỉ Nhà Hàng',
            'restaurant_phone' => 'Số Điện Thoại Nhà Hàng',
            'restaurant_email' => 'Email Nhà Hàng',
            'restaurant_link' => 'Website Nhà Hàng',
            'owner_name' => 'Tên Người Sỡ Hũu',
            'owner_phone' => 'Số Điện Thoại Người Sỡ Hữu',
            'owner_email' => 'Email Người Sỡ Hữu',
            'delivery_setting' => 'Thiết Lập Giao Hàng',
            'payment_setting' => 'Thiết Lập Thanh Toán',
            'maximum_discount' => 'Mức giảm giá tối đa',
            'active' => 'Active',
            'setting' => 'Thiết lập',
            'paypal' => 'Paypal',
            'ngan_luong' => 'Ngân Lượng',
            'no_setting' => 'Không thiết lập',
        ],
        'form_title' => [
            'detail' => 'Thông tin chi tiết',
            'owner_detail' => 'Thông tin người sỡ hữu',
            'res_work_time' => 'Giờ làm việc của nhà hàng',
            'res_delivery' => 'Thông tin giao hàng của nhà hàng',
            'location' => 'Địa điểm',
            'minimum' => 'Giá tối thiểu',
            'fee' => 'Phí',
            'exchange_rate' => 'Tỉ giá'
        ],
        'breadcrumbs' => [
            'title' => 'Nhà hàng',
            'restaurants_type' => 'Loại nhà hàng',
            'all' => 'Tất cả',
            'restaurants_index' => 'Danh sách nhà hàng',
            'new_restaurants' => 'Nhà hàng mới',
            'data_of_restaurants' => 'Dữ liệu nhà hàng',
            'add_restaurant' => 'Thêm nhà hàng',
            'edit_restaurant' => 'Chỉnh sửa nhà hàng',
            'delete_restaurants' => 'Xóa nhà hàng',
            'detail_info' => 'Thông tin chi tiết nhà hàng',
            'general_info' => 'Thông tin chung nhà hàng',
            'tags' => 'Thẻ',
            'tag_info' => 'Thông tin thẻ',
            'otp' => 'Thiết lập OTP',
            'otp_info' => 'Thông tin thiết lập OTP',
            'payment' => 'Thiết lập thanh toán',
            'payment_info' => 'Thông tin thanh toán',
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động',
        ],
        'restaurant_status' => [
            'popular' => 'Phổ biến',
            'new' => 'Mới',
            'promotion' => 'Khuyến mãi',
            'high quality' => 'Chất lượng cao',
            'no status' => 'Không có trạng thái',
            'success' => 'Thành công',
            'error' => 'Lỗi'
        ],
        'buttons' => [
            'create' => 'Tạo',
            'update' => 'Cập nhật',
            'cancel' => 'Hủy bỏ'
        ],
        'flash_messages' => [
            'new' => 'Nhà hàng đã được tạo!',
            'update' => 'Nhà hàng đã được cập nhật!',
            'destroy' => 'Nhà hàng đã được xóa!',
            'can\'t_destroy' => 'Không thể xóa vì nhà hàng đang được sử dụng',
            'duplicate' => 'Đã sao chép nhà hàng!',
            'update_detail' => 'Thông tin chi tiết nhà hàng đã được cập nhật!',
            'update_tag' => 'Thông tin thẻ được cập nhật!',
            'update_otp' => 'Thiết lập Otp đã được cập nhật!',
            'exchange_rate_error' => 'Tỉ giá cập nhật thất bại!',
            'exchange_rate' => 'Tỉ giá cập nhật thành công!',
            'update_intro' => 'Giới thiệu nhà hàng được cập nhật!',
        ],
        'maximum_selection' => 'Bạn chỉ được phép chọn 3 thẻ, vui lòng bỏ một thẻ để chọn lại'
    ],
    'dishes' => [
        'columns' => [
            'name_en' => 'Tên tiếng anh',
            'name_ja' => 'Tên tiếng nhật',
            'status' => 'Trạng thái',
            'price' => 'Giá',
            'group' => 'Nhóm',
            'sequence' => 'Thứ Tự'
        ],
        'breadcrumbs' => [
            'new_dish' => 'Thêm món ăn mới',
            'title' => 'Món ăn',
            'dishes_index' => 'Danh sách món ăn',
            'edit_dish' => 'Sửa món ăn'
        ],
        'statuses' => [
            'all' => 'Tất cả'
        ],
        'dish_status' => [
            'success' => 'Thành công',
            'error' => 'Lỗi'
        ],
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên',
            'category' => 'Category'
        ],
        'forms' => [
            'restaurant' => 'Nhà hàng',
            'category' => 'Phân loại',
            'choose_restaurant' => 'Chọn nhà hàng',
            'choose_category' => 'Chọn loại thức ăn',
            'restaurant_first' => 'Vui lòng chọn nhà hàng trước',
            'price' => 'Giá',
            'customization' => 'Vui lòng chọn customization bên menu bên phải'
        ],
        'flash_messages' => [
            'new' => 'Món ăn mới đã được tạo!',
            'update' => 'Đã cập nhật món ăn!',
            'destroy' => 'Món ăn đã bị xóa!',
            'can\'t_destroy' => 'Không thể xóa món ăn',
            'duplicate' => 'Món ăn đã được sao chép!',
            'change_sequence' => 'Thứ tự đã được thay đổi',
            'change_sequence_error' => 'Có lỗi, vui lòng thử lại sau!'
        ],
        'not_found' => 'Không tìm thấy món ăn!',
    ],
    'uploads' => [
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hoặc click vào để đăng tải',
            'file_name' => 'Tên file',
            'url' => 'URL',
        ],
        'breadcrumbs' => [
            'title' => 'Danh sách hình ảnh',
            'upload_index' => 'Quản lý hình ảnh'
        ],
        'buttons' => [
            'create' => 'Tạo mới',
            'upgrate' => 'Cập nhật',
            'add_new' => 'Tạo mới',
            'delete' => 'Xóa',
            'close' => 'Đóng',
            'cancel' => 'Hủy',
        ],
        'flash_messages' => [
            'new' => 'Hình ảnh đã được tạo!',
            'update' => 'Hình ảnh đã được cập nhật!',
            'destroy' => 'Đã xóa hình ảnh!',
            'can\'t_destroy' => 'Không thể xóa vì hình ảnh đang được sử dụng'
        ],
    ],
    'customizations' => [
        'columns' => [
            'name_en' => 'Tên tiếng anh',
            'name_ja' => 'Tên tiếng nhật',
            'status' => 'Trạng thái',
            'price' => 'Giá',
        ],
        'breadcrumbs' => [
            'new_customization' => 'Customization mới',
            'title' => 'Customization',
            'customizations_index' => 'Danh sách customization',
            'edit_customization' => 'Chỉnh sửa customization'
        ],
        'statuses' => [
            'all' => 'Tất cả'
        ],
        'customization_status' => [
            'success' => 'Thành công',
            'error' => 'Lỗi'
        ],
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'forms' => [
            'restaurant' => 'Nhà hàng',
            'category' => 'Danh mục',
            'choose_restaurant' => 'Chọn nhà hàng',
            'choose_category' => 'Chọn danh mục',
            'restaurant_first' => 'Vui lòng chọn nhà hàng trước',
            'price' => 'Giá cả',
            'quantity_changeable' => 'Cho phép đổi số lương'
        ],
        'flash_messages' => [
            'new' => 'Customization đã đươc tạo!',
            'update' => 'Customization đã đươc câp nhật!',
            'destroy' => 'Customization đã đươc xóa!',
            'can\'t_destroy' => 'Không thể xóa vì customization đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy tùy chỉnh!',
    ],
    'categories' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'columns' => [
            'image' => 'Hình ảnh',
            'title_en' => 'Tên Tiếng Anh',
            'title_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'sequence' => 'Thứ Tự'
        ],
        'forms' => [
            'title_en' => 'Tên Tiếng Anh',
            'title_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động',
            'restaurant' => 'Nhà hàng',
            'image' => 'Hình ảnh'
        ],
        'text' => [
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'breadcrumbs' => [
            'title' => 'Danh mục',
            'category_index' => 'Danh sách danh mục',
            'new_category' => 'Danh mục mới',
            'data_of_category' => 'Dữ liệu danh mục',
            'add_category' => 'Thêm danh mục',
            'edit_category' => 'Chỉnh sửa danh mục',
            'delete_category' => 'Xóa danh mục'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'category_status' => [
            'success' => 'Thành công',
            'error' => 'Lỗi'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm danh mục!',
            'update' => 'Đã cập nhật danh mục!',
            'destroy' => 'Đã xóa danh mục!',
            'can\'t_destroy' => 'Không thể xóa vì danh mục đang được sử dụng',
            'duplicate' => 'Danh mục đã được sao chép!',
            'change_sequence' => 'Thứ tự đã được thay đổi',
            'change_sequence_error' => 'Có lỗi, vui lòng thử lại sau!'
        ],
        'not_found' => 'Không tìm thấy danh mục!',
    ],
    'time_base_display_rules' => [
        'breadcrumbs' => [
            'title' => 'Quy định thời gian hiển thị',
            'time_base_display_rules_index' => 'Danh sách quy định thời gian hiển thị',
            'time_base_display_rules_create' => 'Tạo mới quy định thời gian hiển thị',
            'time_base_display_rules_update' => 'Chỉnh sửa quy định thời gian hiển thị'
        ],
        'search' => [
            'place_holder_text' => 'Tìm kiếm theo tên...'
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            'active' => 'Hoạt Động',
            'inactive' => 'Ngưng Hoạt Động',
        ],
        'time_base_display_rule_status' => [
            'success' => 'Thành công',
            'error' => 'Thành công',
        ],
        'createButton' => 'Tạo Mới Quy Định',
        'columns' => [
            'restaurant_id' => 'Nhà Hàng',
            'name' => 'Tên Quy Định',
            'active' => 'Tình Trạng',
            'mon' => 'Thứ 2',
            'tue' => 'Thứ 3',
            'wed' => 'Thứ 4',
            'thu' => 'Thứ 5',
            'fri' => 'Thứ 6',
            'sat' => 'Thứ 7',
            'sun' => 'Chủ Nhật',
            'period_type' => 'Cách hiển thị',
            'from_date' => 'Từ Ngày',
            'to_date' => 'Đến Ngày',
            'all_times' => 'Cách hiển thị theo giờ',
            'from_time' => 'Từ',
            'to_time' => 'Đến',
            'action' => 'Tùy Chọn',
            'all_days' => 'Chọn ngày trong tuần' 
        ],
        'tooltip_title' => [
            'edit' => 'Chỉnh sửa',
            'delete' => 'Xóa'
        ],
        'select' => [
            'forever' => 'Mãi Mãi',
            'specific_period' => 'Khoảng thời gian cố định',
            'all_days' => 'Tất cả các ngày',
            'specific_days' => 'Chọn ngày cụ thể',
            'all_time' => 'Tất cả các giờ',
            'specific_time' => 'Chọn giờ cụ thể'
        ],
        'flash_message' => [
            'update' => 'Quy định đã được cập nhật!',
            'new' => 'Quy định đã được tạo!',
            'destroy' => 'Quy định đã xóa!',
            'duplicate' => 'Quy định đã được sao chép!'
        ],
        'validation_message' => [
            'at_least_one' => 'Bạn phải chọn ít nhất một ngày',
            'from_date' => 'Ngày bắt đầu phải sau hoặc bằng ngày hiện tại',
            'to_date' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'from_time' => 'Giờ bắt đầu phải sau giờ hiện tại',
            'to_time' => 'Giờ kết thúc phải sau giờ bắt đầu',
        ],
        'detail' => [
            'period' => 'Khoảng thời gian',
            'specific_period' => 'Khoảng thời gian cụ thể',
            'forever' => 'Mãi mãi',
            'from_date' => 'Từ ngày',
            'to_date' => 'Đến ngày',
            'days_in_week' => 'Ngày trong tuần',
            'all_days' => 'Tất cả các ngày',
            'display_time' => 'Thời gian',
            'all_times' => 'Tất cả khoảng thời gian',
            'specific_time' => 'Thời gian cụ thể',
            'from_time' => 'Từ',
            'to_time' => 'Đến',
            'mon' => 'Thứ 2',
            'tue' => 'Thứ 3',
            'wed' => 'Thứ 4',
            'thu' => 'Thứ 5',
            'fri' => 'Thứ 6',
            'sat' => 'Thứ 7',
            'sun' => 'Chủ Nhật',
        ],
        'not_found' => 'Không tìm thấy quy định!'
    ],
    'cuisines' => [
        'columns' => [
            'name_en' => 'Tên tiếng anh',
            'name_ja' => 'Tên tiếng nhật',
            // 'status' => 'Trạng thái',
            'action' => 'Tùy Chọn',
        ],
        'breadcrumbs' => [
            'cuisines_index' => 'Danh sách Nghệ thuật ẩm thực',
            'title' => 'Nghệ Thuật Ẩm Thực',
            'new_cuisines' => 'Thêm Nghệ thuật ẩm thực mới',
            'add_cuisines' => 'Thêm Nghệ thuật ẩm thực mới',
            'edit_event' => 'Chỉnh sửa Nghệ thuật ẩm thực',
            'delete_event' => 'Xóa Nghệ thuật ẩm thực',
            'edit_cuisine' => 'Chỉnh sửa Nghệ thuật ẩm thực',
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            // 'active' => 'Khóa',
            // 'inactive' => 'Hoạt Động',
        ],
        'search' => [
            // 'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên'
        ],
        'forms' => [
            'name_en' => 'Tên tiếng anh',
            'name_ja' => 'Tên tiếng nhật',
        ],
        'buttons' => [
            'create' => 'Tạo mới',
            'update' => 'Cập nhật',
            'cancel' => 'Huỷ',
        ],
        'flash_messages' => [
            'new' => 'Nghệ thuật ẩm thực đã được tạo!',
            'update' => 'Nghệ thuật ẩm thực đã được cập nhật!',
            'destroy' => 'Nghệ thuật ẩm thực đã xoá!',
            'can\'t_destroy' => 'Không thể xóa vì Nghệ thuật ẩm thực đã được sử dụng'
        ],
        'not_found' =>'Không có dữ liệu'
    ],
    'restaurant_work_times' => [
        'search' => [
            'status' => 'Trạng thái',
            'restaurants_type' => 'New Blog',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'working_date_en' => 'Ngày làm việc',
            'working_date_ja' => 'Ngày làm việc',
            'working_time' => 'Thời gian làm việc',
            'restaurant_id' => 'Tên nhà hàng',
            'action' => 'Action',
            'opening_hours' => 'Giờ mở cửa',
            'closing_hours' => 'Giờ đóng cửa'
        ],
        'forms' => [
            'restaurant_id' => 'Restaurant Name',
            'choose_restaurant' => 'Choose restaurant',
            'working_date_en' => 'Ngày làm việc',
            'working_date_ja' => 'Ngày làm việc',          
            'opening_hours' => 'Giờ mở cửa',
            'closing_hours' => 'Giờ đóng cửa',
            'select_option' => 'Chọn ngày'
        ],
        'breadcrumbs' => [
            'title' => 'Thời Gian Hoạt Động',
            'all' => 'All',
            'restaurants_index' => 'Danh sách thời gian hoạt động',
            'new_restaurants' => 'Tạo mới',
            'add_restaurant' => 'Tạo Mới',
            'edit_restaurant' => 'Cập nhật',
            'delete_restaurants' => 'Cóa'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Tạo',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy'
        ],
        'flash_messages' => [
            'new' => 'Tạo mới thành công!',
            'update' => 'Cập nhật thành công!',
            'destroy' => 'Xóa thành công!',
            'can\'t_destroy' => 'Can not delete because Restaurant Working Time is in used'
        ],
        'not_found' => 'Không tìm thấy thời gian hoạt động!',
    ],
    'restaurants_categories' => [
        'breadcrumbs' => [
            'category_index' => 'Assign Categories to Restaurant',
            'new_category' => 'Assign Categories to Restaurant',
        ]
    ],    
    'restaurants_cuisines' => [
        'breadcrumbs' => [
            'cuisine_index' => 'Assign Cuisines to Restaurant',
            'new_cuisine' => 'Assign Cuisines to Restaurant',
        ]
    ],
    'restaurant_delivery_settings' => [
        'breadcrumbs' => [
            'title' => 'Quản lý thời gian giao hàng',
            'restaurant_delivery_settings_index' => 'Danh sách thời gian giao hàng',
            'restaurant_delivery_settings_create' => 'Tạo mới thời gian giao hàng',
            'restaurant_delivery_settings_update' => 'Chỉnh sửa thời gian giao hàng'
        ],
        'search' => [
            'restaurant_id' => 'Restaurant'
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            'active' => 'Hoạt Động',
            'inactive' => 'Ngưng Hoạt Động',
        ],
        'createButton' => 'Tạo Thời Gian Giao Hàng',
        'columns' => [
            'restaurant_id' => 'Nhà Hàng',
            'district_id' => 'Quận',
            'from' => 'Đơn hàng tối thiểu',
            'to' => 'Đơn hàng cao nhất',
            'delivery_cost' => 'Phí giao hàng',
            'min_order_amount' => 'Đon hàng tối thiểu',
            'action' => 'Tùy Chọn'
        ],
        'tooltip_title' => [
            'edit' => 'Chỉnh sửa',
            'delete' => 'Xóa'
        ],
        'flash_message' => [
            'update' => 'Thời gian giao hàng đã được cập nhật!',
            'new' => 'Thời gian giao hàng đã được tạo!',
            'destroy' => 'Thời gian giao hàng đã được xóa!',
        ],
        'validation_message' => [
            'delivery_time' => 'Giờ giao hàng phải sau giờ hiện tại',
        ],
        'not_found' => 'Không tìm thấy dữ liệu!'
    ],
    
    'tags' => [
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_ja' => 'Tên Tiếng Nhật',
            'type' => 'Loại',
            'action' => 'Tùy Chọn',
        ],
        'breadcrumbs' => [
            'tags_index' => 'Danh sách thẻ',
            'title' => 'Thẻ',
            'new_tags' => 'Tạo thẻ mới',
            'add_tags' => 'Thêm thẻ',
            'edit_event' => 'Chỉnh sửa thẻ',
            'delete_event' => 'Xóa thẻ',
            'edit_tags' => 'Chỉnh sửa thẻ',
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
            'name_en' => 'Tên Tiếng Anh',
            'name_ja' => 'Tên Tiếng Nhật',
            'type' => 'Loại',
        ],
        'buttons' => [
            'create' => 'Tạo mới',
            'update' => 'Cập nhật',
            'cancel' => 'Hủy',
        ],
        'flash_messages' => [
            'new' => 'Thẻ đã đươc tạo',
            'update' => 'Thẻ đã được cập nhật',
            'destroy' => 'Thẻ đã được xóa',
            'can\'t_destroy' => 'Không thể xóa vì thẻ đang được sử dụng',
            'duplicate' => 'Thẻ đã được sao chép!'
        ],
        'not_found' => 'Don\'t have any Tags'
    ],

    'orders' => [
        'statuses' => [
            'all' => 'Tất cả',
            'new' => 'Mới',
            'confirmed' => 'Xác nhận',
            'admin_accepted' => 'Admin được chấp nhận',
            'finished' => 'Đã hoàn thành',
            'rejected' => 'Bị từ chối',
            'success' => 'Thành công',
            'received' => 'Đã nhận',
            'accepted' => 'Được chấp nhận',
            'going' => 'Đang thực hiện',
            'delivered' => 'Đã giao',
            'canceled' => 'Đã hủy',
            'error' => 'Lỗi',
            'payment_fail' => 'Thanh toán thất bại',
        ]
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
            'title' => 'Quy định hiển thị theo giá cả',
            'time_base_pricing_rules_index' => 'Danh sách quy định hiển thị theo giá cả',
            'time_base_pricing_rules_create' => 'Tạo mới quy định hiển thị theo giá cả',
            'time_base_pricing_rules_update' => 'Chỉnh sửa quy định hiển thị theo giá cả'
        ],
        'search' => [
            'place_holder_text' => 'Tìm kiếm theo tên...'
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            'active' => 'Hoạt Động',
            'inactive' => 'Ngưng Hoạt Động',
        ],
        'time_base_pricing_rule_status' => [
            'success' => 'Thành công',
            'error' => 'Lỗi'
        ],
        'createButton' => 'Tạo Mới Quy Định',
        'columns' => [
            'restaurant_id' => 'Nhà Hàng',
            'name' => 'Tên Quy Định',
            'active' => 'Tình Trạng',
            'mon' => 'Thứ 2',
            'tue' => 'Thứ 3',
            'wed' => 'Thứ 4',
            'thu' => 'Thứ 5',
            'fri' => 'Thứ 6',
            'sat' => 'Thứ 7',
            'sun' => 'Chủ Nhật',
            'period_type' => 'Cách hiển thị',
            'from_date' => 'Từ Ngày',
            'to_date' => 'Đến Ngày',
            'all_times' => 'Cách hiển thị theo giờ',
            'from_time' => 'Từ',
            'to_time' => 'Đến',
            'action' => 'Tùy Chọn',
            'all_days' => 'Chọn ngày trong tuần',
            'type' => 'Loại hiển thị',
            'value' => 'Giá trị',
            'inscrease' => 'Hướng'
        ],
        'tooltip_title' => [
            'edit' => 'Chỉnh sửa',
            'delete' => 'Xóa'
        ],
        'select' => [
            'forever' => 'Mãi Mãi',
            'specific_period' => 'Khoảng thời gian cố định',
            'all_days' => 'Tất cả các ngày',
            'specific_days' => 'Chọn ngày cụ thể',
            'all_time' => 'Tất cả các giờ',
            'specific_time' => 'Chọn giờ cụ thể',
            'percent' => 'Theo phần trăm',
            'price' => 'Theo giá cả',
            'increase' => 'Tăng',
            'decrease' => 'Giảm'
        ],
        'flash_message' => [
            'update' => 'Quy định đã được cập nhật!',
            'new' => 'Quy định đã được tạo!',
            'destroy' => 'Quy định đã xóa!',
            'duplicate' => 'Quy định đã được sao chép!'
        ],
        'validation_message' => [
            'at_least_one' => 'Bạn phải chọn ít nhất một ngày',
            'from_date' => 'Ngày bắt đầu phải sau hoặc bằng ngày hiện tại',
            'to_date' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'from_time' => 'Giờ bắt đầu phải sau giờ hiện tại',
            'to_time' => 'Giờ kết thúc phải sau giờ bắt đầu',
            'percent_value' => 'Giá trị phần trăm không được vượt quá 100'
        ],
        'detail' => [
            'period' => 'Khoảng thời gian',
            'specific_period' => 'Khoảng thời gian cụ thể',
            'forever' => 'Mãi mãi',
            'from_date' => 'Từ ngày',
            'to_date' => 'Đến ngày',
            'days_in_week' => 'Ngày trong tuần',
            'all_days' => 'Tất cả các ngày',
            'display_time' => 'Thời gian',
            'all_times' => 'Tất cả khoảng thời gian',
            'specific_time' => 'Thời gian cụ thể',
            'from_time' => 'Từ',
            'to_time' => 'Đến',
            'mon' => 'Thứ 2',
            'tue' => 'Thứ 3',
            'wed' => 'Thứ 4',
            'thu' => 'Thứ 5',
            'fri' => 'Thứ 6',
            'sat' => 'Thứ 7',
            'sun' => 'Chủ Nhật',
            'type' => 'Loại hiển thị',
            'value' => 'Giá trị',
            'percent' => 'Theo phần trăm',
            'price' => 'Theo giá'
        ],
        'not_found' => 'Không tìm thấy quy định!'
    ],
    'taxes' => [
        'breadcrumbs' => [
            'tax_info' => 'Thông tin thuế',
            'tax_detail' => 'Chi tiết thuế'
        ],
        'forms' => [
            'type' => 'Loại thuế',
            'rate' => 'Tỉ lệ',
            'inclusive' => 'Bao gồm',
            'exclusive' => 'Không bao gồm'
        ],
        'flash_messages' => [
            'create' => 'Thông tin thuế đã được tạo!',
            'update' => 'Thông tin thuế đã được cập nhật!',
        ],
    ],
    'printers' => [
        'search' => [
            'status' => 'Trạng thái',           
            'restaurant' => 'Nhà hàng',
            'place_holder_text' => 'Tìm dựa vào tên...'
        ],
        'columns' => [
            'name' => 'Tên',
            'restaurant' => 'Nhà hàng',
            'status' => 'Trạng thái',
            'action' => 'Hành động'
        ],
        'forms' => [
            'name' => 'Tên',
            'printer_status' => 'Trạng thái',
            'restaurant' => 'Nhà hàng',
            'check_interval' => 'Thời gian lặp',
            'token' => 'Token',
            'page_header' => 'Phần đầu trang',
            'page_footer' => 'Phần cuối trang',
            'auto_print' => 'Tự động in',
            'reject_reason' => 'Các lí do từ chối',
            'ip' => 'IP hoặc Tên Miền',
            'port' => 'Port',
            'polling_url' => 'Polling URL',
            'callback_url' => 'Callback URL',
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload'
        ],
        'breadcrumbs' => [
            'title' => 'Máy in',
            'printer_index' => 'Danh sách máy in',
            'new_printer' => 'Tạo mới',
            'data_of_printer' => 'Dữ liệu máy in',
            'add_printer' => 'Thêm máy in',
            'edit_printer' => 'Chỉnh sửa máy in',
            'delete_printer' => 'Xóa máy in',
            'save_printer' => 'Xuất file ini'
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            'active' => 'Hoạt Động',
            'inactive' => 'Ngưng Hoạt Động',
        ],
        'printer_status' => [
            'success' => 'Thành công',
            'error' => 'lỗi'
        ],
        'buttons' => [
            'create' => 'Tạo mới',
            'upgrate' => 'Cập nhật',
            'cancel' => 'Hủy bỏ'
        ],
        'flash_messages' => [
            'new' => 'Máy in đã được tạo!',
            'update' => 'Máy in đã được cập nhật!',
            'destroy' => 'Máy in đã được xóa!',
            'can\'t_destroy' => 'Không thể xóa vì xảy ra lỗi',
            'duplicate' => 'Máy in đã được sao chép!',
            'change_sequence_error' => 'Có lỗi xảy ra, vui lòng thử lại sau!'
        ],
        'not_found' => 'Không tìm thấy máy in nào!',
    ],
    'reports' => [
        'sale' => [
            'breadcrumbs' => [
                'title' => 'Báo cáo bán hàng',
                'sale_index' => 'Báo cáo',
            ]
        ],
        'invoice' => [
            'breadcrumbs' => [
                'title' => 'Báo cáo hóa đơn',
                'invoice_index' => 'Báo cáo',
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
            'name' => 'Name',
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
            'min_order_value' => 'Min Order Value',
            'max_order_value' => 'Max Order Value',
            'item_value_from' => 'Item Value From',
            'item_value_to' => 'Item Value To',
            'active' => 'Active',
            'restaurant' => 'Restaurant',
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
    'commission_rules' => [
        'columns' => [
            'level' => 'Cấp Độ',
            'total_from' => 'Tổng Tiền Từ',
            'total_to' => 'Tổng Tiền Đến',
            'rate' => 'Tỉ lệ',
            'action' => 'Tùy Chọn',
        ],
        'forms' => [
            'level' => 'Cấp Độ',
            'total_from' => 'Tổng Tiền Từ',
            'total_to' => 'Tổng Tiền Đến',
            'rate' => 'Tỉ lệ',
        ],
        'createBtn' => 'Tạo quy định mức hoa hồng',
        'breadcrumbs' => [
            'title' => 'Quy định mức hoa hồng',
            'commission_index' => 'Danh sách quy định mức hoa hồng',
            'add_commission' => 'Thêm quy định mức hoa hồng',
            'edit_commission' => 'Cập nhật quy định mức hoa hồng',
        ],
        'flash_messages' => [
            'new' => 'Quy định mức hoa hồng đã đươc tạo!',
            'update' => 'Quy định mức hoa hồng đã đươc cập nhật!',
            'destroy' => 'Quy định mức hoa hồng đã đươc xóa!',
        ],
        'not_found' => 'Không có quy định nào!',
    ],

];
