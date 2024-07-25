<x-filament-panels::page>
    <!-- Include Google API script -->
    <!--<script src="https://accounts.google.com/gsi/client" async defer></script>-->

 <!-- Filament Socialite buttons -->
    <x-filament-socialite::buttons />
    <!--<x-filament::button
        :href="route('socialite.redirect', 'google')"
        tag="a"
        color="info"
    >
        Sign in with Google
    </x-filament::button>-->
    <!-- Google Sign-In button setup -->
    <!--<div id="g_id_onload"
         data-client_id="{{ config('services.google.client_id') }}"
         data-callback="handleCredentialResponse">
    </div>
    <div class="g_id_signin" data-type="standard"></div>-->

    <script>
        function handleCredentialResponse(response) {
            console.log("Encoded JWT ID token: " + response.credential);
            // Send the token to your server for further processing
            fetch('{{ route('google.login') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ credential: response.credential })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      window.location.href = data.redirect;
                  } else {
                      // Handle error
                      alert('Google Sign-In failed');
                  }
              }).catch(error => {
                  console.error('Error:', error);
              });
        }
    </script>
</x-filament-panels::page>
