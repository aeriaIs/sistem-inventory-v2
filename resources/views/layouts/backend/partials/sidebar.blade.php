<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item active">
          <a href="#" class="nav-link font-weight-bold"><i class="fas fa-fire"></i><span>Dashboard</span></a> 
        </li>
        <li class="menu-header">Starter</li>
        <li><a class="nav-link" href="{{ route('supplier.index') }}"><i class="far fa-square"></i> <span>Supplier</span></a></li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Product</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('product.index') }}">Product</a></li>
            <li><a class="nav-link" href="{{ route('product.create') }}">Tambah Product</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Order</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('order.index') }}">Order</a></li>
            <li><a class="nav-link" href="{{ route('order.create') }}">Tambah Order</a></li>
          </ul>
        </li>
        <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
      </ul>
  </aside>
</div>