<li>
    <a href="#"><i class="fa {{ $module['icon'] or 'fa-navicon' }} fa-fw"></i> {{ $module['title'] }}<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li>
            <a href="{{ route('admin.' . $module['name'] . '.index') }}">List</a>
        </li>
        <li>
            <a href="{{ route('admin.' . $module['name'] . '.create') }}">Create</a>
        </li>
    </ul>
    <!-- /.nav-second-level -->
</li>
