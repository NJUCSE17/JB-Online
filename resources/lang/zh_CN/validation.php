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

    'accepted' => '必须接受 :attribute 。',
    'active_url' => ':attribute 不是一个有效的链接。',
    'after' => ':attribute 必须是一个晚于 :date 的日期。',
    'after_or_equal' => ':attribute 必须是一个不早于 :date 的日期。',
    'alpha' => ':attribute 属性只能包括字母。',
    'alpha_dash' => ':attribute 只能包含字母、数字、下划线等符号。',
    'alpha_num' => ':attribute 只能包含字母和数字。',
    'array' => ':attribute 必须是一个数组。',
    'before' => ':attribute 必须是一个早于 :date 的日期。',
    'before_or_equal' => ':attribute 必须是一个不晚于 :date 的日期。',
    'between' => [
        'numeric' => ':attribute 应该介于 :min 与 :max 之间。',
        'file' => ':attribute 应该介于 :min 与 :max KB之间。',
        'string' => ':attribute 应该包含 :min 至 :max 个字符。',
        'array' => ':attribute 应该包含 :min 至 :max 个元素。',
    ],
    'boolean' => ':attribute 应该是布尔值。',
    'confirmed' => '确认的 :attribute 和输入的不一致。',
    'date' => ':attribute 不是一个有效的日期。',
    'date_equals' => ':attribute 必须是等于 :date 的日期。',
    'date_format' => ':attribute 不符合 :format 的日期格式。',
    'different' => ':attribute 必须不等于 :other 。',
    'digits' => ':attribute 必须有 :digits 位。',
    'digits_between' => ':attribute 必须有 :min 至 :max 位。',
    'dimensions' => ':attribute 尺寸不正确。',
    'distinct' => ':attribute 有重复值。',
    'email' => ':attribute 必须是有效的电子邮箱地址。',
    'exists' => '选择的 :attribute 不存在。',
    'file' => ':attribute 必须是一个文件。',
    'filled' => ':attribute 不能为空。   ',
    'gt' => [
        'numeric' => ':attribute 应该大于 :min 。',
        'file' => ':attribute 应该大于 :min KB。',
        'string' => ':attribute 应该超过 :min 个字符。',
        'array' => ':attribute 应该包含超过 :min 个元素。',
    ],
    'gte' => [
        'numeric' => ':attribute 应该不小于 :min 。',
        'file' => ':attribute 应该不小于 :min KB。',
        'string' => ':attribute 应该不少于 :min 个字符。',
        'array' => ':attribute 应该包含不少于 :min 个元素。',
    ],
    'image' => ':attribute 必须是一张图片。',
    'in' => '选择的 :attribute 无效。',
    'in_array' => ':attribute 并不在 :other 数组中。',
    'integer' => ':attribute 必须是整数。',
    'ip' => ':attribute 必须是一个有效的IP地址。',
    'ipv4' => ':attribute 必须是一个有效的IPv4地址。',
    'ipv6' => ':attribute 必须是一个有效的IPv6地址。',
    'json' => ':attribute 必须是有效的JSON字符串。',
    'lt' => [
        'numeric' => ':attribute 应该少于 :min.',
        'file' => ':attribute 应该小于 :min KB。',
        'string' => ':attribute 应该少于 :min 个字符。',
        'array' => ':attribute 应该少于 :min 个元素。',
    ],
    'lte' => [
        'numeric' => ':attribute 应该不超过 :min 。',
        'file' => ':attribute 应该不超过 :min KB。',
        'string' => ':attribute 应该不超过 :min 个字符。',
        'array' => ':attribute 应该不超过 :min 个元素。',
    ],
    'max' => [
        'numeric' => ':attribute 应该至多为 :min 。',
        'file' => ':attribute 应该至多为 :min KB。',
        'string' => ':attribute 应该至多有 :min 个字符。',
        'array' => ':attribute 应该包含至多 :min 个元素。',
    ],
    'mimes' => ':attribute 必须是 :values 类型的文件。',
    'mimetypes' => ':attribute 必须是以下类型之一： :values 。',
    'min' => [
        'numeric' => ':attribute 应该至少为 :min 。',
        'file' => ':attribute 应该至少为 :min KB。',
        'string' => ':attribute 应该至少有 :min 个字符。',
        'array' => ':attribute 应该包含至少 :min 个元素。',
    ],
    'not_in' => '选择的 :attribute 无效。',
    'not_regex' => ':attribute 的格式不正确。',
    'numeric' => ':attribute 必须是一个数字。',
    'present' => ':attribute 必须为有效的。',
    'regex' => ':attribute 的格式不正确。',
    'required' => '需要填写:attribute 。',
    'required_if' => '需要填写:attribute ，除非 :other 为 :value 。',
    'required_unless' => '需要填写 :attribute ，除非 :other 属于 :values 中的某一个。',
    'required_with' => '当 :values 存在时需要填写 :attribute 。',
    'required_with_all' => '当 :values 存在时需要填写 :attribute 。',
    'required_without' => '当 :values 不存在时需要填写 :attribute 。',
    'required_without_all' => '当 :values 不存在时需要填写 :attribute 。',
    'same' => ':attribute 和 :other 必须一致。',
    'size' => [
        'numeric' => ':attribute 必须为 :size 。',
        'file' => ':attribute 必须为 :size KB。',
        'string' => ':attribute 必须为 :size 个字符。',
        'array' => ':attribute 必须包含 :size 个元素。',
    ],
    'starts_with' => ':attribute 必须以以下任意值为开头： :values 。',
    'string' => ':attribute 必须是一个字符串。',
    'timezone' => ':attribute 必须是一个有效的时区。',
    'unique' => ':attribute 已被占用。',
    'uploaded' => ':attribute 上传失败。',
    'url' => ':attribute 的格式不正确。',
    'uuid' => ':attribute 必须是一个有效的UUID。',

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
