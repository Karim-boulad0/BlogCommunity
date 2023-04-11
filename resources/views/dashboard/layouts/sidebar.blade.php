<style>
    .post {
        padding-top: 15px;
        border-bottom: white solid 3px;
    }

    .category {
        border-bottom: white solid 3px;
    }

    .user {
        border-bottom: white solid 3px;
    }
</style>
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            {{-- posts --}}
            <div class="post">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.posts.create') }}"><i class="fa fa-map-o"
                            aria-hidden="true"></i>

                        {{ __('words.add post') }} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.posts.index') }}"><i class="fa fa-map-o"
                            aria-hidden="true"></i>
                        {{ __('words.posts') }}</a>
                </li>
            </div>

            {{-- categories --}}
            <div class="category">
                <li class="nav-item">
                    @can('view', $settings)
                        <a class="nav-link" href="{{ route('dashboard.Category.create') }}"><i class="fa fa-plus"
                                aria-hidden="true"></i>

                            {{ __('words.add category') }} </a>
                    @endcan
                    <a class="nav-link" href="{{ route('dashboard.Category.index') }}"><i class="fa fa-bars"
                            aria-hidden="true"></i>
                        {{ __('words.categories') }}</a>
                </li>
                <li class="nav-title">
                </li>

            </div>
            <div class="user">
                @can('view', $settings)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.users.create') }}"><i
                                class="icon-user-following"></i>{{ __('words.add user') }}</a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.users.index') }}"> <i
                            class="icon-people"></i>{{ __('words.users') }}</a>
                </li>
            </div>
            {{-- setting and logout --}}
            @can('view', $settings)
                <li class="nav-item">
                    {{-- setting --}}
                    <a class="nav-link" href="{{ route('dashboard.settings') }}"><i class="fa fa-cog"
                            aria-hidden="true"></i>
                        {{ __('words.settings') }}</a>
                    {{-- logout --}}
                    <a class="nav-link" href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>
                        {{ __('words.logout') }}</a>
                @endcan

            </li>
        </ul>
    </nav>
</div>
