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

    'accepted'             => '属性必须被接受',
    'active_url'           => '属性不是有效的URL',
    'after'                => '属性必须是后一个日期：日期.',
    'alpha'                => '属性可能只包含字母',
    'alpha_dash'           => '属性只能包含字母，数字及破折号',
    'alpha_num'            => '属性只能包含字母和数字',
    'array'                => '属性必须是一个数组',
    'before'               => '属性必须是之前的日期：日期.',
    'between'              => [
        'numeric' => '属性必须在：最少和：最多.',
        'file'    => '属性必须在：最少和：最多字节.',
        'string'  => '属性必须在：最少和：最多字符',
        'array'   => '属性必须在其之间：最少和：最多的项目',
    ],
    'boolean'              => '属性字段必须是真还是假',
    'confirmed'            => '属性确认不匹配.',
    'date'                 => '属性无有效的日期.',
    'date_format'          => '属性不匹配的格式：格式.',
    'different'            => '属性和：对方必须是不同的',
    'digits'               => '属性必须是：数字数字',
    'digits_between'       => '属性必须在：最少和：最多数字.',
    'email'                => '属性必须是一个有效的电子邮件地址',
    'exists'               => '所选择的：属性是无效的.',
    'filled'               => '属性字段是必填的.',
    'image'                => '属性必须是一个图像.',
    'in'                   => '属性是无效的',
    'integer'              => '属性必须是整数',
    'ip'                   => '属性必须是一个有效的IP地址',
    'json'                 => '属性必须是一个有效的JSON字符串',
    'max'                  => [
        'numeric' => '属性不得大于：最多.',
        'file'    => '属性不得大于：最多字节',
        'string'  => '属性不得大于：最多字符.',
        'array'   => '属性不得大于：最多物品.',
    ],
    'mimes'                => '属性的类型必须为一个文件：值.',
    'min'                  => [
        'numeric' => '属性必须至少为：最少',
        'file'    => '属性必须至少为：最少字节',
        'string'  => '属性必须至少为：最少字符',
        'array'   => '属性必须至少为：最少的物品',
    ],
    'not_in'               => '所选择的：属性是无效的.',
    'numeric'              => '属性必须是数字.',
    'regex'                => '属性的格式是无效的.',
    'required'             => '属性字段是必填的',
    'required_if'          => '属性字段是必填的，当：另一个是: 价值.',
    'required_with'        => '属性字段是必填的，当：价值存在.',
    'required_with_all'    => '属性字段是必填的，当：价值存在',
    'required_without'     => '属性字段是必填的，当：价值不存在',
    'required_without_all' => '属性字段是必填的，当没有任何：价值存在',
    'same'                 => '属性和：其他必须匹配.',
    'size'                 => [
        'numeric' => '属性必须是：大小',
        'file'    => '属性必须是：字节大小.',
        'string'  => '属性必须是：字符大小',
        'array'   => '属性必须包含：物品大小',
    ],
    'string'               => '属性必须是一个字符串',
    'timezone'             => '属性必须是一个有效的区域。',
    'unique'               => '属性已被占用',
    'url'                  => '属性的格式是无效的',

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
            'rule-name' => 'custom-message',
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
        'image' => '图片',
        'firstname'  => '名字',
        'lastname' => '姓氏',
        'gender' => '性别',
        'address' => '地址',
        'city' => '城市',
        'zipcode' => '邮政编码',
        'state' => '省/州',
        'country' => '国家',
        'mobile' => '手机号码',
        'newemail' => '新电子邮件',
        'renewemail' => '重复新电子邮件',
        'newpassword' => '新密码',
        'renewpassword' => '重复新密码',
        'alias' => '用户名',
    ],

];
