<?php

Breadcrumbs::for('admin.forum.post.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.posts.management'), route('admin.forum.post.index'));
});

Breadcrumbs::for('admin.forum.post.specific', function ($trail, $id) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.forum.posts.management'), route('admin.forum.post.specific', $id));
});

Breadcrumbs::for('admin.forum.post.deleted', function ($trail) {
    $trail->parent('admin.forum.post.index');
    $trail->push(__('menus.backend.forum.posts.deleted'), route('admin.forum.post.deleted'));
});

Breadcrumbs::for('admin.forum.post.show', function ($trail, $id) {
    $trail->parent('admin.forum.post.index');
    $trail->push(__('menus.backend.forum.posts.view'), route('admin.forum.post.show', $id));
});

Breadcrumbs::for('admin.forum.post.edit', function ($trail, $id) {
    $trail->parent('admin.forum.post.index');
    $trail->push(__('menus.backend.forum.posts.edit'), route('admin.forum.post.edit', $id));
});
