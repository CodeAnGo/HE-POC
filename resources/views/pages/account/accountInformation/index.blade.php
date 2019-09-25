@extends('layouts.scaffold')

@section('title', 'Account Settings')
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
                                    <h3 class="kt-portlet__head-title">Account Information <small>change your account settings</small></h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-wrapper">
                                        <div class="dropdown dropdown-inline">
                                            <button type="button" class="btn btn-label-brand btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="flaticon2-console"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="kt-nav">
                                                    <li class="kt-nav__section kt-nav__section--first">
                                                        <span class="kt-nav__section-text">Export Tools</span>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon la la-print"></i>
                                                            <span class="kt-nav__link-text">Print</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon la la-copy"></i>
                                                            <span class="kt-nav__link-text">Copy</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                            <span class="kt-nav__link-text">Excel</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                            <span class="kt-nav__link-text">CSV</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                                            <span class="kt-nav__link-text">PDF</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form class="kt-form kt-form--label-right" method="POST" action="{{ route('account-information.store') }}">
                                @csrf
                                <div class="kt-portlet__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <div class="row">
                                                <label class="col-xl-3"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <h3 class="kt-section__title kt-section__title-sm">Account:</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                        <input disabled type="text" class="form-control" value="{{ Auth::user()->email }}" placeholder="Email" aria-describedby="basic-addon1">
                                                    </div>
                                                    <span class="form-text text-muted">Your email will not be displayed publicly. <a href="#" class="kt-link">Learn more</a>.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Language</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <select class="form-control" disabled>
                                                        <option>Select Language...</option>
                                                        <option value="id">Bahasa Indonesia - Indonesian</option>
                                                        <option value="msa">Bahasa Melayu - Malay</option>
                                                        <option value="ca">Català - Catalan</option>
                                                        <option value="cs">Čeština - Czech</option>
                                                        <option value="da">Dansk - Danish</option>
                                                        <option value="de">Deutsch - German</option>
                                                        <option value="en">English</option>
                                                        <option value="en-gb" selected>English UK - British English</option>
                                                        <option value="es">Español - Spanish</option>
                                                        <option value="eu">Euskara - Basque (beta)</option>
                                                        <option value="fil">Filipino</option>
                                                        <option value="fr">Français - French</option>
                                                        <option value="ga">Gaeilge - Irish (beta)</option>
                                                        <option value="gl">Galego - Galician (beta)</option>
                                                        <option value="hr">Hrvatski - Croatian</option>
                                                        <option value="it">Italiano - Italian</option>
                                                        <option value="hu">Magyar - Hungarian</option>
                                                        <option value="nl">Nederlands - Dutch</option>
                                                        <option value="no">Norsk - Norwegian</option>
                                                        <option value="pl">Polski - Polish</option>
                                                        <option value="pt">Português - Portuguese</option>
                                                        <option value="ro">Română - Romanian</option>
                                                        <option value="sk">Slovenčina - Slovak</option>
                                                        <option value="fi">Suomi - Finnish</option>
                                                        <option value="sv">Svenska - Swedish</option>
                                                        <option value="vi">Tiếng Việt - Vietnamese</option>
                                                        <option value="tr">Türkçe - Turkish</option>
                                                        <option value="el">Ελληνικά - Greek</option>
                                                        <option value="bg">Български език - Bulgarian</option>
                                                        <option value="ru">Русский - Russian</option>
                                                        <option value="sr">Српски - Serbian</option>
                                                        <option value="uk">Українська мова - Ukrainian</option>
                                                        <option value="he">עִבְרִית - Hebrew</option>
                                                        <option value="ur">اردو - Urdu (beta)</option>
                                                        <option value="ar">العربية - Arabic</option>
                                                        <option value="fa">فارسی - Persian</option>
                                                        <option value="mr">मराठी - Marathi</option>
                                                        <option value="hi">हिन्दी - Hindi</option>
                                                        <option value="bn">বাংলা - Bangla</option>
                                                        <option value="gu">ગુજરાતી - Gujarati</option>
                                                        <option value="ta">தமிழ் - Tamil</option>
                                                        <option value="kn">ಕನ್ನಡ - Kannada</option>
                                                        <option value="th">ภาษาไทย - Thai</option>
                                                        <option value="ko">한국어 - Korean</option>
                                                        <option value="ja">日本語 - Japanese</option>
                                                        <option value="zh-cn">简体中文 - Simplified Chinese</option>
                                                        <option value="zh-tw">繁體中文 - Traditional Chinese</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-last row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Communication</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-checkbox-inline">
                                                        <label class="kt-checkbox">
                                                            <input type="hidden" name="email" value="off">
                                                            <input name="email" type="checkbox" @if(Auth::user()->getCommunicationPreferences->email) checked @endif> Email
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-checkbox">
                                                            <input type="hidden" name="sms" value="off">
                                                            <input name="sms" type="checkbox" @if(Auth::user()->getCommunicationPreferences->sms) checked @endif> SMS
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-checkbox">
                                                            <input type="hidden" name="phone" value="off">
                                                            <input name="phone" type="checkbox" @if(Auth::user()->getCommunicationPreferences->phone) checked @endif> Phone
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <div class="row">
                                                <label class="col-xl-3"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <h3 class="kt-section__title kt-section__title-sm">Security:</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Login verification</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    @if(!Auth::user()->getOTP->verified)
                                                    <button type="button" class="btn btn-bold btn-label-brand btn-sm kt-margin-t-5 kt-margin-b-5" data-toggle="modal" data-target="#otp_setup_modal">Setup Multi-Factor Auth</button>
                                                    <span class="form-text text-muted">
                                                        After you log in, you will be asked for additional information to confirm your identity and protect your account from being compromised.
                                                        <a href="#" class="kt-link">Learn more</a>.
                                                    </span>
                                                    @else
                                                        <label class="kt-checkbox">
                                                            <input type="hidden" name="otpLoginEnabled" value="off">
                                                            <input name="otpLoginEnabled" type="checkbox" @if(Auth::user()->getSecurityPreferences->otpLoginEnabled) checked @endif> Require 2FA Verification on Login Requests.
                                                            <span></span>
                                                        </label>
                                                        <span class="form-text text-muted">
                                                        For extra security, this requires you to enter a One-Time-Password from your Authenticator app during login.
                                                        <a href="#" class="kt-link">Learn more</a>.
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Password reset verification</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-checkbox-single">
                                                        <label class="kt-checkbox">
                                                            <input type="hidden" name="securedPasswordReset" value="off">
                                                            <input name="securedPasswordReset" type="checkbox" @if(Auth::user()->getSecurityPreferences->securedPasswordReset) checked @endif> Require personal information to reset your password.
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="form-text text-muted">
                                                        For extra security, this requires you to confirm your email or phone number when you reset your password.
                                                        <a href="#" class="kt-link">Learn more</a>.
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group row kt-margin-t-10 kt-margin-b-10">
                                                <label class="col-xl-3 col-lg-3 col-form-label"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <button type="button" class="btn btn-label-danger btn-bold btn-sm kt-margin-t-5 kt-margin-b-5">Deactivate your account ?</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-portlet__foot">
                                    <div class="kt-form__actions">
                                        <div class="row">
                                            <div class="col-lg-3 col-xl-3">
                                            </div>
                                            <div class="col-lg-9 col-xl-9">
                                                <button type="submit" class="btn btn-success">Save</button>&nbsp;
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->

@if(!Auth::user()->getSecurityPreferences->otpLoginEnabled)
    <div class="modal fade" id="otp_setup_modal" tabindex="-1" role="dialog" aria-labelledby="One Time Passcode Generator" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('otp.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">OTP Setup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align: center;">
                            <img src="{{ Auth::user()->getOTP->getQRCode() }}" alt="">
                        </div>
                        <br>
                        @csrf
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Authenticator Code</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="OTPCode" type="text" class="form-control" value="" placeholder="6 Digit Code" aria-describedby="basic-addon1" maxlength="6">
                                </div>
                                @error('OTPCode')
                                    <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                                <span class="form-text text-muted">For help setting up Authenticator, <a href="#" class="kt-link">Click Here</a>.</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm 2FA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @error('OTPCode')
    <script>
        $(document).ready(function(){
            $('#otp_setup_modal').modal('show');
        });
    </script>
    @enderror
@endif
@endsection
