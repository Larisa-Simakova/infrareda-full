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
                        <span>Загрузить сертификаты</span>
                        <input type="file" name="files[]" id="pdfCertificateUpload" multiple class="visually-hidden"
                            accept=".pdf,.jpg,.jpeg,.png,.webp">
                    </label>
                    <div id="pdfErrors" class="error-container"></div>
                </div>
                <div id="certificateFiles" class="update-images">
                    @foreach ($product->certificates as $certificate)
                        @php
                            $isPdf = pathinfo($certificate->url, PATHINFO_EXTENSION) === 'pdf';
                            $previewPath = $isPdf
                                ? str_replace('.pdf', '_preview.jpg', $certificate->url)
                                : $certificate->url;
                        @endphp

                        <div class="image-block" data-id="{{ $certificate->id }}">
                            <a href="{{ secure_asset('storage/' . $certificate->url) }}" target="_blank">
                                @if ($isPdf)
                                    @if (Storage::disk('public')->exists($previewPath))
                                        <img src="{{ secure_asset('storage/' . $previewPath) }}" alt="PDF preview">
                                    @else
                                        <svg viewBox="0 0 24 24" width="48" height="48">
                                            <path fill="#FF0000"
                                                d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            <path fill="#000000"
                                                d="M10,12A2,2 0 0,0 8,14V16A2,2 0 0,0 10,18H11V21H13V18H14A2,2 0 0,0 16,16V14A2,2 0 0,0 14,12H10M10,14H14V16H10V14Z" />
                                        </svg>
                                    @endif
                                @else
                                    <img src="{{ secure_asset('storage/' . $certificate->url) }}" alt="Превью сертификата">
                                @endif
                            </a>
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
                const fileBlock = button.closest('.image-block');
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

            // Загрузка файлов
            document.getElementById('pdfCertificateUpload').addEventListener('change', function(e) {
                const files = e.target.files;
                const errorContainer = document.getElementById('pdfErrors');
                errorContainer.textContent = '';

                if (files.length === 0) return;

                // Проверка формата файлов
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
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
                                fileBlock.className = 'image-block';
                                fileBlock.dataset.tempId = file.temp_id;

                                const previewContent = file.is_pdf ?
                                    file.preview_url ?
                                    `<img src="${file.preview_url}" alt="PDF preview">` :
                                    `
                        <svg viewBox="0 0 24 24" width="48" height="48">
                            <path fill="#FF0000" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                            <path fill="#000000" d="M10,12A2,2 0 0,0 8,14V16A2,2 0 0,0 10,18H11V21H13V18H14A2,2 0 0,0 16,16V14A2,2 0 0,0 14,12H10M10,14H14V16H10V14Z" />
                        </svg>
                    ` :
                                    `<img src="${file.url}" alt="Превью сертификата">`;

                                fileBlock.innerHTML = `
                    <a href="${file.url}" target="_blank">
                        ${previewContent}
                    </a>
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
                        uploadLabel.querySelector('span').textContent = 'Загрузить сертификаты';
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
