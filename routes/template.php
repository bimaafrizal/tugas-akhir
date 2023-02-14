<?php 
use Illuminate\Support\Facades\Route;

//aplication
Route::get('chat', function () {
    return view('pages.template.aplication.chat');
});
Route::get('checkout', function () {
    return view('pages.template.aplication.checkout');
});
Route::get('email', function () {
    return view('pages.template.aplication.email');
});
Route::get('gallery', function () {
    return view('pages.template.aplication.gallery');
});

//auth
Route::get('login', function () {
    return view('pages.template.auth.login');
});
Route::get('forgot-password', function () {
    return view('pages.template.auth.forgot-password');
});
Route::get('register', function () {
    return view('pages.template.auth.register');
});

//component
Route::get('accordion', function () {
    return view('pages.template.components.accordion');
});
Route::get('alert', function () {
    return view('pages.template.components.alert');
});
Route::get('badge', function () {
    return view('pages.template.components.badge');
});
Route::get('breadcrumb', function () {
    return view('pages.template.components.breadcrumb');
});
Route::get('button', function () {
    return view('pages.template.components.button');
});
Route::get('card', function () {
    return view('pages.template.components.card');
});
Route::get('carousel', function () {
    return view('pages.template.components.carousel');
});
Route::get('collapse', function () {
    return view('pages.template.components.collapse');
});
Route::get('dropdown', function () {
    return view('pages.template.components.dropdown');
});
Route::get('list-group', function () {
    return view('pages.template.components.list-group');
});
Route::get('modal', function () {
    return view('pages.template.components.modal');
});
Route::get('navs', function () {
    return view('pages.template.components.navs');
});
Route::get('pagination', function () {
    return view('pages.template.components.pagination');
});
Route::get('progress', function () {
    return view('pages.template.components.progress');
});
Route::get('spinner', function () {
    return view('pages.template.components.spinner');
});
Route::get('toast', function () {
    return view('pages.template.components.toast');
});
Route::get('tooltip', function () {
    return view('pages.template.components.tooltip');
});


//error
Route::get('error-403', function () {
    return view('pages.template.error.403');
});
Route::get('error-404', function () {
    return view('pages.template.error.404');
});
Route::get('error-500', function () {
    return view('pages.template.error.500');
});

//extra
Route::get('avatar', function () {
    return view('pages.template.extra.avatar');
});
Route::get('divider', function () {
    return view('pages.template.extra.divider');
});
Route::get('rating', function () {
    return view('pages.template.extra.rating');
});
Route::get('sweetalert', function () {
    return view('pages.template.extra.sweetalert');
});
Route::get('toastify', function () {
    return view('pages.template.extra.toastify');
});

//forms
Route::get('checkbox', function () {
    return view('pages.template.forms.checkbox');
});
Route::get('ckeditor', function () {
    return view('pages.template.forms.ckeditor');
});
Route::get('form-validation', function () {
    return view('pages.template.forms.form-validation');
});
Route::get('input-group', function () {
    return view('pages.template.forms.input-group');
});
Route::get('input', function () {
    return view('pages.template.forms.input');
});
Route::get('layout', function () {
    return view('pages.template.forms.layout');
});
Route::get('quil', function () {
    return view('pages.template.forms.quil');
});
Route::get('radio', function () {
    return view('pages.template.forms.radio');
});
Route::get('select', function () {
    return view('pages.template.forms.select');
});
Route::get('summernote', function () {
    return view('pages.template.forms.summernote');
});
Route::get('textarea', function () {
    return view('pages.template.forms.textarea');
});
Route::get('tinymce', function () {
    return view('pages.template.forms.tinymce');
});

//layouts
Route::get('defaults', function () {
    return view('pages.template.layouts.defaults');
});
Route::get('horizontal', function () {
    return view('pages.template.layouts.horizontal');
});
Route::get('rtl-backup', function () {
    return view('pages.template.layouts.rtl-backup');
});
Route::get('rtl', function () {
    return view('pages.template.layouts.rtl');
});
Route::get('vertical-column', function () {
    return view('pages.template.layouts.vertical-column');
});
Route::get('vertical-navbar', function () {
    return view('pages.template.layouts.vertical-navbar');
});

//table
Route::get('datatable-jquery', function () {
    return view('pages.template.table.datatable-jquery');
});
Route::get('datatable', function () {
    return view('pages.template.table.datatable');
});
Route::get('table', function () {
    return view('pages.template.table.table');
});

//ui
Route::get('apexchart', function () {
    return view('pages.template.ui.apexchart');
});
Route::get('chartjs', function () {
    return view('pages.template.ui.chartjs');
});
Route::get('chatbox', function () {
    return view('pages.template.ui.chatbox');
});
Route::get('dripicons', function () {
    return view('pages.template.ui.dripicons');
});
Route::get('file-uploader', function () {
    return view('pages.template.ui.file-uploader');
});
Route::get('fontawesome', function () {
    return view('pages.template.ui.fontawesome');
});
Route::get('icons-bootstrap', function () {
    return view('pages.template.ui.icons-bootstrap');
});
Route::get('google-map', function () {
    return view('pages.template.ui.map-google-map');
});
Route::get('jsvectormap', function () {
    return view('pages.template.ui.map-jsvectormap');
});
Route::get('pricing', function () {
    return view('pages.template.ui.pricing');
});
Route::get('todolist', function () {
    return view('pages.template.ui.todolist');
});