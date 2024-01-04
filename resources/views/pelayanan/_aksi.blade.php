<div class="dropdown">
  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
    <i class="bx bx-dots-horizontal-rounded"></i>
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ $url_edit }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
    <a class="dropdown-item" href="{{ $url_hapus }}" onclick="return confirm('Kamu yakin ingin data ini ?')"><i class="bx bx-trash me-1"></i> Hapus</a>
  </div>
</div>