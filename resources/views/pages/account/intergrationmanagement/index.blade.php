@extends('layouts.scaffold')

@section('title', 'Integration Management')
@section('description',  Auth::user()->name)

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::App-->
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

            <!--Begin:: App Aside-->
            <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

                <!--begin:: Widgets/Applications/User/Profile1-->
            @include('pages.account.components.profile')
            <!--end:: Widgets/Applications/User/Profile1-->
            </div>

            <!--End:: App Aside-->

            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Integration Management <small>manage the integrations with your cloud service providers</small></h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Cloud Providers:</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">AWS (Amazon Web Services)</label>
                                    <div class="col-lg-9 col-xl-6">
                                        @if($aws['credentials']['access_key_id'] == null)
                                            <button type="button" class="btn btn-label-brand btn-bold btn-sm kt-margin-t-5 kt-margin-b-5" data-toggle="modal" data-target="#aws_setup_modal">Setup AWS Integration</button>
                                            <span class="form-text text-muted">
                                            After you log in, you will be asked for additional information to confirm your identity and protect your account from being compromised.
                                            <a href="#" class="kt-link">Learn more</a>.
                                        </span>
                                        @else
                                            <div class="kt-portlet__body kt-portlet__body--fit">
                                                <table width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th title="Field #1">Access Key ID</th>
                                                        <th title="Field #7">Last Used</th>
                                                        <th title="Field #7">Region</th>
                                                        <th title="Field #8">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{ $aws['credentials']['access_key_id'] }}</td>
                                                        <td>
                                                        @if(isset($aws['credentials']['last_used']['AccessKeyLastUsed']['LastUsedDate']))
                                                                {{ \Carbon\Carbon::createFromTimeString($aws['credentials']['last_used']['AccessKeyLastUsed']['LastUsedDate'])->diffForHumans() }}
                                                        @else
                                                            N/A
                                                        @endif
                                                        </td>
                                                        <td>{{ $aws['credentials']['last_used']['AccessKeyLastUsed']['Region'] }}</td>
                                                        <td>
                                                            <form class="kt-form kt-form--label-right" method="POST" action="{{ route('aws.destroy', 'me') }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button class="btn btn-label-danger btn-sm btn-thin">Remove</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">GCP (Google Cloud Platform)</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <button type="button" class="btn btn-label-brand btn-bold btn-sm kt-margin-t-5 kt-margin-b-5" data-toggle="modal" data-target="#gcp_setup_modal">Setup login verification</button>
                                        <span class="form-text text-muted">
                                            After you log in, you will be asked for additional information to confirm your identity and protect your account from being compromised.
                                            <a href="#" class="kt-link">Learn more</a>.
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Microsoft Azure</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <button type="button" class="btn btn-label-brand btn-bold btn-sm kt-margin-t-5 kt-margin-b-5">Setup login verification</button>
                                        <span class="form-text text-muted">
                                            After you log in, you will be asked for additional information to confirm your identity and protect your account from being compromised.
                                            <a href="#" class="kt-link">Learn more</a>.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    @error('access_key_id')
    <script>
        $(document).ready(function(){
            $('#aws_setup_modal').modal('show');
        });
    </script>
    @enderror

    @error('aws_seccret_key')
    <script>
        $(document).ready(function(){
            $('#aws_setup_modal').modal('show');
        });
    </script>
    @enderror

    @if($aws['credentials']['access_key_id'] == null)
        @include('pages.account.intergrationmanagement.modals.aws')
    @endif


    <div class="modal fade" id="gcp_setup_modal" tabindex="-1" role="dialog" aria-labelledby="GCP Integration Setup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">GCP Integration Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">File Type Validation</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <form action="{{ route('gcp.store') }}" class="dropzone" id="my-awesome-dropzone" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Confirm Integration</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        Dropzone.options.kDropzoneThree= {
            paramName:"file",
            maxFiles:1,
            maxFilesize:2000,
            addRemoveLinks:!0,
            acceptedFiles:"application/json,.json",
            accept:function(e, o) {
                "justinbieber.jpg"==e.name?o("Naha, you don't."): o()
            }
        }
    </script>


    <!-- end:: Content -->
@endsection
