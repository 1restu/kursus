<div class="sidebar" id="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <i class="bi bi-house-door"></i>
                <span class="ms-2">Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <i class="bi bi-speedometer2"></i>
                <span class="ms-2">Overview</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <i class="bi bi-wand"></i>
                <span class="ms-2">Magic build</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <i class="bi bi-cloud-upload"></i>
                <span class="ms-2">Upload new</span>
            </a>
        </li>
        <li class="nav-item mt-auto mb-2">
            <a class="nav-link d-flex align-items-center expand_sidebar" href="#" id="sidebarExpand">
                <i class="bi bi-arrow-right-circle"></i>
                <span class="ms-2">Expand</span>
            </a>
            <a class="nav-link d-flex align-items-center collapse_sidebar" href="#" id="sidebarCollapse">
                <i class="bi bi-arrow-left-circle"></i>
                <span class="ms-2">Collapse</span>
            </a>
        </li>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('collapsed');
    });

    document.getElementById('sidebarCollapse').addEventListener('click', function () {
        document.getElementById('sidebar').classList.add('collapsed');
    });

    document.getElementById('sidebarExpand').addEventListener('click', function () {
        document.getElementById('sidebar').classList.remove('collapsed');
    });
</script>