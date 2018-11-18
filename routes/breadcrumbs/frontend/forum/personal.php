<?php

Breadcrumbs::for('frontend.forum.personal.index', function ($trail) {
    $trail->parent('frontend.index');
    $trail->push(__('strings.frontend.breadcrumb.personal.index'), route('frontend.forum.personal.index'));
});

Breadcrumbs::for('frontend.forum.personal.finished', function ($trail) {
    $trail->parent('frontend.forum.personal.index');
    $trail->push(__('strings.frontend.breadcrumb.personal.finished'), route('frontend.forum.personal.finished'));
});

Breadcrumbs::for('frontend.forum.personal.deleted', function ($trail) {
    $trail->parent('frontend.forum.personal.index');
    $trail->push(__('strings.frontend.breadcrumb.personal.deleted'), route('frontend.forum.personal.deleted'));
});

Breadcrumbs::for('frontend.forum.personal.create', function ($trail) {
    $trail->parent('frontend.forum.personal.index');
    $trail->push(__('strings.frontend.breadcrumb.personal.create'), route('frontend.forum.personal.create'));
});

Breadcrumbs::for('frontend.forum.personal.edit', function ($trail, $id) {
    $trail->parent('frontend.forum.personal.index');
    $trail->push(__('strings.frontend.breadcrumb.personal.edit'), route('frontend.forum.personal.edit', $id));
});

?>