<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Pop-up email -->
<div id="emailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold mb-4">Masukkan Email Anda</h2>
        <form id="emailForm">
            @csrf
            <input type="hidden" name="token" id="token" value="{{ session('token') }}">
            <input type="hidden" name="nomor_meja" id="nomor_meja" value="{{ session('nomor_meja') }}">
            <input type="email" name="email" id="email"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            <input type="text" name="name" id="name"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            <div class="flex justify-end space-x-4 mt-4">
                <button type="button" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400"
                    onclick="closeEmailModal()">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEmailModal() {
        document.getElementById('emailModal').style.display = 'flex';
    }

    function closeEmailModal() {
        document.getElementById('emailModal').style.display = 'none';
    }

    document.getElementById('emailForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var email = document.getElementById('email').value;
        var name = document.getElementById('name').value;
        var token = document.getElementById('token').value;
        var nomor_meja = document.getElementById('nomor_meja').value;

        $.post("{{ route('save.email.meja') }}", {
                email: email,
                name: name,
                token: token,
                nomor_meja: nomor_meja,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                console.log(response);
                if (response.status === 'success') {
                    closeEmailModal();
                    window.location.href = "{{ route('menu.meja.index') }}";
                }
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON?.message || 'Gagal menyimpan data.');
            });
    });
</script>
