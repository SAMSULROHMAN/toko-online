<ul class="polished-sidebar-menu ml-0 pt-4 p-0 d-md-block">
    <input class="border-dark form-control d-block d-md-none mb-4" type="text" placeholder="Search" aria-label="Search" />
    <li><a href="/home"><span class="oi oi-home"></span>Home</a></li>
    <li><a href="/users"><span class="oi oi-people"></span>Manage User</a></li>
    <li><a href="/categories"><span class="oi oi-tag"></span>Manage Categories</a></li>
    <li><a href="{{route('books.index')}}"><span class="oi oi-book"></span>Manage books</a></li>
    <li><a href="{{route('orders.index')}}"><span class="oi oi-inbox"></span>Manage orders</a></li>
    <div class="d-block d-md-none">
        <div class="dropdown-divider"></div>
        <li><a href="#"> Profile</a></li>
        <li><a href="#"> Setting</a></li>
        <li>
            <form action="{{route("logout")}}" method="POST">
            @csrf
            <button class="dropdown-item" style="cursor:pointer">Sign Out</button>
            </form>
        </li>
    </div>
</ul>
