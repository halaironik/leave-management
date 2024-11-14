@if(session('success'))
<div id="success-message" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    {{ session('success') }} 
</div>
@endif

@if(session('error'))
<div id="error-message" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    {{ session('error') }}
</div>
@endif

<script>
    setTimeout(() => {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }

        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 3000);
</script>