@extends('template.app')
@section('page')
    <section class="about">
        <div class="container">
            <p class="text-small"><a href="{{ route('view.main') }}">Главная</a> — <span>О компании</span></p>
            <h2>О компании</h2>
            <div class="about__content">
                <img src="assets/images/main/about/image.png" alt="">
                <div class="about__text">
                    <p class="text-small">
                        <span style="font-weight: 600; color: var(--primary);">ООО "ТД ИнфраРэда"</span> — это динамично
                        развивающаяся компания, которая с 2018 года успешно
                        работает на
                        рынке энергоэффективного отопления и оборудования. Являясь официальным дистрибьютором таких
                        известных производителей, как ООО "НПП ИнфраРэда" и ООО "Светозартрейд", компания зарекомендовала
                        себя как надежный партнер для клиентов, заинтересованных в современных решениях для обогрева
                        помещений.
                    </p>
                    <p class="text-small">
                        Главной целью ООО "ТД ИнфраРэда" является предоставление высококачественного оборудования для
                        создания комфортных и энергоэффективных систем отопления. Компания ориентирована на внедрение
                        инновационных технологий, которые помогают потребителям экономить ресурсы, снижать затраты на
                        энергопотребление и минимизировать негативное воздействие на окружающую среду.
                    </p>
                    <p class="text-small">
                        Благодаря сотрудничеству с ООО "НПП ИнфраРэда" и ООО "Светозартрейд", ООО "ТД ИнфраРэда" предлагает
                        широкий спектр продукции, включая:
                        - Инфракрасные обогреватели — современные устройства, обеспечивающие равномерный и комфортный
                        обогрев помещений различного назначения: жилых домов, офисов, производственных площадей и торговых
                        центров.
                        - Энергосберегающее оборудование — системы, направленные на оптимизацию энергопотребления и
                        повышение эффективности работы отопительных приборов.
                        - Комплексные решения для отопления — разработка и реализация проектов "под ключ", учитывающих
                        особенности объекта и пожелания заказчика.
                    </p>
                    <p class="text-small">
                        Продукция, предлагаемая компанией, отличается высоким качеством, надежностью и долговечностью. Все
                        товары сертифицированы и соответствуют строгим стандартам безопасности.
                    </p>
                    <br>
                    <br>
                    <p class="text-small">
                        Преимущества работы с ООО "ТД ИнфраРэда":
                    </p>
                    <div style="display:flex; flex-direction: column; gap: 10px; margin-left: 10px;">
                        <p class="text-small">
                            1. Профессионализм и опыт</p>
                        <p class="text-small">
                            С момента основания в 2018 году компания зарекомендовала себя как эксперт в области
                            энергоэффективных технологий. Специалисты ООО "ТД ИнфраРэда" обладают глубокими знаниями и
                            опытом в
                            подборе оборудования, а также готовы предложить оптимальные решения для любых задач. </p>
                        <p class="text-small">
                            2. Широкая география поставок
                        </p>
                        <p class="text-small">
                            Компания осуществляет доставку продукции по всей территории России, обеспечивая доступность
                            своих
                            товаров для клиентов из разных регионов.
                        </p>
                        <p class="text-small">
                            3. Индивидуальный подход
                        </p>
                        <p class="text-small">
                            Каждый клиент получает персональное внимание: от консультации по выбору оборудования до
                            технической
                            поддержки после покупки.
                        </p>
                        <p class="text-small">
                            4. Гарантия качества
                        </p>
                        <p class="text-small">
                            Прямое сотрудничество с производителями позволяет ООО "ТД ИнфраРэда" гарантировать подлинность
                            продукции и предоставлять официальную гарантию на все товары.
                        </p>
                        <p class="text-small">
                            5. Выгодные условия сотрудничества
                        </p>
                        <p class="text-small">
                            Компания предлагает конкурентные цены, гибкую систему скидок и специальные условия для оптовых
                            покупателей и партнеров.
                        </p>
                    </div>
                    <br>
                    <br>
                    <p class="text-small">
                        Ассортимент продукции
                    </p>
                    <p class="text-small">
                        Почему выбирают ООО "ТД ИнфраРэда"?
                        ООО "ТД ИнфраРэда" — это не просто поставщик оборудования, а надежный партнер, который помогает
                        своим клиентам создавать уютные и экономичные пространства. Благодаря использованию передовых
                        технологий и внимательному отношению к потребностям заказчиков, компания ежегодно увеличивает число
                        довольных клиентов.
                    </p>
                    <br>
                    <br>
                    <p class="text-small">
                        Перспективы развития
                    </p>
                    <p class="text-small">
                        В планах ООО "ТД ИнфраРэда" — расширение ассортимента продукции, усиление позиций на рынке
                        энергоэффективных решений и выход на международный уровень. Компания продолжает активно сотрудничать
                        с ведущими производителями, внедряя новые технологии и совершенствуя качество обслуживания.
                    </p>
                    <p class="text-small">
                        ООО "ТД ИнфраРэда" — это команда профессионалов, которая стремится сделать энергоэффективное
                        отопление доступным для каждого. Если вы ищете надежного партнера для реализации своих проектов или
                        хотите модернизировать систему отопления с минимальными затратами, обратитесь в ООО "ТД ИнфраРэда".
                        Здесь вас ждут инновационные решения, высокий уровень сервиса и забота о вашем комфорте.
                    </p>
                    <p class="text-small">
                        Сделайте шаг к энергоэффективному будущему вместе с ООО "ТД ИнфраРэда"!
                    </p>
                </div>
            </div>

            <div class="company__form">
                <h2>Оставьте свои данные — позвоним, чтобы обсудить детали</h2>
                <form id="contactForm" method="POST" action="{{ route('send.contact') }}">
                    @csrf
                    <div id="form-error" class="error text-small" style="display: none; margin-bottom: 15px;"></div>
                    <div class="form__inputs">
                        <div class="form-input">
                            <label for="name" class="text-medium">Ваше имя <span style="color: red;">*</span></label>
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
                                    <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
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
    </section>
@endsection
