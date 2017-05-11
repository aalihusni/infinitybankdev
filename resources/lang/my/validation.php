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

    'accepted'             => 'Maklumat :attribute perlu ditandakan.',
    'active_url'           => 'Maklumat :attribute tidak menggunakan format URL yang betul.',
    'after'                => 'Maklumat :attribute perlulah selepas tarikh :date.',
    'alpha'                => 'Maklumat :attribute perlulah hanya dalam bentuk huruf.',
    'alpha_dash'           => 'Maklumat :attribute hanya boleh mengandungi huruf, nombor, dan dash.',
    'alpha_num'            => 'Maklumat :attribute hanya boleh mengandungi huruf dan nombor sahaja.',
    'array'                => 'Maklumat :attribute perlulah dalam bentuk array.',
    'before'               => 'Maklumat :attribute perlulah bertarikh sebelum :date.',
    'between'              => [
        'numeric' => 'Maklumat :attribute perlulah diantara :min sehingga :max.',
        'file'    => 'Maklumat :attribute perlulah diantara :min sehingga :max kilobytes.',
        'string'  => 'Maklumat :attribute perlulah diantara :min sehingga :max abjad.',
        'array'   => 'Maklumat :attribute perlulah diantara :min sehingga :max items.',
    ],
    'boolean'              => 'Maklumat :attribute perlulah dalam bentuk "true" atau "false".',
    'confirmed'            => 'Maklumat :attribute tidak sepadan dengan pengesahan.',
    'date'                 => 'Maklumat :attribute bukan dalan format tarikh yang betul.',
    'date_format'          => 'Maklumat :attribute tidak mengikut format :format.',
    'different'            => 'Maklumat :attribute dan :other perlulah berlainan.',
    'digits'               => 'Maklumat :attribute perlulah :digits digit.',
    'digits_between'       => 'Maklumat :attribute perlulah diantara :min sehingga :max digit.',
    'email'                => 'Maklumat :attribute perlulah menggunakan format email yang sah.',
    'exists'               => 'Maklumat yang dipilih :attribute tidak sah.',
    'filled'               => 'Maklumat :attribute diperlukan.',
    'image'                => 'Maklumat :attribute perlulah dalam bentuk imej yang sah.',
    'in'                   => 'Maklumat yang dipilih :attribute tidak sah.',
    'integer'              => 'Maklumat :attribute perlulah dalam bentuk nombor.',
    'ip'                   => 'Maklumat :attribute perlulah dalam format ip yang sah.',
    'json'                 => 'Maklumat :attribute perlulah dalam format JSON.',
    'max'                  => [
        'numeric' => 'Maklumat :attribute tidak boleh lebih besar dari :max.',
        'file'    => 'Maklumat :attribute tidak boleh lebih besar dari :max kilobytes.',
        'string'  => 'Maklumat :attribute tidak boleh lebih banyak dari :max abjad.',
        'array'   => 'Maklumat :attribute tidak boleh lebih dari :max items.',
    ],
    'mimes'                => 'Maklumat :attribute perlulah dalam bentuk: :values.',
    'min'                  => [
        'numeric' => 'Maklumat :attribute perlulah sekurang-kurangnya :min.',
        'file'    => 'Maklumat :attribute perlulah sekurang-kurangnya :min kilobytes.',
        'string'  => 'Maklumat :attribute perlulah sekurang-kurangnya :min abjad.',
        'array'   => 'Maklumat :attribute perlulah sekurang-kurangnya :min items.',
    ],
    'not_in'               => 'Maklumat yang dipilih :attribute tidak sah.',
    'numeric'              => 'Maklumat :attribute perlulah dalam bentuk nombor.',
    'regex'                => 'Maklumat :attribute mempunyai format yang tidak sah.',
    'required'             => 'Maklumat :attribute diperlukan.',
    'required_if'          => 'Maklumat :attribute diperlukan sekiranya :other adalah :value.',
    'required_with'        => 'Maklumat :attribute diperlukan apabila :values ada.',
    'required_with_all'    => 'Maklumat :attribute diperlukan apabila nilai :values ada.',
    'required_without'     => 'Maklumat :attribute diperlukan sekiranya :values tidak ada.',
    'required_without_all' => 'Maklumat :attribute diperlukan apabila tiada :values dipilih.',
    'same'                 => 'Maklumat :attribute dan :other perlu sepadan.',
    'size'                 => [
        'numeric' => 'Maklumat :attribute perlulah :size.',
        'file'    => 'Maklumat :attribute perlulah :size kilobytes.',
        'string'  => 'Maklumat :attribute perlulah :size abjad.',
        'array'   => 'Maklumat :attribute perlu mempunyai :size items.',
    ],
    'string'               => 'Maklumat :attribute perlulah dalam bentuk "string".',
    'timezone'             => 'Maklumat :attribute perlu dalam zone yang sah.',
    'unique'               => 'Maklumat :attribute telah diambil.',
    'url'                  => 'Maklumat :attribute mempunyai format yang tidak sah.',

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
        'email' => 'Email',
        'password' => 'Kata Laluan',
        'repassword' => 'Sahkan Kata Laluan',
        'image' => 'Gambar',
        'firstname' => 'Nama Anda',
        'lastname' => 'Nama Keluarga',
        'gender' => 'Jantina',
        'address' => 'Alamat',
        'city' => 'Bandar/Kawasan',
        'zipcode' => 'Poskod',
        'state' => 'Negeri',
        'country' => 'Negara',
        'mobile' => 'No. Tel. Bimbit',
        'newemail' => 'Email Baru',
        'renewemail' => 'Ulang Email Baru',
        'newpassword' => 'Kata Laluan Baru',
        'renewpassword' => 'Ulang Kata Laluan Baru',
    ],

];
