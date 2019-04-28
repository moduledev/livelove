<?php
// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Главная', route('admin.dashboard'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Пользователи', route('admin.users'));
});

Breadcrumbs::for('admins', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Администраторы', route('admin.admins'));
});