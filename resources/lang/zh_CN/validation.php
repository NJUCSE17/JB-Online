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

    'accepted' => '必须接受:attribute。',
    'active_url' => ':attribute不是一个有效的链接。',
    'after' => ':attribute必须是一个晚于:date的日期。',
    'after_or_equal' => ':attribute必须是一个不早于:date的日期。',
    'alpha' => ':attribute属性只能包括字母。',
    'alpha_dash' => ':attribute只能包含字母、数字、下划线等符号。',
    'alpha_num' => ':attribute只能包含字母和数字。',
    'array' => ':attribute必须是一个数组。',
    'before' => ':attribute必须是一个早于:date的日期。',
    'before_or_equal' => ':attribute必须是一个不晚于:date的日期。',
    'between' => [
        'numeric' => ':attribute应该介于:min与:max之间。',
        'file' => ':attribute应该介于:min与:maxKB之间。',
        'string' => ':attribute应该包含:min至:max个字符。',
        'array' => ':attribute应该包含:min至:max个元素。',
    ],
    'boolean' => ':attribute应该是布尔值。',
    'confirmed' => '确认的:attribute和输入的不一致。',
    'date' => ':attribute不是一个有效的日期。',
    'date_equals' => ':attribute必须是等于:date的日期。',
    'date_format' => ':attribute不符合:format 的日期格式。',
    'different' => ':attribute必须不等于:other。',
    'digits' => ':attribute必须有:digits 位。',
    'digits_between' => ':attribute必须有:min至:max位。',
    'dimensions' => ':attribute尺寸不正确。',
    'distinct' => ':attribute有重复值。',
    'email' => ':attribute必须是有效的电子邮箱地址。',
    'exists' => '选择的:attribute不存在。',
    'file' => ':attribute必须是一个文件。',
    'filled' => ':attribute不能为空。   ',
    'gt' => [
        'numeric' => ':attribute应该大于:min。',
        'file' => ':attribute应该大于:minKB。',
        'string' => ':attribute应该超过:min个字符。',
        'array' => ':attribute应该包含超过:min个元素。',
    ],
    'gte' => [
        'numeric' => ':attribute应该不小于:min。',
        'file' => ':attribute应该不小于:minKB。',
        'string' => ':attribute应该不少于:min个字符。',
        'array' => ':attribute应该包含不少于:min个元素。',
    ],
    'image' => ':attribute必须是一张图片。',
    'in' => '选择的:attribute无效。',
    'in_array' => ':attribute并不在:other 数组中。',
    'integer' => ':attribute必须是整数。',
    'ip' => ':attribute必须是一个有效的IP地址。',
    'ipv4' => ':attribute必须是一个有效的IPv4地址。',
    'ipv6' => ':attribute必须是一个有效的IPv6地址。',
    'json' => ':attribute必须是有效的JSON字符串。',
    'lt' => [
        'numeric' => ':attribute应该少于:min.',
        'file' => ':attribute应该小于:minKB。',
        'string' => ':attribute应该少于:min个字符。',
        'array' => ':attribute应该少于:min个元素。',
    ],
    'lte' => [
        'numeric' => ':attribute应该不超过:min。',
        'file' => ':attribute应该不超过:minKB。',
        'string' => ':attribute应该不超过:min个字符。',
        'array' => ':attribute应该不超过:min个元素。',
    ],
    'max' => [
        'numeric' => ':attribute应该至多为:min。',
        'file' => ':attribute应该至多为:minKB。',
        'string' => ':attribute应该至多有:min个字符。',
        'array' => ':attribute应该包含至多:min个元素。',
    ],
    'mimes' => ':attribute必须是:values类型的文件。',
    'mimetypes' => ':attribute必须是以下类型之一：:values。',
    'min' => [
        'numeric' => ':attribute应该至少为:min。',
        'file' => ':attribute应该至少为:minKB。',
        'string' => ':attribute应该至少有:min个字符。',
        'array' => ':attribute应该包含至少:min个元素。',
    ],
    'not_in' => '选择的:attribute无效。',
    'not_regex' => ':attribute的格式不正确。',
    'numeric' => ':attribute必须是一个数字。',
    'present' => ':attribute必须为有效的。',
    'regex' => ':attribute的格式不正确。',
    'required' => '需要填写:attribute。',
    'required_if' => '需要填写:attribute，除非:other 为:value。',
    'required_unless' => '需要填写:attribute，除非:other 属于:values中的某一个。',
    'required_with' => '当:values存在时需要填写:attribute。',
    'required_with_all' => '当:values存在时需要填写:attribute。',
    'required_without' => '当:values不存在时需要填写:attribute。',
    'required_without_all' => '当:values不存在时需要填写:attribute。',
    'same' => ':attribute和:other必须一致。',
    'size' => [
        'numeric' => ':attribute必须为:size。',
        'file' => ':attribute必须为:sizeKB。',
        'string' => ':attribute必须为:size个字符。',
        'array' => ':attribute必须包含:size个元素。',
    ],
    'starts_with' => ':attribute必须以以下任意值为开头：:values。',
    'string' => ':attribute必须是一个字符串。',
    'timezone' => ':attribute必须是一个有效的时区。',
    'unique' => ':attribute已被占用。',
    'uploaded' => ':attribute上传失败。',
    'url' => ':attribute的格式不正确。',
    'uuid' => ':attribute必须是一个有效的UUID。',

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
            //'rule-name' => 'custom-message',
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

    'attributes' => [],

];
