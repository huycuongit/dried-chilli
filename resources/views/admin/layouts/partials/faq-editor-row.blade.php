<div class="card border mb-3"><div class="card-body">
    @if(!empty($row['id']))<input type="hidden" name="faq_entries[{{ $rowIndex }}][id]" value="{{ $row['id'] }}">@endif
    <div class="mb-3"><label class="form-label" for="faq-question-{{ $rowIndex }}">Question</label><input class="form-control" id="faq-question-{{ $rowIndex }}" name="faq_entries[{{ $rowIndex }}][question]" value="{{ $row['question'] ?? '' }}" required maxlength="500"></div>
    <div class="mb-3"><label class="form-label" for="faq-answer-{{ $rowIndex }}">Answer</label><textarea class="form-control" id="faq-answer-{{ $rowIndex }}" name="faq_entries[{{ $rowIndex }}][answer]" rows="3" required>{{ $row['answer'] ?? '' }}</textarea></div>
    <div class="d-flex flex-wrap gap-3 align-items-center">
        <label>Display order <input type="number" class="form-control form-control-sm" name="faq_entries[{{ $rowIndex }}][sort_order]" min="0" max="100000" value="{{ $row['sort_order'] ?? 0 }}"></label>
        <input type="hidden" name="faq_entries[{{ $rowIndex }}][is_active]" value="0">
        <label class="form-check"><input class="form-check-input" type="checkbox" name="faq_entries[{{ $rowIndex }}][is_active]" value="1" {{ !empty($row['is_active']) || !isset($row['is_active']) ? 'checked' : '' }}> Published</label>
        @if(!empty($row['id']))<label class="form-check text-danger"><input class="form-check-input" type="checkbox" name="faq_entries[{{ $rowIndex }}][delete]" value="1" data-faq-delete {{ !empty($row['delete']) ? 'checked' : '' }}> Delete on save</label>@else<button type="button" class="btn btn-sm btn-outline-danger" data-remove-new-faq>Remove</button>@endif
    </div>
</div></div>
