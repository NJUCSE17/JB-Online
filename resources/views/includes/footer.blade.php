<footer id="footer-main" class="bg-transparent">
    <div class="footer footer-light bg-section-secondary pt-0">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-3 mt-2">
                <div class="col-md-6">
                    <div class="copyright text-sm text-center text-md-left">
                        <i class="fas fa-copyright mr-1"></i>
                        2018 - {{ now()->year }}，NJUCSE17版权所有。
                        <span class="d-block d-md-inline">
                            服务器处理用时：{{ round((microtime(true) - LARAVEL_START) * 1000) }}ms。
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                        @if(env('APP_ISP_NO'))
                            <li class="nav-item">
                                <p class="nav-link">{{ env('APP_ISP_NO') }}</p>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" title="关于我们（NJUCSE17）"
                               href="https://njucse17.github.io">
                                <i class="fas fa-users-class"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" title="查看源代码"
                               href="https://github.com/NJUCSE17/JB-Online">
                                <i class="fas fa-code"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" title="开发文档"
                               href="/docs">
                                <i class="fas fa-book"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
