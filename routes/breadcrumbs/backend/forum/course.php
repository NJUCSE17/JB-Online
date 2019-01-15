<?php

Breadcrumbs::for('admin.forum.course.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.courses.management'), route('admin.forum.course.index'));
});

Breadcrumbs::for('admin.forum.course.deleted', function ($trail) {
    $trail->parent('admin.forum.course.index');
    $trail->push(__('menus.backend.forum.courses.deleted'), route('admin.forum.course.deleted'));
});

Breadcrumbs::for('admin.forum.course.create', function ($trail) {
    $trail->parent('admin.forum.course.index');
    $trail->push(__('labels.backend.forum.courses.create'), route('admin.forum.course.create'));
});

Breadcrumbs::for('admin.forum.course.show', function ($trail, $id) {
    $trail->parent('admin.forum.course.index');
    $trail->push(__('menus.backend.forum.courses.view'), route('admin.forum.course.show', $id));
});

Breadcrumbs::for('admin.forum.course.edit', function ($trail, $id) {
    $trail->parent('admin.forum.course.index');
    $trail->push(__('menus.backend.forum.courses.edit'), route('admin.forum.course.edit', $id));
});

Breadcrumbs::for('admin.forum.course.enroll.show', function ($trail, $id) {
    $trail->parent('admin.forum.course.index');
    $trail->push(__('menus.backend.forum.courses.enroll'), route('admin.forum.course.enroll.show', $id));
});
