<li>
    <a href="#"><i class="fa {{ $module['icon'] or 'fa-navicon' }} fa-fw"></i> {{ $module['title'] }}<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li>
            <a href="{{ route('admin.' . $module['name'] . '.index') }}">List</a>
        </li>
        <li>
            <a href="{{ route('admin.' . $module['name'] . '.create') }}">Create</a>
        </li>
        <li>
            <a href="{{ route('admin.' . $module['name'] . '.order') }}">Order</a>
        </li>
        <li>
            <a href="{{ route('admin.helpergroup.index') }}">Group List</a>
        </li>
        <li>
            <a href="{{ route('admin.helpergroup.create') }}">Group Create</a>
        </li>
        <li>
            <a href="{{ route('admin.helpergroup.menu') }}">Group Tree</a>
        </li>
    </ul>
    <!-- /.nav-second-level -->
</li>
