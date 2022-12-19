<div class="nk-sidebar-menu" data-simplebar>
    <ul class="nk-menu">
        {{-- @if(auth()->check() && auth()->user()->role_id==5) --}}
        @can('permission',94)
        <li class="nk-menu-item">
            <a href="{{ route('writers.assigned.index') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-icon">
                    <em class="icon ni ni-plus-round"></em>
                </span>
                <span class="nk-menu-text">Assigned Orders <label class="label label-primary writer_assigned_orders"></label></span>
            </a>
            <a href="{{ route('writers.delivered.index') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-icon">
                    <em class="icon ni ni-notice"></em>
                </span>
                <span class="nk-menu-text">Delivered Orders</span>
            </a>
            <a href="{{ route('writers.modified.index') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-icon">
                    <em class="icon ni ni-check-c"></em>
                </span>
                <span class="nk-menu-text">Modified Orders <label class="label label-primary writer_modification_orders"></label></span>
            </a>
            <a href="{{ route('writers.completed.index') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-icon">
                    <em class="icon ni ni-check-round-cut"></em>
                </span>
                <span class="nk-menu-text">Completed Orders</span>
            </a>
            <a href="{{ route('writers.canceled.index') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-icon">
                    <em class="icon ni ni-cross-round"></em>
                </span>
                <span class="nk-menu-text">Canceled Orders</span>
            </a>
        </li>
        @endcan
        {{-- @elseif(auth()->check() && auth()->user()->role_id==4) --}}
       {{--  <li class="nk-menu-item">
            <a href="{{ route('writersqa.orders.index') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-icon">
                    <em class="icon ni ni-plus-round"></em>
                </span>
                <span class="nk-menu-text">Delivered Orders</span>
            </a>
        </li> --}}
        {{-- @else --}}
        @can('permission',1)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['regions.index','regions.create','regions.edit',['region'=>$model->id ?? ""],'tiers.index','tiers.create','tiers.edit',['tier'=>$model->id ?? ""],'domains.index','domains.create','domains.edit',['domain'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-globe"></em></span>
                <span class="nk-menu-text">Websites Management</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    @can('permission',2)
                    <a href="{{ route('regions.index') }}" class="nk-menu-link @if(Request::url()=='regions.index') active @endif"><span class="nk-menu-text">Regions</span></a>
                    @endcan
                    @can('permission',6)
                    <a href="{{ route('tiers.index') }}" class="nk-menu-link @if(Request::url()=='tiers.index') active @endif"><span class="nk-menu-text">Tiers</span></a>
                    @endcan
                    @can('permission',10)
                    <a href="{{ route('domains.index') }}" class="nk-menu-link @if(Request::url()=='domains.index') active @endif"><span class="nk-menu-text">Domains</span></a>
                    @endcan
                </li>
            </ul>
        </li>
        @endcan
        @can('permission',14)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['price-plans.index','price-plans.create','price-plans.edit',['price-plan'=>$model->id ?? ""],'priceplan.type-of-works.index','priceplan.type-of-works.create','priceplan.type-of-works.edit',['priceplan.type_of_work'=>$model->id ?? ""],'priceplan.levels.index','priceplan.levels.create','priceplan.levels.edit',['level'=>$model->id ?? ""],'priceplan.urgencies.index','priceplan.urgencies.create','priceplan.urgencies.edit',['urgency'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-sign-sgd"></em></span>
                <span class="nk-menu-text">Price Plan Management</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    @can('permission',21)
                    <a href="{{ route('priceplan.type-of-works.index') }}" class="nk-menu-link @if(Request::url()=='priceplan.type-of-works.index') active @endif"><span class="nk-menu-text">Type of Work</span></a>
                    @endcan
                    @can('permission',25)
                    <a href="{{ route('priceplan.levels.index') }}" class="nk-menu-link @if(Request::url()=='priceplan.type-of-works.index') active @endif"><span class="nk-menu-text">Levels</span></a>
                    @endcan
                    @can('permission',29)
                    <a href="{{ route('priceplan.urgencies.index') }}" class="nk-menu-link @if(Request::url()=='priceplan.urgencies.index') active @endif"><span class="nk-menu-text">Urgencies</span></a>
                    @endcan
                    @can('permission',15)
                    <a href="{{ route('price-plans.index') }}" class="nk-menu-link @if(Request::url()=='price-plans.index') active @endif"><span class="nk-menu-text">Price Plan</span></a>
                    @endcan
                </li>
            </ul>
        </li>
        @endcan
        @can('permission',33)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['regions.index','regions.create','regions.edit',['region'=>$model->id ?? ""],'tiers.index','tiers.create','tiers.edit',['tier'=>$model->id ?? ""],'domains.index','domains.create','domains.edit',['domain'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                <span class="nk-menu-text">Customers</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    @can('permission',34)
                    <a href="{{ route('customers.index') }}" class="nk-menu-link @if(Request::url()=='customers.index') active @endif"><span class="nk-menu-text">Customers</span></a>
                    @endcan
                </li>
            </ul>
        </li>
        @endcan
        @can('permission',41)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['regions.index','regions.create','regions.edit',['region'=>$model->id ?? ""],'tiers.index','tiers.create','tiers.edit',['tier'=>$model->id ?? ""],'domains.index','domains.create','domains.edit',['domain'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-chat-circle-fill"></em></span>
                <span class="nk-menu-text">Leads <label class="label label-primary new_lead" id="new_lead" class="badge badge-success"></label></span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    {{-- <a href="{{ route('leads.statuses.index') }}" class="nk-menu-link @if(Request::url()=='leads.statuses.index') active @endif"><span class="nk-menu-text">Statuses</span></a> --}}
                    {{-- <a href="{{ route('leads.channels.index') }}" class="nk-menu-link @if(Request::url()=='leads.channels.index') active @endif"><span class="nk-menu-text">Channels</span></a> --}}
                    @can('permission',42)
                    <a href="{{ route('leads.index') }}" class="nk-menu-link @if(Request::url()=='leads.index') active @endif"><span class="nk-menu-text">Leads</span><label class="label label-primary new_lead" id="new_lead" class="badge badge-success"></label></a>
                    @endcan
                </li>
            </ul>
        </li>
        @endcan
        {{-- <li class="nk-menu-item">
            <a href="{{route('price-plans.index')}}" class="nk-menu-link">
                <span class="nk-menu-icon"><em class="icon ni ni-bitcoin-cash"></em></span>
                <span class="nk-menu-text">Price Plan Management</span>
            </a>
        </li> --}}
        @can('permission',49)
        <li class="nk-menu-item has-sub">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2-fill"></em></span>
                <span class="nk-menu-text">Orders <label class="label label-primary total_orders" id="total_orders" class="badge badge-success"></label></span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    @can('permission',50)
                    <a href="{{ route('orders.payment_awaiting')}}" class="nk-menu-link"><span class="nk-menu-text">Payment Awaiting Orders <label class="label label-primary payment_awaiting_orders" id="payment_awaiting_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',61)
                    <a href="{{ route('orders.pending')}}" class="nk-menu-link"><span class="nk-menu-text">Pending Orders <label class="label label-primary pending_orders" id="pending_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',66)
                    <a href="{{ route('orders.assigned')}}" class="nk-menu-link"><span class="nk-menu-text">Assigned Orders <label class="label label-primary assigned_orders" id="assigned_orders" class="badge badge-success"></label> </span></a>
                    @endcan
                    @can('permission',67)
                    <a href="{{ route('orders.writer_delivery')}}" class="nk-menu-link"><span class="nk-menu-text">Writer Delivered Orders <label class="label label-primary writer_delivery_orders" id="writer_delivery_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',68)
                    <a href="{{ route('orders.delivered')}}" class="nk-menu-link"><span class="nk-menu-text">Delivered Orders <label class="label label-primary delivered_orders" id="delivered_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',69)
                    <a href="{{ route('orders.modified')}}" class="nk-menu-link"><span class="nk-menu-text">Modified Orders <label class="label label-primary modified_orders" id="modified_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',70)
                    <a href="{{ route('orders.completed')}}" class="nk-menu-link"><span class="nk-menu-text">Completed Orders <label class="label label-primary completed_orders" id="completed_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',71)
                    <a href="{{ route('orders.canceled')}}?status=7" class="nk-menu-link"><span class="nk-menu-text">Canceled Orders <label class="label label-primary canceled_orders" id="canceled_orders" class="badge badge-success"></label></span></a>
                    @endcan
                    @can('permission',72)
                    <a href="{{ route('orders.index')}}" class="nk-menu-link"><span class="nk-menu-text">All Orders</span></a>
                    @endcan
                    {{-- <a href="{{ route('orders.index')}}?status=deleted" class="nk-menu-link"><span class="nk-menu-text">Deleted Orders</span></a> --}}
                    @can('permission',73)
                    <a href="{{ route('orders.search.index')}}" class="nk-menu-link"><span class="nk-menu-text">Search</span></a>
                    @endcan
                </li>
            </ul>
        </li>
        @endcan
        @can('permission',74)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['roles.index','roles.create','roles.edit',['role'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-gift"></em></span>
                <span class="nk-menu-text">Discount Coupons</span>
            </a>
            <ul class="nk-menu-sub">
                @can('permission',75)
                <li class="nk-menu-item">
                    <a href="{{ route('coupons.index') }}" class="nk-menu-link @if(Request::url()=='coupons.index') active @endif"><span class="nk-menu-text">Coupon</span></a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('permission',79)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['roles.index','roles.create','roles.edit',['role'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span>
                <span class="nk-menu-text">Roles & Permissions Management</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    @can('permission',83)
                    <a href="{{ route('permissions.index') }}" class="nk-menu-link @if(Request::url()=='permissions.index') active @endif"><span class="nk-menu-text">Permissions</span></a>
                    @endcan
                    @can('permission',84)
                    <a href="{{ route('roles.index') }}" class="nk-menu-link @if(Request::url()=='roles.index') active @endif"><span class="nk-menu-text">Roles</span></a>
                    @endcan
                </li>
            </ul>
        </li>
        @endcan
        @can('permission',88)
        <li class="nk-menu-item has-sub @if(in_array(Request::url(), ['users.index','users.create','users.edit',['user'=>$model->id ?? ""]])) active @endif">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                <span class="nk-menu-text">Users Management</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    @can('permission',89)
                    <a href="{{ route('users.index') }}" class="nk-menu-link @if(Request::url()=='users.index') active @endif"><span class="nk-menu-text">Users</span></a>
                    @endcan
                    {{-- <a href="{{ route('users.index','q=writers') }}" class="nk-menu-link @if(Request::url()=='users.index') active @endif"><span class="nk-menu-text">Writers</span></a> --}}
                    {{-- <a href="{{ route('users.index','q=sales') }}" class="nk-menu-link @if(Request::url()=='users.index') active @endif"><span class="nk-menu-text">Sales</span></a> --}}
                </li>
            </ul>
        </li>
        @endcan
        {{-- <li class="nk-menu-item">
            <a href="html/index-analytics.html" class="nk-menu-link">
                <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                <span class="nk-menu-text">Analytics Dashboard</span>
            </a>
        </li> --}}
        {{-- @endif --}}

    </ul>
</div>