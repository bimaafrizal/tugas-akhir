<li class="sidebar-item @yield('index')">
    <a href="/index" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard Template</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-stack"></i>
        <span>Components</span>
    </a>
    <ul class="submenu @yield('component')">
        <li class="submenu-item @yield('accordion')">
            <a href="/template/accordion">Accordion</a>
        </li>
        <li class="submenu-item @yield('alert')">
            <a href="/template/alert">Alert</a>
        </li>
        <li class="submenu-item @yield('badge')">
            <a href="/template/badge">Badge</a>
        </li>
        <li class="submenu-item @yield('breadcrumb')">
            <a href="/template/breadcrumb">Breadcrumb</a>
        </li>
        <li class="submenu-item @yield('button')">
            <a href="/template/button">Button</a>
        </li>
        <li class="submenu-item @yield('card')">
            <a href="/template/card">Card</a>
        </li>
        <li class="submenu-item @yield('carousel')">
            <a href="/template/carousel">Carousel</a>
        </li>
        <li class="submenu-item @yield('collapse')">
            <a href="/template/collapse">Collapse</a>
        </li>
        <li class="submenu-item @yield('dropdown')">
            <a href="/template/dropdown">Dropdown</a>
        </li>
        <li class="submenu-item @yield('list-group')">
            <a href="/template/list-group">List Group</a>
        </li>
        <li class="submenu-item @yield('modal')">
            <a href="/template/modal">Modal</a>
        </li>
        <li class="submenu-item @yield('navs')">
            <a href="/template/navs">Navs</a>
        </li>
        <li class="submenu-item @yield('pagination')">
            <a href="/template/pagination">Pagination</a>
        </li>
        <li class="submenu-item @yield('progress')">
            <a href="/template/progress">Progress</a>
        </li>
        <li class="submenu-item @yield('spinner')">
            <a href="/template/spinner">Spinner</a>
        </li>
        <li class="submenu-item @yield('toast')">
            <a href="/template/toast">Toasts</a>
        </li>
        <li class="submenu-item @yield('tooltip')">
            <a href="/template/tooltip">Tooltip</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-collection-fill"></i>
        <span>Extra Components</span>
    </a>
    <ul class="submenu @yield('extra')">
        <li class="submenu-item @yield('avatar')">
            <a href="/template/avatar">Avatar</a>
        </li>
        <li class="submenu-item @yield('sweetalert')">
            <a href="/template/sweetalert">Sweet Alert</a>
        </li>
        <li class="submenu-item @yield('toastify')">
            <a href="/template/toastify">Toastify</a>
        </li>
        <li class="submenu-item @yield('rating')">
            <a href="/template/rating">Rating</a>
        </li>
        <li class="submenu-item @yield('divider')">
            <a href="/template/divider">Divider</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Layouts</span>
    </a>
    <ul class="submenu @yield('layouts')">
        <li class="submenu-item @yield('defaults')">
            <a href="/template/defaults">Default Layout</a>
        </li>
        <li class="submenu-item @yield('vertical-column')">
            <a href="/template/vertical-column">1 Column</a>
        </li>
        <li class="submenu-item @yield('vertical-navbar')">
            <a href="/template/vertical-navbar">Vertical Navbar</a>
        </li>
        <li class="submenu-item @yield('rtl')">
            <a href="/template/rtl">RTL Layout</a>
        </li>
        <li class="submenu-item @yield('horizontal')">
            <a href="/template/horizontal">Horizontal Menu</a>
        </li>
    </ul>
</li>

<li class="sidebar-title">Forms &amp; Tables</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-hexagon-fill"></i>
        <span>Form Elements</span>
    </a>
    <ul class="submenu @yield('forms')">
        <li class="submenu-item @yield('input')">
            <a href="/template/input">Input</a>
        </li>
        <li class="submenu-item @yield('input-groups')">
            <a href="/template/input-group">Input Group</a>
        </li>
        <li class="submenu-item @yield('select')">
            <a href="/template/select">Select</a>
        </li>
        <li class="submenu-item  @yield('radio')">
            <a href="/template/radio">Radio</a>
        </li>
        <li class="submenu-item @yield('checkbox')">
            <a href="/template/checkbox">Checkbox</a>
        </li>
        <li class="submenu-item @yield('textarea')">
            <a href="/template/textarea">Textarea</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  @yield('form-layouts')">
    <a href="/template/layout" class='sidebar-link'>
        <i class="bi bi-file-earmark-medical-fill"></i>
        <span>Form Layout</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-journal-check"></i>
        <span>Form Validation</span>
    </a>
    <ul class="submenu @yield('form-validation')">
        <li class="submenu-item @yield('parsley')">
            <a href="/template/form-validation">Parsley</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-pen-fill"></i>
        <span>Form Editor</span>
    </a>
    <ul class="submenu @yield('editor')">
        <li class="submenu-item @yield('quill')">
            <a href="/template/quil">Quill</a>
        </li>
        <li class="submenu-item @yield('ck')">
            <a href="/template/ckeditor">CKEditor</a>
        </li>
        <li class="submenu-item @yield('summer')">
            <a href="/template/summernote">Summernote</a>
        </li>
        <li class="submenu-item @yield('tiny')">
            <a href="/template/tinymce">TinyMCE</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  @yield('table')">
    <a href="/template/table" class='sidebar-link'>
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Table</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
        <span>Datatables</span>
    </a>
    <ul class="submenu @yield('datatable')">
        <li class="submenu-item @yield('datatable2')">
            <a href="/template/datatable">Datatable</a>
        </li>
        <li class="submenu-item @yield('datatable-jquery')">
            <a href="/template/datatable-jquery">Datatable (jQuery)</a>
        </li>
    </ul>
</li>

<li class="sidebar-title">Extra UI</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-pentagon-fill"></i>
        <span>Widgets</span>
    </a>
    <ul class="submenu @yield('widgets')">
        <li class="submenu-item @yield('chatbox')">
            <a href="/template/chatbox">Chatbox</a>
        </li>
        <li class="submenu-item @yield('pricing')">
            <a href="/template/pricing">Pricing</a>
        </li>
        <li class="submenu-item @yield('todolist')">
            <a href="/template/todolist">To-do List</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-egg-fill"></i>
        <span>Icons</span>
    </a>
    <ul class="submenu @yield('icons')">
        <li class="submenu-item @yield('bootstrap')">
            <a href="/template/bootstrap-icons">Bootstrap Icons </a>
        </li>
        <li class="submenu-item @yield('fontawesome')">
            <a href="/template/fontawesome">Fontawesome</a>
        </li>
        <li class="submenu-item @yield('dripicons')">
            <a href="/template/dripicons">Dripicons</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-bar-chart-fill"></i>
        <span>Charts</span>
    </a>
    <ul class="submenu @yield('chart')">
        <li class="submenu-item @yield('js')">
            <a href="/template/chartjs">ChartJS</a>
        </li>
        <li class="submenu-item @yield('apex')">
            <a href="/template/apexcharts">Apexcharts</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  @yield('file')">
    <a href="/template/file-uploader" class='sidebar-link'>
        <i class="bi bi-cloud-arrow-up-fill"></i>
        <span>File Uploader</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-map-fill"></i>
        <span>Maps</span>
    </a>
    <ul class="submenu @yield('maps')">
        <li class="submenu-item @yield('google')">
            <a href="/template/google-map">Google Map</a>
        </li>
        <li class="submenu-item @yield('vector')">
            <a href="/template/jsvectormap">JS Vector Map</a>
        </li>
    </ul>
</li>

<li class="sidebar-title">Pages</li>

<li class="sidebar-item  @yield('email')">
    <a href="/template/email" class='sidebar-link'>
        <i class="bi bi-envelope-fill"></i>
        <span>Email Application</span>
    </a>
</li>

<li class="sidebar-item  @yield('chat')">
    <a href="/template/chat" class='sidebar-link'>
        <i class="bi bi-chat-dots-fill"></i>
        <span>Chat Application</span>
    </a>
</li>

<li class="sidebar-item  @yield('gallery')">
    <a href="/template/gallery" class='sidebar-link'>
        <i class="bi bi-image-fill"></i>
        <span>Photo Gallery</span>
    </a>
</li>

<li class="sidebar-item  @yield('checkout')">
    <a href="/template/checkout" class='sidebar-link'>
        <i class="bi bi-basket-fill"></i>
        <span>Checkout Page</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-person-badge-fill"></i>
        <span>Authentication</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="/template/login">Login</a>
        </li>
        <li class="submenu-item ">
            <a href="/template/register">Register</a>
        </li>
        <li class="submenu-item ">
            <a href="/template/forgot-password">Forgot Password</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-x-octagon-fill"></i>
        <span>Errors</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="/template/error-403">403</a>
        </li>
        <li class="submenu-item ">
            <a href="/template/error-404">404</a>
        </li>
        <li class="submenu-item ">
            <a href="/template/error-500">500</a>
        </li>
    </ul>
</li>

<li class="sidebar-title">Raise Support</li>

<li class="sidebar-item  ">
    <a href="https://zuramai.github.io/mazer/docs" class='sidebar-link'>
        <i class="bi bi-life-preserver"></i>
        <span>Documentation</span>
    </a>
</li>

<li class="sidebar-item  ">
    <a href="https://github.com/zuramai/mazer/blob/main/CONTRIBUTING.md" class='sidebar-link'>
        <i class="bi bi-puzzle"></i>
        <span>Contribute</span>
    </a>
</li>

<li class="sidebar-item  ">
    <a href="https://github.com/zuramai/mazer#donation" class='sidebar-link'>
        <i class="bi bi-cash"></i>
        <span>Donate</span>
    </a>
</li>
