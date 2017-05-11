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

    'accepted'             => '那个 :属性必须被接受。',
    'active_url'           => '那个 :房地产是不是一个有效的URL 。',
    'after'                => '那个 :属性必须在指定日期后：日期。',
    'alpha'                => '那个 :物业只能包含字母。',
    'alpha_dash'           => '那个 :属性只能包含字母，数字及破折号。',
    'alpha_num'            => '那个 :属性只能包含字母和数字。',
    'array'                => '那个 :房产必须是一个数组。',
    'before'               => '那个 :属性必须日期前：日期。',
    'between'              => [
        'numeric' => '那个 :属性必须：最小和：最大。',
        'file'    => '那个 :属性必须：最低：最大千字节。',
        'string'  => '那个 :必须性能：最小和：最大字符数。',
        'array'   => '那个 :最小和最大属性之间必须有',
    ],
    'boolean'              => '那个 :属性字段必须是真的还是假的.',
    'confirmed'            => '那个 :物业确认不匹配.',
    'date'                 => '那个 :房地产是不是一个有效日期',
    'date_format'          => '那个 :属性不匹配的格式：格式。',
    'different'            => '那个 :属性和：等必须是不同的.',
    'digits'               => '那个 :物业必须是：数字.',
    'digits_between'       => '那个 :必须性能：最小和：最大数。',
    'email'                => '那个 :属性必须是一个有效的电子邮件地址',
    'exists'               => '那个 选择：房地产是无效的',
    'filled'               => '那个 :物业所需的有关资料.',
    'image'                => '那个 :属性必须是图像.',
    'in'                   => '那个 选择：属性无效.',
    'integer'              => '那个 :属性必须是整数.',
    'ip'                   => '那个 :属性必须是一个有效的IP地址',
    'json'                 => '那个 :属性必须是一个有效的JSON字符串.',
    'max'                  => [
        'numeric' => '那个 :财产不得高于：最大.',
        'file'    => '那个 :财产不得高于：最大千字节.',
        'string'  => '那个 :物业不得超过： MAX个字符.',
        'array'   => '那个 :物业不得超过最大项目.',
    ],
    'mimes'                => '那个 :属性必须是文件的类型：值.',
    'min'                  => [
        'numeric' => '那个 :属性必须至少：最小.',
        'file'    => '那个 :物业必须至少为：点千字节',
        'string'  => '那个 :物业必须至少为：最小字符.',
        'array'   => '那个 :属性必须至少有：最低的项目.',
    ],
    'not_in'               => '那个 选择：属性无效.',
    'numeric'              => '那个 :属性必须是一个数字.',
    'regex'                => '那个 :无效的属性格式.',
    'required'             => '那个 :属性字段是必需的.',
    'required_if'          => '那个 :当房地产领域，我们需要：另一种是：值.',
    'required_with'        => '那个 :当属性字段，你需要：值存在.',
    'required_with_all'    => '那个 :存在价值：在需要时属性字段。',
    'required_without'     => '那个 :值不存在：当属性字段是必需的。',
    'required_without_all' => '那个 :存在价值：当没有属性的字段是必需的。',
    'same'                 => '那个 :属性和：等必须匹配.',
    'size'                 => [
        'numeric' => '那个 :物业必须是：大小.',
        'file'    => '那个 :物业必须是：大小字节',
        'string'  => '那个 :物业必须是：字符大小.',
        'array'   => '那个 :属性必须包含：项目的大小.',
    ],
    'string'               => '那个 :物业必须是一个字符串',
    'timezone'             => '那个 :属性必须是一个有效的区域.',
    'unique'               => '那个 :它一直属性.',
    'url'                  => '那个 :无效的属性格式.',

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
        'attribute-name' => [
            'rule-name' => '自定义消息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => '电子邮件',
        'password' => '密码',
        'repassword' => '确认密码',
        'image' => '图像',
        'firstname'  => '名字',
        'lastname' => '姓',
        'gender' => '性别',
        'address' => '地址',
        'city' => '市',
        'zipcode' => '邮政编码',
        'state' => '州',
        'country' => '国家',
        'mobile' => '手机号码。',
        'newemail' => '新的电子邮件',
        'renewemail' => '重复新的电子邮件',
        'newpassword' => '新密码',
        'renewpassword' => '重复新密码',
        'alias' => '用户名',
    ],

];
