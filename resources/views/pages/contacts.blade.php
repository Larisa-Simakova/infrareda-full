@extends('template.app')
@section('page')
    <section class="contacts">
        <div class="container">
            <div class="contacts__container">
                <div class="contacts__information">
                    <h2>Контакты</h2>
                    <div class="contacts__info-text">
                        <div class="contacts__info">
                            <p class="text-date">офисный телефон</p>
                            <a href="tel:+7 (960) 047-15-55" class="text-small">+7 (960) 047-15-55</a>
                        </div>
                        <div class="contacts__info">
                            <p class="text-date">адрес</p>
                            <p class="text-small">г.Казань, ул. Курская, д. 10</p>
                        </div>
                        <div class="contacts__info">
                            <p class="text-date">электронная почта</p>
                            <a href="mailto:sales@infrareda.ru" class="text-small">sales@infrareda.ru</a>
                        </div>
                    </div>
                    <div class="contacts__socials">
                        {{-- <div class="contact__social">
                        <svg width="45" height="45" viewBox="0 0 45 45" fill="white"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect width="45" height="45" rx="22.5" fill="white" />
                            <g clip-path="url(#clip0_36_635)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M31.304 22.5001C31.304 27.3627 27.3622 31.3045 22.4997 31.3045C17.6372 31.3045 13.6953 27.3627 13.6953 22.5001C13.6953 17.6376 17.6372 13.6958 22.4997 13.6958C27.3622 13.6958 31.304 17.6376 31.304 22.5001ZM22.8151 20.1956C21.9587 20.5517 20.2472 21.289 17.6806 22.4072C17.2638 22.5729 17.0455 22.7351 17.0256 22.8936C16.992 23.1616 17.3276 23.2671 17.7845 23.4108C17.8466 23.4303 17.911 23.4505 17.977 23.472C18.4266 23.6181 19.0313 23.7891 19.3456 23.7959C19.6308 23.802 19.9491 23.6845 20.3004 23.4432C22.6985 21.8244 23.9364 21.0062 24.0142 20.9886C24.069 20.9761 24.145 20.9605 24.1965 21.0062C24.2479 21.052 24.2429 21.1386 24.2374 21.1619C24.2042 21.3036 22.8871 22.5281 22.2055 23.1618C21.993 23.3593 21.8422 23.4995 21.8114 23.5315C21.7424 23.6031 21.6721 23.671 21.6045 23.7361C21.1868 24.1387 20.8737 24.4406 21.6218 24.9337C21.9813 25.1706 22.269 25.3665 22.556 25.562C22.8695 25.7754 23.1821 25.9883 23.5866 26.2535C23.6897 26.321 23.7881 26.3912 23.884 26.4596C24.2488 26.7196 24.5765 26.9533 24.9814 26.916C25.2166 26.8943 25.4597 26.6731 25.5831 26.0133C25.8747 24.4541 26.4481 21.0756 26.5806 19.6835C26.5922 19.5615 26.5776 19.4054 26.5658 19.3369C26.5541 19.2684 26.5296 19.1707 26.4405 19.0984C26.335 19.0128 26.1722 18.9948 26.0994 18.9961C25.7682 19.0019 25.2602 19.1786 22.8151 20.1956Z"
                                    fill="#D43D58" />
                            </g>
                            <defs>
                                <clipPath id="clip0_36_635">
                                    <rect width="17.6087" height="17.6087" fill="white"
                                        transform="translate(13.6953 13.6958)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div> --}}
                        <div class="contact__social">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="45" height="45" rx="22.5" fill="white" />
                                <path
                                    d="M13.6973 31.3045C13.8865 30.6125 14.0666 29.9554 14.2459 29.298C14.4624 28.505 14.6814 27.7123 14.8912 26.9174C14.9118 26.8319 14.9019 26.7418 14.8633 26.6627C14.0181 25.1281 13.6506 23.4825 13.7976 21.7435C14.0082 19.2542 15.1025 17.2095 17.0352 15.6245C18.1101 14.7393 19.3888 14.1363 20.7556 13.8701C24.8392 13.0579 28.7669 15.1475 30.4496 18.8216C31.0776 20.1949 31.3158 21.6392 31.1989 23.1382C30.9053 26.9082 28.1172 30.1171 24.4254 30.9403C22.3443 31.4041 20.3536 31.1318 18.4533 30.1686C18.3685 30.1294 18.2731 30.1195 18.1821 30.1407C16.761 30.5081 15.3414 30.88 13.9218 31.2516C13.8586 31.267 13.795 31.281 13.6973 31.3045ZM15.8052 29.2201C15.889 29.1999 15.9522 29.1856 16.015 29.169C16.7867 28.9673 17.5585 28.7696 18.3302 28.5594C18.486 28.5171 18.604 28.541 18.7399 28.6215C20.4219 29.6181 22.2208 29.9132 24.1299 29.4836C28.209 28.5649 30.6789 24.2652 29.4217 20.2802C28.2763 16.6501 24.6517 14.5474 20.9232 15.3558C17.8481 16.0243 15.4116 18.7173 15.258 22.1147C15.1944 23.5192 15.5027 24.8496 16.2377 26.0512C16.4703 26.4316 16.5111 26.7495 16.3748 27.1633C16.1554 27.8314 15.9959 28.5197 15.8052 29.2201V29.2201Z"
                                    fill="#D43D58" />
                                <path
                                    d="M18.0469 20.4594C18.0597 19.7303 18.3445 19.1306 18.8594 18.6304C18.9342 18.5535 19.0239 18.4927 19.1229 18.4516C19.222 18.4104 19.3284 18.3899 19.4356 18.3912C19.558 18.3912 19.6815 18.4095 19.8031 18.3974C20.0603 18.3721 20.2073 18.4985 20.2974 18.7171C20.5392 19.2963 20.7891 19.8725 21.014 20.4583C21.0548 20.5645 21.0309 20.7343 20.9699 20.8331C20.8043 21.089 20.6232 21.3345 20.4275 21.5681C20.3106 21.7129 20.301 21.8415 20.3955 22.0003C21.1073 23.1954 22.097 24.0645 23.3946 24.5771C23.5702 24.6466 23.7135 24.619 23.8337 24.4669C24.0498 24.1942 24.2747 23.9289 24.4856 23.6514C24.6069 23.4908 24.7488 23.4309 24.9288 23.514C25.5536 23.808 26.1739 24.1019 26.7902 24.4103C26.8548 24.4426 26.9147 24.5521 26.9173 24.6282C26.9423 25.2768 26.7538 25.82 26.1757 26.1981C25.4562 26.6685 24.7006 26.7096 23.8973 26.484C21.8368 25.9056 20.3066 24.6172 19.078 22.9164C18.6738 22.3542 18.3012 21.775 18.1439 21.0885C18.0946 20.8838 18.0777 20.67 18.0469 20.4594Z"
                                    fill="#D43D58" />
                            </svg>
                        </div>

                        <a href="mailto:sales@infrareda.ru" class="contact__social">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="45" height="45" rx="22.5" fill="white" />
                                <path
                                    d="M26.1675 28.7365H18.8306C16.6295 28.7365 15.1621 27.636 15.1621 25.068V19.9322C15.1621 17.3642 16.6295 16.2637 18.8306 16.2637H26.1675C28.3686 16.2637 29.836 17.3642 29.836 19.9322V25.068C29.836 27.636 28.3686 28.7365 26.1675 28.7365Z"
                                    stroke="#D43D58" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M26.169 20.2988L23.8725 22.1331C23.1168 22.7347 21.8769 22.7347 21.1212 22.1331L18.832 20.2988"
                                    stroke="#D43D58" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="contacts__map">
                    <div id="map" style="width:100%; height: 400px;"></div>
                </div>
            </div>
            <div class="company__wrap">
                <div class="company__form">
                    <h2>Оставьте свои данные — позвоним, чтобы обсудить детали</h2>
                    <form id="contactForm" method="POST" action="{{ route('send.contact') }}">
                        @csrf
                        <div id="form-error" class="error text-small" style="display: none; margin-bottom: 15px;"></div>
                        <div class="form__inputs">
                            <div class="form-input">
                                <label for="name" class="text-medium">Ваше имя <span
                                        style="color: red;">*</span></label>
                                <input id="name" class="input-transparent" type="text" name="name"
                                    placeholder="Введите имя...">
                                <div class="error text-small" id="name-error"></div>
                            </div>
                            <div class="form-input">
                                <label for="phone" class="text-medium">Номер телефона <span
                                        style="color: red;">*</span></label>
                                <input id="phone" class="input-transparent" type="tel" name="phone"
                                    placeholder="+7 (___)-___-__-__">
                                <div class="error text-small" id="phone-error"></div>
                            </div>
                            <div class="form-input">
                                <label for="city" class="text-medium">Город</label>
                                <input id="city" class="input-transparent" type="text" name="city"
                                    placeholder="Введите город...">
                            </div>
                        </div>
                        <div class="form__buttons">
                            <button type="submit" class="button-red-arrow">
                                <span class="text">отправить</span>
                                <span class="icon icon-arrow">
                                    <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white"
                                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </button>
                            <div class="form-input">
                                <div class="form__checkbox">
                                    <input type="checkbox" name="policy" id="policy">
                                    <label class="text-small" for="policy">Принимаю условия обработки персональных
                                        данных</label>
                                </div>
                                <div class="error text-small" id="policy-error"></div>
                            </div>
                        </div>
                    </form>
                    <img class="form-fon" src="assets/images/main/form-fon.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <script src="https://api-maps.yandex.ru/2.1/?apikey=c0a7765d-562b-4c3d-8fc9-f6c14bb61226&lang=ru_RU"></script>
    <script>
        ymaps.ready(init);

        function init() {
            var coords = [55.78897556897262, 49.18001299999997];

            var myMap = new ymaps.Map("map", {
                center: coords,
                zoom: 17,
                controls: ['zoomControl']
            });

            myMap.options.set('filter', {
                applyTo: 'map',
                type: 'grayscale',
                value: 100
            });

            var myPlacemark = new ymaps.Placemark(
                coords, {
                    hintContent: 'ул. Курская, 10',
                    balloonContent: 'Казань, ул. Курская, 10'
                }, {
                    preset: 'islands#redIcon',
                    iconColor: '#ff0000',
                    iconShadow: true
                }
            );

            myMap.geoObjects.add(myPlacemark);
        }
    </script>
@endsection
