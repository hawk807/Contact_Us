@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Contact Us</h4>
                </div>
                <div class="card-body p-4">
                    
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-floating mb-1">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Your Name" value="{{ old('name') }}" required maxlength="100">
                            <label for="name">Full Name</label>
                        </div>
                        @error('name')
                            <span class="text-danger d-block mb-3">
                                {{ $message }}
                            </span>
                        @enderror

                        <div class="form-floating mb-1">
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email') }}" required>
                            <label for="email">Email address</label>
                        </div>
                        @error('email')
                            <span class="text-danger d-block mb-3">
                                {{ $message }}
                            </span>
                        @enderror

                        <div class="form-floating mb-1">
                            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" value="{{ old('subject') }}" required maxlength="150">
                            <label for="subject">Subject</label>
                        </div>
                        @error('subject')
                            <span class="text-danger d-block mb-3">
                                {{ $message }}
                            </span>
                        @enderror

                        <div class="form-floating mb-1">
                            <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" placeholder="Write your message here" style="height: 150px" required maxlength="2000">{{ old('message') }}</textarea>
                            <label for="message">Message</label>
                        </div>
                        @error('message')
                            <span class="text-danger d-block mb-3">
                                {{ $message }}
                            </span>
                        @enderror

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <small class="text-muted">We’ll get back to you as soon as possible.</small>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-send-fill"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection