<nav class="navbar navbar-expand-lg navbar-bg" id="navbar">
    <div class="container">
        <x-utils.link
            :href="route('frontend.index')"
            :text="appName()"
            class="navbar-brand" />

        <button class="navbar-toggler navbar-toggler-right border-0 collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
            <span class="navbar-toggler-icon icon-bar top-bar"></span>
            <span class="navbar-toggler-icon icon-bar middle-bar"></span>
            <span class="navbar-toggler-icon icon-bar bottom-bar"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- 在左邊的功能 --}}
            <ul class="navbar-nav mr-auto">
                {{-- 文章投稿列表 --}}
                <li class="nav-item p-1">
                    <x-utils.link
                        :href="route('frontend.social.cards.index')"
                        :active="activeClass(Route::is('frontend.social.cards.index'))"
                        :text="__('Init.Engineer Submit')"
                        class="nav-link" />
                </li>
                {{-- 工作 --}}
                <li class="nav-item p-1">
                    <x-utils.link
                        {{-- :href="route('frontend.jobs.index')" --}}
                        {{-- :active="activeClass(Route::is('frontend.jobs.index'))" --}}
                        :text="__('Init.Engineer Jobs')"
                        class="nav-link" />
                </li>

                {{-- 接案 --}}
                <li class="nav-item p-1">
                    <x-utils.link
                        {{-- :href="route('frontend.case.index')" --}}
                        {{-- :active="activeClass(Route::is('frontend.case.index'))" --}}
                        :text="__('Init.Engineer Case')"
                        class="nav-link" />
                </li>

                {{-- 活動 --}}
                <li class="nav-item p-1">
                    <x-utils.link
                        {{-- :href="route('frontend.events.index')" --}}
                        {{-- :active="activeClass(Route::is('frontend.events.index'))" --}}
                        :text="__('Init.Engineer Events')"
                        class="nav-link" />
                </li>

                {{-- 研討會 --}}
                <li class="nav-item p-1">
                    <x-utils.link
                        {{-- :href="route('frontend.conference.index')" --}}
                        {{-- :active="activeClass(Route::is('frontend.conference.index'))" --}}
                        :text="__('Init.Engineer Conference')"
                        class="nav-link" />
                </li>
            </ul>

            {{-- 在右邊的功能 --}}
            <ul class="navbar-nav ml-auto">
                {{-- @if(config('boilerplate.locale.status') && count(config('boilerplate.locale.languages')) > 1)
                    <li class="nav-item dropdown p-1">
                        <x-utils.link
                            :text="__(getLocaleName(app()->getLocale()))"
                            class="nav-link dropdown-toggle"
                            id="navbarDropdownLanguageLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false" />

                        @include('includes.partials.lang')
                    </li>
                @endif --}}

                @guest
                    <li class="nav-item p-1">
                        <x-utils.link
                            :href="route('frontend.auth.login')"
                            :active="activeClass(Route::is('frontend.auth.login'))"
                            :text="__('Login')"
                            class="nav-link" />
                    </li>

                    @if (config('boilerplate.access.user.registration'))
                        <li class="nav-item p-1">
                            <x-utils.link
                                :href="route('frontend.auth.register')"
                                :active="activeClass(Route::is('frontend.auth.register'))"
                                :text="__('Register')"
                                class="nav-link" />
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown p-1">
                        <x-utils.link
                            href="#"
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            v-pre>
                            <x-slot name="text">
                                <img class="rounded-circle" style="max-height: 20px" src="{{ $logged_in_user->avatar }}" />
                                {{ $logged_in_user->name }} <span class="caret"></span>
                            </x-slot>
                        </x-utils.link>

                        <div class="dropdown-menu dropdown-menu-right animate__animated animate__slideInDown animate__faster" aria-labelledby="navbarDropdown">
                            @if ($logged_in_user->isAdmin())
                                <x-utils.link
                                    :href="route('admin.dashboard')"
                                    :text="__('Administration')"
                                    class="dropdown-item" />
                            @endif

                            @if ($logged_in_user->isUser())
                                <x-utils.link
                                    :href="route('frontend.user.dashboard')"
                                    :active="activeClass(Route::is('frontend.user.dashboard'))"
                                    :text="__('Dashboard')"
                                    class="dropdown-item" />
                            @endif

                            <x-utils.link
                                :href="route('frontend.user.account')"
                                :active="activeClass(Route::is('frontend.user.account'))"
                                :text="__('My Account')"
                                class="dropdown-item" />

                            <x-utils.link
                                :text="__('Logout')"
                                class="dropdown-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <x-slot name="text">
                                    @lang('Logout')
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
                                </x-slot>
                            </x-utils.link>
                        </div>
                    </li>
                @endguest

                <theme-switch></theme-switch>
            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>

@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif
