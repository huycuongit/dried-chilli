@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-5 fw-bold">Frequently Asked Questions</h2>
            
            <div class="accordion" id="faqAccordion">
                @forelse($faqs as $index => $faq)
                <div class="accordion-item mb-3 border shadow-sm">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {{ $faq->answer }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">No FAQs available at the moment.</div>
                @endforelse
            </div>
            
            <div class="text-center mt-5">
                <p>Still have questions?</p>
                <a href="{{ route('contact.page') }}" class="btn btn-outline-dark">Contact Us</a>
            </div>
        </div>
    </div>
</div>
@endsection
