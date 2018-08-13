<?php

Breadcrumbs::for('admin.forum.notice.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.notices.management'), route('admin.forum.notice.index'));
});

Breadcrumbs::for('admin.forum.notice.deleted', function ($trail) {
    $trail->parent('admin.forum.notice.index');
    $trail->push(__('menus.backend.forum.notices.deleted'), route('admin.forum.notice.deleted'));
});

Breadcrumbs::for('admin.forum.notice.create', function ($trail) {
    $trail->parent('admin.forum.notice.index');
    $trail->push(__('labels.backend.forum.notices.create'), route('admin.forum.notice.create'));
});

Breadcrumbs::for('admin.forum.notice.show', function ($trail, $id) {
    $trail->parent('admin.forum.notice.index');
    $trail->push(__('menus.backend.forum.notices.view'), route('admin.forum.notice.show', $id));
});

Breadcrumbs::for('admin.forum.notice.edit', function ($trail, $id) {
    $trail->parent('admin.forum.notice.index');
    $trail->push(__('menus.backend.forum.notices.edit'), route('admin.forum.notice.edit', $id));
});
