@extends('admin.layouts.app')

@section('content')

@section('content')
@php
// Dynamic back link to dashboard
$backUrl = route('admin.dashboard');
$backTitle = 'Dashboard';
@endphp

<style>
    .profile-page-bg {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(160deg, #dbeafd 0%, #f5fafd 98%);
    }

    .profile-center-wrap {
        width: 100%;
        max-width: 950px;
        border-radius: 26px;
        background: #fff;
        box-shadow: 0 16px 32px 0 rgba(31, 38, 135, 0.09);
        padding: 0;
        overflow: hidden;
        margin: 32px 0;
        display: flex;
        flex-wrap: wrap;
    }

    .profile-header-section {
        background: linear-gradient(135deg, #81b6f2 10%, #61dadf 90%);
        width: 100%;
        padding: 54px 32px 0 32px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 205px;
    }

    .profile-header-bg {
        background: url('https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=900&q=60') center/cover no-repeat;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0.22;
        z-index: 0;
    }

    .profile-avatar-lg {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid #fff;
        margin-top: -52px;
        z-index: 1;
        background: #d7ebfa;
        box-shadow: 0 4px 16px 0 rgba(50, 70, 100, .12);
    }

    .profile-details-main {
        padding: 0 32px 32px 32px;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        column-gap: 34px;
        row-gap: 34px;
        justify-content: center;
    }

    .profile-form-col {
        flex: 1 1 320px;
        max-width: 400px;
        min-width: 300px;
        margin: 0 auto;
        padding-top: 30px;
    }

    .profile-form label {
        font-weight: 500;
        color: #364163;
    }

    .profile-form input.form-control {
        border-radius: 12px;
        padding: .75rem 1rem;
        background: #f5fafd;
        border: 1.5px solid #d9eafd;
        transition: border-color .17s;
    }

    .profile-form input.form-control:focus {
        border-color: #61dadf;
        background: #fff;
        box-shadow: 0 2px 16px 0 rgba(24, 167, 181, 0.07);
    }

    .profile-btn {
        border-radius: 21px;
        padding: 12px 42px;
        font-weight: 600;
        font-size: 1.07rem;
        background: linear-gradient(89deg, #04619f, #61dadf);
        border: none;
        box-shadow: 0 6px 24px 0 rgba(24, 167, 181, 0.12);
        color: #fff !important;
        letter-spacing: .5px;
        transition: background .25s;
    }

    .profile-btn:hover,
    .profile-btn:focus {
        background: linear-gradient(90deg, #61dadf 66%, #04619f 100%);
        color: #fff !important;
    }

    .profile-header-details {
        margin-top: 18px;
        text-align: center;
        z-index: 1;
    }

    .profile-header-details h2 {
        margin-bottom: 3px;
        font-size: 2.15rem;
        font-weight: 700;
        color: #183665;
    }

    .profile-header-details .profile-email {
        font-size: 1rem;
        color: #576180;
        opacity: .84;
    }

    .profile-header-actions {
        position: absolute;
        top: 18px;
        right: 32px;
        z-index: 1;
    }

    .alert {
        border-radius: 12px;
        font-size: 1.04rem;
        margin-bottom: 1.4rem;
        box-shadow: 0 2px 8px 0 rgba(18, 117, 137, 0.06);
    }

    @media (max-width: 768px) {
        .profile-center-wrap {
            flex-direction: column;
            padding: 0;
        }

        .profile-details-main {
            flex-direction: column;
            padding: 0 12px 22px 12px;
        }

        .profile-form-col {
            max-width: 100%;
            min-width: unset;
            padding-top: 18px;
        }

        .profile-header-section {
            padding: 38px 10px 0 10px;
            min-height: 170px;
        }

        .profile-header-actions {
            right: 12px;
        }
    }
</style>

<div class="profile-page-bg">
    <div class="profile-center-wrap">
        <!-- Profile Header -->
        <div class="profile-header-section">
            <div class="profile-header-bg"></div>
            <img class="profile-avatar-lg" src="/images/contact.png" alt="Profile Photo">
            <div class="profile-header-details">
                <h2>{{ $user->name }}</h2>
                <div class="profile-email">{{ $user->email }}</div>
            </div>
            <div class="profile-header-actions">
                <i class="bi bi-person-circle fs-2 opacity-50"></i>
            </div>
        </div>
        <!-- Profile Details/Main -->
        <div class="profile-details-main">
            <div class="profile-form-col">
                @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle fs-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-triangle fs-5 mt-1"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                        <li style="list-style: disc;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="profile-form mt-1" action="{{ route('admin.profile.update') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label" for="profile-name">Name</label>
                        <input type="text" id="profile-name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="profile-email">Email</label>
                        <input type="email" id="profile-email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="profile-password">
                            New Password <small class="text-muted">(optional)</small>
                        </label>
                        <input type="password" id="profile-password" name="password" class="form-control" autocomplete="new-password">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="profile-password-confirmation">Confirm Password</label>
                        <input type="password" id="profile-password-confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="profile-btn">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection