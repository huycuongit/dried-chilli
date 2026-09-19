@extends('frontend.layouts.master')

@php
    $locale = app()->getLocale();
    $nafuCopy = [
        'contact_eyebrow' => $homeContent('popup_contact_eyebrow'), 'contact_title' => $homeContent('popup_contact_title'),
        'contact_description' => $homeContent('popup_contact_description'),
        'contact_full_name_label' => $homeContent('popup_contact_full_name_label'), 'contact_form_email_label' => $homeContent('popup_contact_form_email_label'),
        'contact_phone_label' => $homeContent('popup_contact_phone_label'), 'contact_project_label' => $homeContent('popup_contact_project_label'),
        'contact_project_option_1' => $homeContent('popup_contact_project_option_1'), 'contact_budget_label' => $homeContent('popup_contact_budget_label'),
        'contact_budget_option_1' => $homeContent('popup_contact_budget_option_1'), 'contact_budget_option_2' => $homeContent('popup_contact_budget_option_2'),
        'contact_budget_option_3' => $homeContent('popup_contact_budget_option_3'), 'contact_budget_option_4' => $homeContent('popup_contact_budget_option_4'),
        'contact_budget_option_5' => $homeContent('popup_contact_budget_option_5'), 'contact_budget_option_6' => $homeContent('popup_contact_budget_option_6'),
        'contact_message_label' => $homeContent('popup_contact_message_label'), 'contact_submit' => $homeContent('popup_contact_submit'),
        'contact_success_title' => $homeContent('popup_contact_success_title'),
        'contact_success_description' => $homeContent('popup_contact_success_description'),
        'contact_success_close' => $homeContent('popup_contact_success_close'), 'seo_keywords' => $homeContent('popup_seo_keywords'),
    ];
    $homeSetting = fn (string $key, mixed $default = '') => $nafuCopy[$key] ?? $default;
@endphp
@section('meta')
    <meta name="description" content="Nafu Home Care — reliable home repairs, maintenance and improvements.">
    <meta name="keywords" content="{{ strip_tags($homeSetting('seo_keywords')) }}">
    <title>{{ $homeContent('home_text_1') }}</title>
    <meta property="og:type" content="website">
    <meta property="og:title" content="Nafu Home Care | Expert care for your home">
    <meta property="og:description" content="Reliable home repairs, maintenance and improvements.">
    <meta property="og:url" content="{{ page_route('home') }}">
    <link rel="canonical" href="{{ page_route('home') }}">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/feb-home.css') }}?v=20260901-13">
    <link rel="stylesheet" href="{{ asset($homeContent('home_image_13')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feb-hero.css') }}?v=20260918-3">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-home.css') }}?v=20260918-10">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-blog.css') }}?v=20260918-2">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-testimonials.css') }}?v=20260918-2">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush

@section('full-content')
    <main id="top">
        <section class="hero shell" aria-labelledby="hero-title">
            <div class="hero-copy">
                <h1 id="hero-title">{{ $homeContent('home_text_2') }}<br>{{ $homeContent('home_text_3') }}</h1>
                <p>{{ $homeContent('home_text_4') }}</p>
                <form class="hero-email" id="hero-email-form"><label class="hero-sr-only" for="hero-email">{{ $homeContent('home_text_5') }}</label><input id="hero-email" type="email" placeholder="Enter your email" autocomplete="email" required><button type="submit">{{ $homeContent('home_text_6') }}</button></form>
                <div class="hero-support">
                    <img src="{{ asset($homeContent('home_image_14')) }}" width="90" height="90" alt="" decoding="async">
                    <div><span>{{ $homeContent('home_text_7') }}</span><a href="tel:+61481818836">{{ $homeContent('home_text_8') }}</a></div>
                </div>
            </div>
            <div class="hero-visual">
                <img class="hero-photo" src="{{ asset($homeContent('home_image_15')) }}" width="800" height="900" alt="Nafu Home Care handyman at work" decoding="async" fetchpriority="high">
                <div class="hero-review"><strong><span aria-hidden="true">{{ $homeContent('home_text_9') }}</span>{{ $homeContent('home_text_10') }}</strong><span class="hero-stars" aria-label="Rated 4.9 out of 5">{{ $homeContent('home_text_11') }}</span><span>{{ $homeContent('home_text_12') }}</span></div>
            </div>
        </section>

        @include('frontend.layouts.partials.nafu-home-sections')
    </main>
    <div class="contact-modal" id="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title" hidden>
        <button class="contact-modal__backdrop" type="button" data-contact-close aria-label="Close contact form"></button>
        <div class="contact-modal__panel">
            <button class="contact-modal__close" type="button" data-contact-close aria-label="Close">×</button>
            <div class="contact-modal__form-view">
                <span class="contact-modal__eyebrow">{!! $homeSetting('contact_eyebrow') !!}</span>
                <h2 id="contact-modal-title">{!! $homeSetting('contact_title') !!}</h2>
                <p class="contact-modal__intro">{!! $homeSetting('contact_description') !!}</p>

                <form id="contact-form" action="{{ route('contact.store', [], false) }}" method="POST" novalidate
                    data-sending-text="{{ strip_tags($homeSetting('contact_sending', 'Sending…')) }}"
                    data-error-text="{{ strip_tags($homeSetting('contact_error', 'Unable to send your request right now. Please try again.')) }}">
                @csrf
                <input type="hidden" name="source" value="nafu-home-care-enquiry">
                <div class="contact-form__grid">
                    <label for="contact-full-name"><span>{!! $homeSetting('contact_full_name_label') !!}</span><input id="contact-full-name" name="full_name" type="text" autocomplete="name" required></label>
                    <label for="contact-email"><span>{!! $homeSetting('contact_form_email_label') !!}</span><input id="contact-email" name="email" type="email" autocomplete="email"></label>
                    <label class="contact-phone-field" for="contact-phone"><span>{!! $homeSetting('contact_phone_label') !!}</span>
                        <span class="contact-phone-control">
                            <select id="contact-phone-country" name="phone_country" aria-label="Country calling code">
                                <option value="+84">🇻🇳 Vietnam +84</option>
                                <option value="+1">🇺🇸 United States +1</option>
                                <option value="+1">🇨🇦 Canada +1</option>
                                <option value="+44">🇬🇧 United Kingdom +44</option>
                                <option value="+61" selected>🇦🇺 Australia +61</option>
                                <option value="+64">🇳🇿 New Zealand +64</option>
                                <option value="+65">🇸🇬 Singapore +65</option>
                                <option value="+66">🇹🇭 Thailand +66</option>
                                <option value="+60">🇲🇾 Malaysia +60</option>
                                <option value="+62">🇮🇩 Indonesia +62</option>
                                <option value="+63">🇵🇭 Philippines +63</option>
                                <option value="+855">🇰🇭 Cambodia +855</option>
                                <option value="+856">🇱🇦 Laos +856</option>
                                <option value="+95">🇲🇲 Myanmar +95</option>
                                <option value="+86">🇨🇳 China +86</option>
                                <option value="+852">🇭🇰 Hong Kong +852</option>
                                <option value="+886">🇹🇼 Taiwan +886</option>
                                <option value="+81">🇯🇵 Japan +81</option>
                                <option value="+82">🇰🇷 South Korea +82</option>
                                <option value="+91">🇮🇳 India +91</option>
                                <option value="+971">🇦🇪 UAE +971</option>
                                <option value="+49">🇩🇪 Germany +49</option>
                                <option value="+33">🇫🇷 France +33</option>
                                <option value="+31">🇳🇱 Netherlands +31</option>
                                <option value="+34">🇪🇸 Spain +34</option>
                                <option value="+39">🇮🇹 Italy +39</option>
                                <option value="+7">🇷🇺 Russia +7</option>
                                <option value="+55">🇧🇷 Brazil +55</option>
                                <option value="+52">🇲🇽 Mexico +52</option>
                                <option value="+27">🇿🇦 South Africa +27</option>
                            </select>
                            <input id="contact-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="481 234 567">
                        </span>
                    </label>

                    <label for="contact-project-type"><span>{!! $homeSetting('contact_project_label') !!}</span>
                        <select id="contact-project-type" name="project_type" required>
                            <option value="">{!! $homeSetting('contact_project_option_1') !!}</option>
                @foreach(config('nafu-services') as $slug => $service)
                                <option value="{{ $slug }}">{{ $service['name'] }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                    </label>
                    <label for="contact-budget"><span>{!! $homeSetting('contact_budget_label') !!}</span>
                        <select id="contact-budget" name="budget">
                            <option value="">{!! $homeSetting('contact_budget_option_1') !!}</option>
                            <option value="under-1000">{!! $homeSetting('contact_budget_option_2') !!}</option>
                            <option value="1000-3000">{!! $homeSetting('contact_budget_option_3') !!}</option>
                            <option value="3000-5000">{!! $homeSetting('contact_budget_option_4') !!}</option>
                            <option value="over-5000">{!! $homeSetting('contact_budget_option_5') !!}</option>
                            <option value="discuss">{!! $homeSetting('contact_budget_option_6') !!}</option>
                        </select>
                    </label>
                    <label class="contact-form__message" for="contact-message"><span>{!! $homeSetting('contact_message_label') !!}</span><textarea id="contact-message" name="message" rows="4" required></textarea></label>
                </div>
                    <p class="contact-form__status" role="status" aria-live="polite"></p>
                    <button class="contact-form__submit" type="submit"><i></i><span>{!! $homeSetting('contact_submit') !!}</span></button>
                </form>
            </div>
            <div class="contact-modal__success" role="status" aria-live="polite" tabindex="-1" hidden>
                <span class="contact-success__icon" aria-hidden="true"><i></i></span>
                <span class="contact-modal__eyebrow">NAFU HOME CARE</span>
                <h2>{!! $homeSetting('contact_success_title', 'Request sent successfully!') !!}</h2>
                <p>{!! $homeSetting('contact_success_description', 'Thank you for reaching out. Nafu Home Care will get back to you shortly.') !!}</p>
                <button class="contact-success__button" type="button" data-contact-close>{!! $homeSetting('contact_success_close', 'Done') !!}</button>
            </div>
        </div>
    </div>
    <script>
        (() => {
            const modal = document.querySelector('#contact-modal');
            const form = document.querySelector('#contact-form');
            const status = form?.querySelector('.contact-form__status');
            const submit = form?.querySelector('.contact-form__submit');
            const formView = modal?.querySelector('.contact-modal__form-view');
            const successView = modal?.querySelector('.contact-modal__success');

            let lastFocused = null;
            if (!modal || !form || !status || !submit || !formView || !successView) return;
            const submitLabel = submit.querySelector('span');
            const submitText = submitLabel?.textContent || '';
            const getField = (name) => Array.from(form.elements).find((element) => element.name === name);
            const clearFieldError = (name) => {
                const field = getField(name);
                if (!field) return;

                field.removeAttribute('aria-invalid');
                form.querySelector('[data-error-for="' + name + '"]')?.remove();

                const wrapper = field.closest('label');
                if (wrapper && !wrapper.querySelector('.contact-field-error')) {
                    wrapper.classList.remove('has-error');
                }
            };

            const clearFieldErrors = () => {
                form.querySelectorAll('.contact-field-error').forEach((error) => error.remove());
                form.querySelectorAll('[aria-invalid="true"]').forEach((field) => field.removeAttribute('aria-invalid'));
                form.querySelectorAll('.has-error').forEach((wrapper) => wrapper.classList.remove('has-error'));
            };

            const showFieldErrors = (errors) => {
                let firstInvalid = null;

                Object.entries(errors).forEach(([name, messages]) => {
                    const field = getField(name);
                    if (!field) return;

                    const wrapper = field.closest('label');
                    if (!wrapper) return;

                    field.setAttribute('aria-invalid', 'true');
                    wrapper.classList.add('has-error');

                    const error = document.createElement('small');
                    error.className = 'contact-field-error';
                    error.dataset.errorFor = name;
                    error.textContent = Array.isArray(messages) ? messages[0] : messages;
                    wrapper.appendChild(error);
                    firstInvalid ??= field;
                });

                firstInvalid?.focus();
            };

            form.querySelectorAll('input, select, textarea').forEach((field) => {
                ['input', 'change'].forEach((eventName) => {
                    field.addEventListener(eventName, () => clearFieldError(field.name));
                });
            });

            const openModal = (event) => {
                event?.preventDefault();
                lastFocused = document.activeElement;
                formView.hidden = false;
                successView.hidden = true;
                modal.hidden = false;
                document.body.classList.add('contact-modal-open');
                requestAnimationFrame(() => modal.classList.add('is-open'));
                modal.querySelector('input:not([type="hidden"])')?.focus();
            };
            const closeModal = () => {
                modal.classList.remove('is-open');
                document.body.classList.remove('contact-modal-open');
                setTimeout(() => {
                    modal.hidden = true;
                    formView.hidden = false;
                    successView.hidden = true;
                }, 220);
                lastFocused?.focus();
            };
            if (window.location.hash === '#contact-modal') {
                openModal();
                const service = new URLSearchParams(window.location.search).get('service');
                const type = document.querySelector('#contact-project-type');
                if (service && type && Array.from(type.options).some(option => option.value === service)) type.value = service;
            }

            document.querySelector('#hero-email-form')?.addEventListener('submit', (event) => {
                openModal(event);
                const emailField = getField('email');
                if (emailField) {
                    emailField.value = document.querySelector('#hero-email').value.trim();
                    clearFieldError('email');
                }
            });

            document.addEventListener('click', (event) => {
                if (event.target.closest('.js-open-contact')) openModal(event);
            });
            document.addEventListener('keydown', (event) => {
                if (event.target.closest('.js-open-contact[role="button"]') && ['Enter', ' '].includes(event.key)) openModal(event);
            });
            modal.querySelectorAll('[data-contact-close]').forEach((button) => button.addEventListener('click', closeModal));
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.hidden) closeModal();
            });

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearFieldErrors();
                status.className = 'contact-form__status';
                status.textContent = '';
                submit.disabled = true;
                submit.classList.add('is-loading');
                if (submitLabel) submitLabel.textContent = form.dataset.sendingText || 'Sending…';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        credentials: 'same-origin',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'X-FEB-Language': document.documentElement.lang
                        }
                    });
                    const payload = await response.json();

                    if (!response.ok) {
                        if (payload.errors) {
                            showFieldErrors(payload.errors);

                            return;
                        }

                        throw new Error(payload.message || 'Unable to send your request.');
                    }

                    form.reset();
                    formView.hidden = true;
                    successView.hidden = false;
                    successView.focus();
                } catch (error) {
                    console.error(error);
                    status.classList.add('is-error');
                    status.textContent = form.dataset.errorText || 'Unable to send your request right now. Please try again.';
                } finally {
                    submit.disabled = false;
                    submit.classList.remove('is-loading');
                    if (submitLabel) submitLabel.textContent = submitText;
                }
            });
        })();
        (() => {
            const floating = document.querySelector('.floating-contact');
            const toggle = floating?.querySelector('.floating-contact__toggle');
            const hero = document.querySelector('.hero');
            if (!floating || !toggle || !hero) return;

            let ticking = false;
            const updateVisibility = () => {
                const showAfter = hero.offsetTop + hero.offsetHeight - 40;
                floating.classList.toggle('is-visible', window.scrollY >= showAfter);
                if (window.scrollY < showAfter) {
                    floating.classList.remove('is-expanded');
                    toggle.setAttribute('aria-expanded', 'false');
                }
                ticking = false;
            };
            const requestUpdate = () => {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(updateVisibility);
            };

            toggle.addEventListener('click', () => {
                const expanded = floating.classList.toggle('is-expanded');
                toggle.setAttribute('aria-expanded', String(expanded));
            });
            floating.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
                floating.classList.remove('is-expanded');
                toggle.setAttribute('aria-expanded', 'false');
            }));
            document.addEventListener('click', (event) => {
                if (floating.contains(event.target)) return;
                floating.classList.remove('is-expanded');
                toggle.setAttribute('aria-expanded', 'false');
            });
            document.addEventListener('keydown', (event) => {
                if (event.key !== 'Escape') return;
                floating.classList.remove('is-expanded');
                toggle.setAttribute('aria-expanded', 'false');
            });
            window.addEventListener('scroll', requestUpdate, { passive: true });
            updateVisibility();
        })();
        (() => {
            const rotator = document.querySelector('.word-rotator');
            const words = [...document.querySelectorAll('.word-rotator .word-set span')];
            if (!rotator || !words.length) return;

            let frame = 0;

            const updateActiveWord = () => {
                const rotatorRect = rotator.getBoundingClientRect();
                const centerY = rotatorRect.top + rotatorRect.height / 2;
                let activeWord = null;
                let shortestDistance = Infinity;

                words.forEach((word) => {
                    const rect = word.getBoundingClientRect();
                    const distance = Math.abs(rect.top + rect.height / 2 - centerY);
                    if (distance < shortestDistance) {
                        shortestDistance = distance;
                        activeWord = word;
                    }
                });

                words.forEach((word) => word.classList.toggle('is-active', word === activeWord));
                frame = requestAnimationFrame(updateActiveWord);
            };

            if (!('IntersectionObserver' in window)) return;

            new IntersectionObserver(([entry]) => {
                if (entry.isIntersecting && !frame) {
                    frame = requestAnimationFrame(updateActiveWord);
                } else if (!entry.isIntersecting && frame) {
                    cancelAnimationFrame(frame);
                    frame = 0;
                }
            }, { rootMargin: '120px 0px' }).observe(rotator);
        })();
        (() => {
            const process = document.querySelector('.process');
            const steps = [...document.querySelectorAll('.process-step')];
            if (!process || !steps.length || !('IntersectionObserver' in window)) return;

            process.classList.add('process-reveal-ready');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, { threshold: 0.18, rootMargin: '0px 0px -4% 0px' });

            steps.forEach((step, index) => {
                step.style.setProperty('--reveal-delay', `${Math.min(index * 70, 210)}ms`);
                observer.observe(step);
            });
        })();
        (() => {
            const wall = document.querySelector('.work-wall');
            const cursor = wall?.querySelector('.project-cursor');
            if (!wall || !cursor || !window.matchMedia('(pointer: fine)').matches) return;

            let currentX = 0;
            let currentY = 0;
            let targetX = 0;
            let targetY = 0;
            let frame = 0;
            let active = false;

            const draw = () => {
                currentX += (targetX - currentX) * .2;
                currentY += (targetY - currentY) * .2;
                cursor.style.setProperty('--cursor-x', `${currentX}px`);
                cursor.style.setProperty('--cursor-y', `${currentY}px`);
                frame = active && (Math.abs(targetX - currentX) > .1 || Math.abs(targetY - currentY) > .1)
                    ? requestAnimationFrame(draw)
                    : 0;
            };
            const setTarget = (event, immediate = false) => {
                const rect = wall.getBoundingClientRect();
                targetX = event.clientX - rect.left;
                targetY = event.clientY - rect.top;
                if (immediate) {
                    currentX = targetX;
                    currentY = targetY;
                }
                if (!frame) frame = requestAnimationFrame(draw);
            };

            const updateHoveredProject = (event, immediate = false) => {
                const projectLink = event.target.closest('.work-reel-set > a');
                active = Boolean(projectLink);
                cursor.classList.toggle('is-visible', active);
                if (active) setTarget(event, immediate);
            };

            wall.addEventListener('pointerenter', (event) => updateHoveredProject(event, true));
            wall.addEventListener('pointermove', (event) => updateHoveredProject(event));
            wall.addEventListener('pointerleave', () => {
                active = false;
                cursor.classList.remove('is-visible');
            });
        })();
    </script>
    <script src="{{ asset($homeContent('home_image_16')) }}?v=20260918-10" defer></script>
@endsection

