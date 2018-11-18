<?php

Breadcrumbs::for('admin.forum.assignment.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.assignments.management'), route('admin.forum.assignment.index'));
});

Breadcrumbs::for('admin.forum.assignment.finished', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.assignments.management'), route('admin.forum.assignment.index'));
});

Breadcrumbs::for('admin.forum.assignment.specific', function ($trail, $id) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.assignments.management'), route('admin.forum.assignment.specific', $id));
});

Breadcrumbs::for('admin.forum.assignment.deleted', function ($trail) {
    $trail->parent('admin.forum.assignment.index');
    $trail->push(__('menus.backend.forum.assignments.deleted'), route('admin.forum.assignment.deleted'));
});

Breadcrumbs::for('admin.forum.assignment.create', function ($trail) {
    $trail->parent('admin.forum.assignment.index');
    $trail->push(__('labels.backend.forum.assignments.create'), route('admin.forum.assignment.create'));
});

Breadcrumbs::for('admin.forum.assignment.show', function ($trail, $id) {
    $trail->parent('admin.forum.assignment.index');
    $trail->push(__('menus.backend.forum.assignments.view'), route('admin.forum.assignment.show', $id));
});

Breadcrumbs::for('admin.forum.assignment.edit', function ($trail, $id) {
    $trail->parent('admin.forum.assignment.index');
    $trail->push(__('menus.backend.forum.assignments.edit'), route('admin.forum.assignment.edit', $id));
});
