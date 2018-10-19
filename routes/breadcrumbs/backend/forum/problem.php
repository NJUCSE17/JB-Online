<?php

Breadcrumbs::for('admin.forum.problem.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.problems.management'), route('admin.forum.problem.index'));
});

Breadcrumbs::for('admin.forum.problem.specific', function ($trail, $id) {
    $trail->parent('admin.forum.problem.index');
    $trail->push(__('labels.backend.forum.problems.management'), route('admin.forum.problem.specific', $id));
});

Breadcrumbs::for('admin.forum.problem.specific.create', function ($trail, $id) {
    $trail->parent('admin.forum.problem.index');
    $trail->push(__('labels.backend.forum.problems.management'), route('admin.forum.problem.specific.create', $id));
});

Breadcrumbs::for('admin.forum.problem.deleted', function ($trail) {
    $trail->parent('admin.forum.problem.index');
    $trail->push(__('menus.backend.forum.problems.deleted'), route('admin.forum.problem.deleted'));
});

Breadcrumbs::for('admin.forum.problem.show', function ($trail, $id) {
    $trail->parent('admin.forum.problem.index');
    $trail->push(__('menus.backend.forum.problems.view'), route('admin.forum.problem.show', $id));
});

Breadcrumbs::for('admin.forum.problem.create', function ($trail) {
    $trail->parent('admin.forum.problem.index');
    $trail->push(__('labels.backend.forum.problems.create'), route('admin.forum.problem.create'));
});

Breadcrumbs::for('admin.forum.problem.edit', function ($trail, $id) {
    $trail->parent('admin.forum.problem.index');
    $trail->push(__('menus.backend.forum.problems.edit'), route('admin.forum.problem.edit', $id));
});
