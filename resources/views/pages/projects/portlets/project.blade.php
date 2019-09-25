@foreach($projects as $project)
    <div class="row">
        <div class="col-xl-6">
            <!--begin:: Portlet-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <!--begin::Widget -->
                    <div class="kt-widget kt-widget--project-1">
                        <div class="kt-widget__head">
                            <div class="kt-widget__label">
                                <div class="kt-widget__media">
                                    <span class="kt-userpic kt-userpic--lg kt-userpic--circle">
                                        <img src="{{ $project->profile_picture }}" alt="image">
                                    </span>
                                </div>
                                <div class="kt-widget__info">
                                    <a href="#" class="kt-widget__title">
                                        {{ $project->title }}
                                    </a>
                                    <span class="kt-widget__desc">
                                        {{ $project->description }}
                                    </span>
                                </div>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-widget__label">
                                    <span class="btn btn-label-brand btn-sm btn-bold btn-upper">{{ $project->cloud }}</span>
                                </div>
                                <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdow n-menu dropdown-menu-fit dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-line-chart"></i>
                                                <span class="kt-nav__link-text">Export</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="{{ route('project.edit', $project->id) }}" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-pencil"></i>
                                                <span class="kt-nav__link-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-trash"></i>
                                                <span class="kt-nav__link-text">Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget__body">
                            <div class="kt-widget__stats">
                                <div class="kt-widget__item">
                                    <span class="kt-widget__date">
                                        Start Date
                                    </span>
                                    <div class="kt-widget__label">
                                        <span class="btn btn-label-brand btn-sm btn-bold btn-upper">07 may, 18</span>
                                    </div>
                                </div>

                                <div class="kt-widget__item">
                                    <span class="kt-widget__date">
                                        Due Date
                                    </span>
                                    <div class="kt-widget__label">
                                        <span class="btn btn-label-danger btn-sm btn-bold btn-upper">07 0ct, 18</span>
                                    </div>
                                </div>

                                <div class="kt-widget__item flex-fill">
                                    <span class="kt-widget__subtitel">Progress</span>
                                    <div class="kt-widget__progress d-flex  align-items-center">
                                        <div class="progress" style="height: 5px;width: 100%;">
                                            <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 78%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="kt-widget__stat">
                                            78%
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <span class="kt-widget__text">
                                {{ $project->paragraph }}
                            </span>

                            <div class="kt-widget__content">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__subtitle">Budget</span>
                                    <span class="kt-widget__value"><span>$</span>249,500</span>
                                </div>

                                <div class="kt-widget__details">
                                    <span class="kt-widget__subtitle">Expances</span>
                                    <span class="kt-widget__value"><span>$</span>76,810</span>
                                </div>

                                <div class="kt-widget__details">
                                    <span class="kt-widget__subtitle">Members</span>
                                    <div class="kt-badge kt-badge__pics">
                                        <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                            <img src="./assets/media/users/100_7.jpg" alt="image">
                                        </a>
                                        <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                            <img src="./assets/media/users/100_3.jpg" alt="image">
                                        </a>
                                        <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                            <img src="./assets/media/users/100_2.jpg" alt="image">
                                        </a>
                                        <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Luke Walls">
                                            <img src="./assets/media/users/100_13.jpg" alt="image">
                                        </a>
                                        <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                            <img src="./assets/media/users/100_4.jpg" alt="image">
                                        </a>
                                        <a href="#" class="kt-badge__pic kt-badge__pic--last kt-font-brand">
                                            +7
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget__footer">
                            <div class="kt-widget__wrapper">
                                <div class="kt-widget__section">
                                    <div class="kt-widget__blog">
                                        <i class="flaticon2-list-1"></i>
                                        <a href="#" class="kt-widget__value kt-font-brand">72 Tasks</a>
                                    </div>

                                    <div class="kt-widget__blog">
                                        <i class="flaticon2-talk"></i>
                                        <a href="#" class="kt-widget__value kt-font-brand">648 Comments</a>
                                    </div>
                                </div>

                                <div class="kt-widget__section">
                                    <button type="button" class="btn btn-brand btn-sm btn-upper btn-bold">details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Widget -->
                </div>
            </div>
            <!--end:: Portlet-->
        </div>
    </div>
@endforeach
