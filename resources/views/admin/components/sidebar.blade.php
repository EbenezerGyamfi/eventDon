<div class="sidebar-wrapper">
    <ul class="nav">
        <li>
            <a href="{{ route('admin.home') }}">
                <i class="nc-icon nc-bank"></i>
                <p>Home</p>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.events.index') }}">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <p>Events</p>
            </a>
        </li>
        <li>

            <a href="{{ route('admin.users.index') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                <p>Users</p>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                <p>Subscriptions</p>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.transactions.index') }}">
                <i class="fa fa-money"></i>
                <p>Transactions</p>
            </a>
        </li>
        <li class="dropdown">
            <a href="javascript:;" class="dropbtn">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                <p>Report</p>
            </a>


            <div class="dropdown-content">
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
            </div>
        </li>
        <li>
            <a href="javascript:;">
                <i class="bi bi-gear"></i>
                <p>Settings</p>
            </a>
        </li>
    </ul>
</div>
