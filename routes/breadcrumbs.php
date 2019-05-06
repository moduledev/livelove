<?php
// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Главная', route('dashboard.index'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Пользователи', route('dashboard.users'));
});

Breadcrumbs::for('admins', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Администраторы', route('dashboard.admins'));
});

Breadcrumbs::for('programs', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Программы', route('dashboard.programs'));
});

Breadcrumbs::for('edit', function ($trail, $id) {
    $trail->parent('admins');
    $trail->push('Изменить', route('admin.admins.edit', $id));
});
Breadcrumbs::for('show', function ($trail, $id,$name) {
    $trail->parent('programs');
    $trail->push($name, route('show.program', $id));
});