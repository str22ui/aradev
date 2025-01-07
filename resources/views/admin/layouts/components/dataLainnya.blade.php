<li class="sidebar-item {{ Request::is('admin/article*') || Request::is('admin/createArticle*') || Request::is('admin/editArticle*') || Request::is('admin/showArticle*') || Request::is('admin/announcement*') || Request::is('admin/createAnnouncement*') || Request::is('admin/editAnnouncement*') || Request::is('admin/showAnnouncement*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#postData" aria-expanded="false" aria-controls="postData">
        <i class="bi bi-database-fill"></i>
        <span>Lainnya</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="postData" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
     {{-- konsumen --}}
     <li class="sidebar-item {{ Request::is('admin/konsumen*') || Request::is('admin/createKonsumen*') || Request::is('admin/editKonsumen*') || Request::is('admin/showKonsumen*') ? 'active' : '' }}">
        <a href="{{ route('admin.konsumen') }}" class='sidebar-link'>
            <i class="bi bi-people-fill"></i>
            <span>Info & Education</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('admin/penawaran*') || Request::is('admin/createPenawaran*') || Request::is('admin/editPenawaran*') || Request::is('admin/showPenawaran*') ? 'active' : '' }}">
        <a href="{{ route('admin.penawaran') }}" class='sidebar-link'>
            <i class="bi bi-file-earmark-text-fill"></i>
            <span>Testimony<span>
        </a>
    </li>

</ul>
