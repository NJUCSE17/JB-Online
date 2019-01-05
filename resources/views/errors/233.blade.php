@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    😶 233 Not a Chinese
                </h4>
                <div class="card-body">
                    <p>
                        <code class="my-3">
                            @if($exception->getMessage())
                                {{ $exception->getMessage() }}
                            @else
                                Sorry, not available. (No message)
                            @endif
                        </code>
                    </p>
                    <p>
                        The wonderful {{ app_name() }} is only available to Mainland Chinese users.
                    </p>
                    <p>
                        素晴らしいの {{ app_name() }} には本土の Chinese しかご利用できません。
                    </p>
                    <hr />
                    <p>
                        如果你的确是个拆腻斯，请在以下框内输入“爱慕拆腻斯”，点击解锁网站。
                    </p>

                    <form onsubmit="netaCheck();">
                        <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-passport"></i></div>
                            </div>
                            {{ html()->text('student_id')
                                ->class('form-control')
                                ->attribute('minlength', 5)
                                ->attribute('maxlength', 5)
                                ->placeholder('不如换个五个字的梗填进来？')
                                ->required()
                                ->id('netaInput') }}
                            <button class="btn btn-outline-success ml-3">Open the gay!</button>
                        </div><!--form-group-->
                        <script type="text/javascript">
                            function netaCheck() {
                                event.preventDefault();
                                let inputbox = $('#netaInput');
                                let input = inputbox.val();
                                inputbox.val('');

                                if (input === '爱慕拆腻斯') {
                                    document.location.href = "{{ route('frontend.auth.login') }}";
                                } else {
                                    let title = "失败";
                                    let content = "你不是拆腻斯！";
                                    let type = "red";

                                    switch (input) {
                                        case "黑色高级车": {
                                            title = "恶臭";
                                            content = "在，看看护照？";
                                            type = "green";
                                            break;
                                        }
                                        case "文体两开花": {
                                            title = "今年下半年……";
                                            content = "中美合拍……我将……传播……多多支持。";
                                            type = "green";
                                            break;
                                        }
                                        case "比利海灵顿": {
                                            title = "Boy ♂ Next ♂ Door";
                                            content = "Do you like what you see?";
                                            type = "green";
                                            break;
                                        }
                                        case "三回啊三回": {
                                            title = "汪汪汪";
                                            content = "跪下！学狗叫！";
                                            type = "green";
                                            break;
                                        }
                                        case "梦想三巨头": {
                                            title = "🎵";
                                            content = "你嫌弃破烂，把我灌醉~快乐老家，天亮就出发~";
                                            type = "green";
                                            break;
                                        }
                                    }

                                    $.alert({
                                        title : title,
                                        content: content,
                                        type: type,
                                    });
                                }
                            }
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection