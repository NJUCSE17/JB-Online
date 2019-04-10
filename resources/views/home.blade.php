@extends('layouts.app')

@section('content')
    <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main"
             style="padding-top: 147.188px;">
        <!-- Header container -->
        <div class="container pt-4 pt-lg-0">
            <div class="row">
                <div class=" col-lg-12">
                    <!-- Salute + Small stats -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-5 mb-4 mb-md-0">
                            <span class="h2 mb-0 text-white d-block">早上好，XXX</span>
                            <span class="text-white">此处放个鸡汤</span>
                        </div>
                        <div class="col-auto flex-fill d-none d-xl-block">
                            <ul class="list-inline row justify-content-lg-end mr-lg-2 mb-0">
                                <li class="list-inline-item">
                                    <p class="text-white">
                                        此处列举一点数据
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Account navigation -->
                    <div class="d-flex">
                        <a href="#" class="btn btn-icon btn-group-nav shadow btn-neutral">
                            <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
                            <span class="btn-inner--text d-none d-md-inline-block">我的账户</span>
                        </a>
                        <div class="btn-group btn-group-nav shadow ml-auto" role="group" aria-label="Basic example">
                            <a href="#" class="btn btn-icon shadow btn-neutral">
                                <span class="btn-inner--icon"><i class="fas fa-book-open"></i></span>
                                <span class="btn-inner--text d-none d-md-inline-block">课程</span>
                            </a>
                            <a href="#" class="btn btn-icon shadow btn-neutral">
                                <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
                                <span class="btn-inner--text d-none d-md-inline-block">资源</span>
                            </a>
                            <a href="#" class="btn btn-icon shadow btn-neutral">
                                <span class="btn-inner--icon"><i class="fas fa-rss-square"></i></span>
                                <span class="btn-inner--text d-none d-md-inline-block">博客</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice bg-section-secondary">
        <div class="container">
            <div class="row">
                <div class="col col-md-8">
                    <assignments-collection-component
                            :assignments='{!! json_encode($assignments) !!}'
                    ></assignments-collection-component>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    import AssignmentsCollectionComponent from "../js/components/AssignmentsCollectionComponent";

    export default {
        components: {AssignmentsCollectionComponent}
    }
</script>