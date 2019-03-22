<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ access()->user()->picture }}" class="img-circle" alt="User Image" />
            </div><!--pull-left-->
            <div class="pull-left info">
                <p>{{ access()->user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('strings.backend.general.status.online') }}</a>
            </div><!--pull-left-->
        </div><!--user-panel-->

        <!-- search form (Optional) -->
        {{ Form::open(['route' => 'admin.search.index', 'method' => 'get', 'class' => 'sidebar-form']) }}
        <div class="input-group">
            {{ Form::text('q', Request::get('q'), ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('strings.backend.general.search_placeholder')]) }}

            <span class="input-group-btn">
                    <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span><!--input-group-btn-->
        </div><!--input-group-->
    {{ Form::close() }}
    <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>

            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>

            {{-- <li class="{{ active_class(Active::checkUriPattern('admin/push-notifications')) }}">
                <a href="{{ route('admin.push-notifications') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Push Notification</span>
                </a>
            </li> --}}
            <li class="{{ active_class(Active::checkUriPattern('admin/parents')) }}">
                <a href="{{ route('admin.parents.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Parents</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/sitters')) }}">
                <a href="{{ route('admin.sitters.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Sitters</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/booking')) }}">
                <a href="{{ route('admin.booking.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Bookings</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/payment')) }}">
                <a href="{{ route('admin.payment.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Payments</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/plans')) }}">
                <a href="{{ route('admin.plans.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Plans</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/activation')) }}">
                <a href="{{ route('admin.activation.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Activation</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/messages')) }}">
                <a href="{{ route('admin.messages.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Manage Messages</span>
                </a>
            </li>

            <li class="header">{{ trans('menus.backend.sidebar.system') }}</li>

            @role(1)
            <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('menus.backend.access.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                        <a href="{{ route('admin.access.user.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.users.management') }}</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                        <a href="{{ route('admin.access.role.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.roles.management') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth

            <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer*')) }} treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer')) }}">
                        <a href="{{ route('log-viewer::dashboard') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.dashboard') }}</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer/logs')) }}">
                        <a href="{{ route('log-viewer::logs.list') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.logs') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>