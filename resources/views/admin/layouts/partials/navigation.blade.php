{{-- Struktur view navigasi --}}
<div class="sidebar-header">
	<div class="d-flex justify-content-between">
		<div class="logo">
			<a href="/admin/dashboard">Aradev</a>
		</div>
		<div class="toggler">
			<a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
		</div>
	</div>
</div>
<div class="sidebar sidebar-menu">
	<ul class="menu">
		@include('admin.layouts.components.sidebar.menu')

	</ul>
</div>
<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>


<script>

document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(element){

    element.addEventListener('click', function (e) {

      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;

        if(nextEl) {
            e.preventDefault();
            let mycollapse = new bootstrap.Collapse(nextEl);

            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
});
// DOMC
</script>
