<div class="card border mb-3 reviewer-editor-row">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <strong>Customer review</strong>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-reviewer-move="up" aria-label="Move reviewer up">↑</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-reviewer-move="down" aria-label="Move reviewer down">↓</button>
                <button type="button" class="btn btn-sm btn-outline-danger" data-reviewer-remove>Remove</button>
            </div>
        </div>
        <label class="form-label">Review photo or screenshot <span class="text-danger">*</span></label>
        @include('admin.layouts.partials.image-upload', [
            'valueName' => 'reviewers['.$rowIndex.'][image]',
            'imageValue' => $row['image'] ?? '',
            'uploadId' => 'reviewer-image-'.$rowIndex,
        ])
        <div class="row g-3 mt-1">
            <div class="col-md-6"><label class="form-label" for="reviewer-name-{{ $rowIndex }}">Reviewer name (optional)</label><input class="form-control" id="reviewer-name-{{ $rowIndex }}" name="reviewers[{{ $rowIndex }}][name]" maxlength="150" value="{{ $row['name'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label" for="reviewer-alt-{{ $rowIndex }}">Photo description for accessibility (optional)</label><input class="form-control" id="reviewer-alt-{{ $rowIndex }}" name="reviewers[{{ $rowIndex }}][alt]" maxlength="250" value="{{ $row['alt'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label" for="reviewer-rating-{{ $rowIndex }}">Rating (optional)</label><select class="form-select" id="reviewer-rating-{{ $rowIndex }}" name="reviewers[{{ $rowIndex }}][rating]"><option value="">No rating</option>@for($stars = 5; $stars >= 1; $stars--)<option value="{{ $stars }}" {{ (string) ($row['rating'] ?? '') === (string) $stars ? 'selected' : '' }}>{{ $stars }} / 5</option>@endfor</select></div>
            <div class="col-12"><label class="form-label" for="reviewer-caption-{{ $rowIndex }}">Review text (optional)</label><textarea class="form-control" id="reviewer-caption-{{ $rowIndex }}" name="reviewers[{{ $rowIndex }}][caption]" maxlength="2000" rows="3">{{ $row['caption'] ?? '' }}</textarea></div>
        </div>
        <input type="hidden" name="reviewers[{{ $rowIndex }}][published]" value="0">
        <label class="form-check mt-3"><input class="form-check-input" type="checkbox" name="reviewers[{{ $rowIndex }}][published]" value="1" {{ !empty($row['published']) ? 'checked' : '' }}> Show this reviewer on About Us</label>
    </div>
</div>
