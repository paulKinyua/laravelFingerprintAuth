<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="block mt-4">
            <div class="flex  mt-4 col-12">
                <div class = 'flex justify-start float-start col-4'>
                    <x-secondary-button onclick="openModal()">
                        {{ __('Fingerprint') }}
                    </x-secondary-button>
                    <p>  </p>
                </div>
                <div class ='flex items-center justify-end float-end col-8'>    
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button >
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>

    <!-- fingerprint modal -->
    <div class="modal" tabindex="-1" id="fingerprintModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload fingerprint</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('fingerprintLogin') }}">
                    @csrf

                    <!-- Upload fingerprint -->
                    <div class="mt-4">
                        <x-input-label for="fingerprint" :value="__('Upload Fingerprint')" />

                            <input id="fingerprint" class="block mt-1 w-full"
                                type="file"
                                name="fingerprint" id="fingerprint"  />

                        <!-- <x-input-error :messages="$errors->get('login')" class="mt-2" /> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            
    
    @section('scripts')
        <script>
            // Get a reference to the file input element
            const inputElement = document.querySelector('input[id="fingerprint"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server: {
                    url: '/api/login_upload',
                    headers :{
                        'X-CSRF-TOKEN': '{{csrf_token() }}'
                    }
                }
            });
        </script>
    @endsection
            
            </div>
        </div>
    </div>

    <script>
        //display modal
        function openModal(){
            $('#fingerprintModal').modal('show');
        }
    </script>
</x-guest-layout>
