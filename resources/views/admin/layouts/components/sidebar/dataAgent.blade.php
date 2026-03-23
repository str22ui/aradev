{{-- @if (auth()->user()->role !== 'salesAdmin') --}}

<li
    class="sidebar-item {{ Request::is('admin/article*') || Request::is('admin/createArticle*') || Request::is('admin/editArticle*') || Request::is('admin/showArticle*') || Request::is('admin/announcement*') || Request::is('admin/createAnnouncement*') || Request::is('admin/editAnnouncement*') || Request::is('admin/showAnnouncement*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#postAgent" aria-expanded="false"
        aria-controls="postData">
        <i class="bi bi-person-bounding-box"></i>
        <span>Data Agent</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="postAgent" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
    @if (auth()->user()->role !== 'sales')
    {{-- konsumen --}}
    <li
        class="sidebar-item {{ Request::is('admin/agent*') || Request::is('admin/createAgent*') || Request::is('admin/editAgent*') || Request::is('admin/showAgent*') ? 'active' : '' }}">
        <a href="{{ route('admin.agent') }}" class='sidebar-link'>
            <i class="bi bi-person-rolodex"></i>
            <span>Agent</span>
        </a>
    </li>

    <li
        class="sidebar-item {{ Request::is('admin/sales*') || Request::is('admin/createSales*') || Request::is('admin/editSales*') || Request::is('admin/showSales*') ? 'active' : '' }}">
        <a href="{{ route('admin.sales') }}" class='sidebar-link'>
            <i class="bi bi-person-walking"></i>
            <span>Sales</span>
        </a>
    </li>
    @endif
    <li
        class="sidebar-item {{ Request::is('admin/affiliate*') || Request::is('admin/createAffiliate*') || Request::is('admin/editAffiliate*') || Request::is('admin/showAffiliate*') ? 'active' : '' }}">
        <a href="{{ route('admin.affiliate') }}" class='sidebar-link'>
            <i class="bi bi-person-up"></i>
            <span>Affiliate</span>
        </a>
    </li>
</ul>
{{-- @endif --}}
