@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Oops!')
@else
# @lang('你好！')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{!! $line  !!}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{!!  $line !!}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "如果您无法点击 \":actionText\" 按钮，可复制以下链接".
    '并用浏览器打开： [:actionURL](:actionURL) ；<br> 如果您'.
    '不想收到邮件，可前往 [:centerText](:centerURL) 关闭邮件通知。',
    [
        'actionText' => $actionText,
        'actionURL'  => $actionUrl,
        'centerText' => "个人中心",
        'centerURL'  => route("frontend.user.account"),
    ]
)
@endcomponent
@endisset
@endcomponent
