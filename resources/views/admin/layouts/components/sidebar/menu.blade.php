<li class="sidebar-title">
    Halo, {{ Auth::check() ? Auth::user()->name : 'Guest' }}
</li>
{{-- Dashboard --}}
<li class="sidebar-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.index') }}"  class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Home</span>
    </a>
</li>

{{-- User --}}
@if (auth()->user()->role === 'admin')
<li class="sidebar-item {{ Request::is('admin/user*') || Request::is('admin/createUser*') || Request::is('admin/editUser*') || Request::is('admin/showUser*') ? 'active' : '' }}">
    <a href="{{ route('admin.user') }}" class='sidebar-link'>
        <i class="bi bi-person-circle"></i>
        <span>User</span>
    </a>
</li>
@endif

@include('admin.layouts.components.sidebar.masterRumah')
@include('admin.layouts.components.sidebar.dataKonsumen')

@if (auth()->user()->role !== 'sales')
@include('admin.layouts.components.sidebar.dataAgent')
@endif


{{-- Report --}}
<li class="sidebar-item {{ Request::is('admin/report*') || Request::is('admin/createReport*') || Request::is('admin/editReport*') || Request::is('admin/showReport*') ? 'active' : '' }}">
    <a href="{{ route('admin.report') }}" class='sidebar-link'>
        <i class="bi bi-journal-album"></i>
        <span>Call Report</span>
    </a>
</li>

@if (auth()->user()->role !== 'sales')
@include('admin.layouts.components.sidebar.dataLainnya')
@endif
{{-- Logout --}}
<li class="sidebar-item">
    <form method="POST" action="/logout" id="logout">
        @csrf
        <a href="" class='sidebar-link'>
            <i class="bi bi-box-arrow-left text-danger"></i>
            <span>Logout</span>
        </a>
    </form>
</li>


