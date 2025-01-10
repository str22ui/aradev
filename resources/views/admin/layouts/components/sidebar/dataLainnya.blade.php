<li class="sidebar-item {{ Request::is('admin/article*') || Request::is('admin/createArticle*') || Request::is('admin/editArticle*') || Request::is('admin/showArticle*') || Request::is('admin/announcement*') || Request::is('admin/createAnnouncement*') || Request::is('admin/editAnnouncement*') || Request::is('admin/showAnnouncement*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#postLain" aria-expanded="false" aria-controls="postDaa">
        <i class="bi bi-database-fill"></i>
        <span>Lainnya</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="postLain" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
     {{-- konsumen --}}
     <li class="sidebar-item {{ Request::is('admin/info*') || Request::is('admin/createInfo*') || Request::is('admin/editInfo*') || Request::is('admin/showInfo*') ? 'active' : '' }}">
        <a href="{{ route('admin.info') }}" class='sidebar-link'>
            <i class="bi bi-info-circle-fill"></i>
            <span>Info & Education</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('admin/testimony*') || Request::is('admin/createTestimony*') || Request::is('admin/editTestimony*') || Request::is('admin/showTestimony*') ? 'active' : '' }}">
        <a href="{{ route('admin.testimony') }}" class='sidebar-link'>
            <i class="bi bi-chat-dots-fill"></i>
            <span>Testimony<span>
        </a>
    </li>

</ul>
