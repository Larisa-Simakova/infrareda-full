@extends('pages.add_product_base')
@section('product-content')
    <form class="form-update" action="{{ route('admin.products.certificates.store', $product->id) }}" method="POST"
        enctype="multipart/form-data" id="certificatesForm">
        @csrf
        <input type="hidden" name="step" value="certificates">

        <h2>Сертификаты товара: {{ $product->title }}</h2>

        <div class="form-input">
            <p class="text-medium">Необязательный этап</p>
            <div id="certificates-container">
                <div class="form-input">
                    <label class="button-red">
                        <span>Загрузить PDF сертификаты</span>
                        <input type="file" name="files[]" id="pdfCertificateUpload" multiple class="visually-hidden"
                            accept=".pdf">
                    </label>
                    <div id="pdfErrors" class="error-container"></div>
                </div>
                <div id="certificateFiles" class="update-files">
                    @foreach ($product->certificates as $certificate)
                        <div class="file-block" data-id="{{ $certificate->id }}">
                            <div class="file-preview">
                                <a href="{{ asset('storage/' . $certificate->url) }}" target="_blank" class="file-info text-small" style="padding: 1em 0;">
                                    <span class="file-name" style="color: #191919 !important;">{{ basename($certificate->url) }}</span>
                                </a>
                            </div>
                            <button type="button" class="button-transparent delete-file" data-id="{{ $certificate->id }}"
                                data-delete-route="{{ route('admin.products.certificates.destroy', ['product' => $product->id, 'certificate' => $certificate->id]) }}">
                                Удалить
                            </button>
                            <input type="hidden" name="uploaded_files[]" value="{{ $certificate->id }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="certificatesErrors" class="error-container"></div>
        </div>

        <div class="admin-buttons">
            <button type="submit" class="button-red">Сохранить и продолжить</button>
            <button type="button" class="button-transparent" id="saveAndExitButton">Сохранить и выйти</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка удаления файлов
            document.addEventListener('click', async function(e) {
                if (!e.target.classList.contains('delete-file')) return;

                const button = e.target;
                const fileBlock = button.closest('.file-block');
                if (!fileBlock) return;

                if (!confirm('Вы уверены, что хотите удалить этот сертификат?')) {
                    return;
                }

                try {
                    let url, method, headers, body;

                    // Для существующих файлов (DELETE запрос)
                    if (button.dataset.id) {
                        url = button.dataset.deleteRoute;
                        method = 'DELETE';
                        headers = {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        };
                        body = null;
                    }
                    // Для временных файлов (POST запрос)
                    else if (button.dataset.tempId) {
                        url = "{{ route('admin.products.certificates.temp-delete') }}";
                        method = 'POST';
                        headers = {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        };
                        body = new FormData();
                        body.append('temp_id', button.dataset.tempId);
                    }

                    const response = await fetch(url, {
                        method: method,
                        headers: headers,
                        body: body
                    });

                    if (!response.ok) {
                        throw new Error('Ошибка сервера');
                    }

                    const data = await response.json();

                    if (!data.success) {
                        throw new Error(data.message || 'Ошибка при удалении');
                    }

                    fileBlock.remove();
                } catch (error) {
                    console.error('Delete error:', error);
                    alert('Ошибка при удалении: ' + error.message);
                }
            });

            // Загрузка PDF файлов
            document.getElementById('pdfCertificateUpload').addEventListener('change', function(e) {
                const files = e.target.files;
                const errorContainer = document.getElementById('pdfErrors');
                errorContainer.textContent = '';

                if (files.length === 0) return;

                // Проверка формата файлов
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type !== 'application/pdf' || !file.name.toLowerCase().endsWith('.pdf')) {
                        errorContainer.textContent = 'Можно загружать только PDF файлы';
                        e.target.value = '';
                        return;
                    }

                    if (file.size > 10 * 1024 * 1024) {
                        errorContainer.textContent = 'Максимальный размер файла - 10MB';
                        e.target.value = '';
                        return;
                    }
                }

                const formData = new FormData();
                for (let i = 0; i < files.length; i++) {
                    formData.append('files[]', files[i]);
                }
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                formData.append('file_type', 'certificate');

                // Показываем индикатор загрузки
                const uploadLabel = e.target.closest('label');
                uploadLabel.style.opacity = '0.5';
                uploadLabel.querySelector('span').textContent = 'Загрузка...';

                fetch("{{ route('admin.products.certificates.temp-upload') }}", {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Ошибка сервера');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.files && data.files.length > 0) {
                            data.files.forEach(file => {
                                const fileBlock = document.createElement('div');
                                fileBlock.className = 'file-block';
                                fileBlock.dataset.tempId = file.temp_id;
                                fileBlock.innerHTML = `
                                <div class="file-preview">
                                    <div class="file-info text-small" sstyle="padding: 1em 0;">
                                        <span class="file-name" style="color: #191919 !important;">${file.name}</span>
                                    </div>
                                </div>
                                <button type="button" class="button-transparent delete-file"
                                    data-temp-id="${file.temp_id}"
                                    data-delete-route="{{ route('admin.products.certificates.temp-delete') }}">
                                    Удалить
                                </button>
                                <input type="hidden" name="uploaded_files[]" value="${file.temp_id}">
                            `;
                                document.getElementById('certificateFiles').appendChild(
                                    fileBlock);
                            });
                        } else {
                            throw new Error(data.message || 'Ошибка при загрузке файлов');
                        }
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        errorContainer.textContent = error.message;
                    })
                    .finally(() => {
                        uploadLabel.style.opacity = '1';
                        uploadLabel.querySelector('span').textContent = 'Загрузить PDF сертификаты';
                        e.target.value = '';
                    });
            });

            // Обработка сохранения и выхода
            document.getElementById('saveAndExitButton').addEventListener('click', function() {
                document.querySelector('input[name="step"]').value = 'complete';
                document.getElementById('certificatesForm').submit();
            });

            // Валидация формы при отправке
            document.getElementById('certificatesForm').addEventListener('submit', function(e) {
                const errorContainer = document.getElementById('certificatesErrors');
                errorContainer.textContent = '';
                return true;
            });
        });
    </script>
@endsection
