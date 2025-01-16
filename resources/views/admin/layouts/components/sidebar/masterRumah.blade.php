{{-- Data Master --}}
<li class="sidebar-item {{ Request::is('admin/category*') || Request::is('admin/createCategory*') || Request::is('admin/editCategory*') || Request::is('admin/position*') || Request::is('admin/createPosition*') || Request::is('admin/editPosition*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <i class="bi bi-folder2-open"></i>
        <span>Master Rumah</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
    <li class="sidebar-item {{ Request::is('admin/perumahan*') || Request::is('admin/createPerumahan*') || Request::is('admin/editPerumahan*') || Request::is('admin/showPerumahan*') ? 'active' : '' }}">
        <a href="{{ route('admin.perumahan') }}" class='sidebar-link'>
            <i class="bi bi-house-gear-fill"></i>
            <span>Primary</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('admin/secondary-home*') || Request::is('admin/createSecondary*') || Request::is('admin/editSecondary*') || Request::is('admin/showSecondary*') ? 'active' : '' }}">
        <a href="{{ route('admin.secondary-home') }}" class='sidebar-link'>
            <i class="bi  bi-houses-fill"></i>
            <span>Secondary</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('admin/land*') || Request::is('admin/createLand*') || Request::is('admin/editLand*') || Request::is('admin/showLand*') ? 'active' : '' }}">
        <a href="{{ route('admin.land') }}" class='sidebar-link'>
            <i class="bi bi-pin-map-fill"></i>
            <span>Land</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('admin/rumah*') || Request::is('admin/createRumah*') || Request::is('admin/editRumah*') || Request::is('admin/showRumah*') ? 'active' : '' }}">
        <a href="{{ route('admin.rumah') }}" class='sidebar-link'>
            <i class="bi bi bi-house-door"></i>
            <span>Rumah</span>
        </a>
    </li>
</ul>
