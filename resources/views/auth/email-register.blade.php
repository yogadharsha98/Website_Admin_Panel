@extends('layouts.frontend')

@section('title', 'Home Page')

@section('content')
    <div>
        <section class="categories-area mt-2">
            <div class="container">
                <div class="categories-main">
                    <div class="row align-items-start"> <!-- Changed align-items-end to align-items-start -->


                        <div class="col-lg-6">
                            <div class="categories-right">
                                <h3 class="mb-1">Welcome to Mr.Ads.lk</h3>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="categories-right">
                                <label class="mb-1">Sign Up If you Don't Have an Account</label>
                                <form action="{{ route('mail.register.submit') }}" method="POST">
                                    @csrf
                                    <div class="flex flex-col mb-4"> <!-- Changed this to flex-col to stack items -->
                                        <div class="flex items-center mb-2">
                                            <input type="text" name="name" placeholder="Enter your Name"
                                                class="border rounded-md p-2 flex-grow" required />
                                        </div>
                                        <div class="flex flex-col mb-2">
                                            <input type="email" name="email" placeholder="Enter your Email"
                                                class="border rounded-md p-2 flex-grow
                                                       @if ($errors->has('email')) border-red-500 @endif"
                                                required value="{{ old('email') }}" />
                                            <!-- Display an error message if the email validation fails -->
                                            @if ($errors->has('email'))
                                                <span class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</span>
                                                <!-- Error message in red -->
                                            @endif
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <input type="password" name="password" placeholder="Enter your Password"
                                                class="border rounded-md p-2 flex-grow" required />
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <input type="password" name="password_confirmation"
                                                placeholder="Enter you password to confirm"
                                                class="border rounded-md p-2 flex-grow" required />
                                        </div>
                                        <button type="submit" class="send-otp-button border rounded-md p-2">Register
                                        </button>
                                    </div>
                                </form>
                                <a href="{{ route('mail.login') }}">
                                    <button
                                        class="gmail-button border rounded-md p-2 mb-2 w-full flex items-center justify-center">
                                        Login if you are already an user!
                                    </button>
                                </a>
                            </div>
                        </div>
                        <style>
                            .flex {
                                display: flex;
                            }

                            .flex-col {
                                flex-direction: column;
                            }

                            .items-center {
                                align-items: center;
                            }

                            .mb-1 {
                                margin-bottom: 0.25rem;
                                /* Small margin below the label */
                            }

                            .mb-2 {
                                margin-bottom: 0.5rem;
                                /* Margin below the input fields */
                            }

                            .mb-4 {
                                margin-bottom: 1rem;
                                /* Margin for spacing between sections */
                            }

                            .border {
                                border: 1px solid #ccc;
                                /* Border styling */
                            }

                            .rounded-md {
                                border-radius: 0.375rem;
                                /* Rounded corners */
                            }

                            .p-2 {
                                padding: 0.5rem;
                                /* Padding for all sides */
                            }

                            .mr-2 {
                                margin-right: 0.5rem;
                                /* Margin to the right */
                            }

                            .flex-grow {
                                flex-grow: 1;
                                /* Allows the input to take available space */
                            }

                            .send-otp-button {
                                cursor: pointer;
                                /* Change cursor on hover */
                                background-color: #007bff;
                                /* Button background color */
                                color: white;
                                /* Button text color */
                                border: none;

                            }

                            .email-button {
                                cursor: pointer;
                                /* Change cursor on hover */
                                background-color: #f2f5f8;
                                /* Button background color */
                                color: black;
                                /* Change text color to black */
                                /* Button text color */
                                border: none;
                                /* Remove border */
                            }

                            .gmail-button {
                                cursor: pointer;
                                /* Change cursor on hover */
                                background-color: #d9e6f2;
                                /* Button background color */
                                color: black;
                                /* Change text color to black */
                                /* Button text color */
                                border: none;
                                /* Remove border */
                            }

                            .fb-button {
                                cursor: pointer;
                                /* Change cursor on hover */
                                background-color: #4b9ced;
                                /* Button background color */
                                color: black;
                                /* Change text color to black */
                                /* Button text color */
                                border: none;
                                /* Remove border */
                            }


                            */ .flex {
                                display: flex;
                            }

                            .flex-col {
                                flex-direction: column;
                            }

                            .items-center {
                                align-items: center;
                            }

                            .justify-center {
                                justify-content: center;
                            }

                            .w-full {
                                width: 100%;
                            }

                            .mb-2 {
                                margin-bottom: 0.5rem;
                            }

                            h4 {
                                border-bottom: none;
                                margin-bottom: 0;
                            }
                        </style>


                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Listen for alertify events from Livewire
                Livewire.on('alertify', alertifyDetail => {
                    const {
                        type,
                        message
                    } = alertifyDetail;

                    if (!type || !message) {
                        console.error('Type or message is missing:', alertifyDetail);
                        return;
                    }

                    if (type === 'success') {
                        alertify.success(message);
                    } else if (type === 'error') {
                        alertify.error(message);
                    } else {
                        console.error('Invalid alertify type:', type);
                    }
                });
            });
        </script>
    @endpush

@endsection
