@extends('layouts.scaffold')

@section('title', 'Projects')
@section('description', 'No Projects Created')

@section('toolbar_left')
<div class="kt-subheader__group" id="kt_subheader_search">
    <span class="kt-subheader__desc" id="kt_subheader_total">
    </span>
    <form class="kt-margin-l-20" id="kt_subheader_search_form">
        <div class="kt-input-icon kt-input-icon--right kt-subheader__search">
            <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
            <span class="kt-input-icon__icon kt-input-icon__icon--right">
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" id="Path" fill="#000000" fill-rule="nonzero"/>
                </g>
            </svg>
            </span>
            </span>
        </div>
    </form>
</div>
@endsection

@section('toolbar_right')
    <a href="{{ route('projects.create') }}" class="btn btn-label-brand btn-bold">
        Create Project
    </a>
@endsection

@section('content')
<div class="kt-container  kt-grid__item kt-grid__item--fluid">
    <!--Begin::Section-->
    @include('pages.projects.portlets.project')
    <!--End::Section-->

    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-12">
            <!--begin:: Components/Pagination/Default-->
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin: Pagination-->
                    <div class="kt-pagination kt-pagination--brand">
                        <ul class="kt-pagination__links">
                            <li class="kt-pagination__link--first">
                                <a href="#"><i class="fa fa-angle-double-left kt-font-brand"></i></a>
                            </li>
                            <li class="kt-pagination__link--next">
                                <a href="#"><i class="fa fa-angle-left kt-font-brand"></i></a>
                            </li>

                            <li class="kt-pagination__link--active">
                                <a href="#">1</a>
                            </li>

                            <li class="kt-pagination__link--prev">
                                <a href="#"><i class="fa fa-angle-right kt-font-brand"></i></a>
                            </li>
                            <li class="kt-pagination__link--last">
                                <a href="#"><i class="fa fa-angle-double-right kt-font-brand"></i></a>
                            </li>
                        </ul>

                        <div class="kt-pagination__toolbar">
                            <select class="form-control kt-font-brand" style="width: 60px">
                                <option value="6">6</option>
                                <option value="12">12</option>
                                <option value="18">18</option>
                                <option value="24">24</option>
                                <option value="30">30</option>
                            </select>
                            <span class="pagination__desc">
                                Displaying 1 of 1 records
                            </span>
                        </div>
                    </div>
                    <!--end: Pagination-->
                </div>
            </div>
            <!--end:: Components/Pagination/Default-->
        </div>
    </div>
        <!--End::Section-->
</div>

@endsection
