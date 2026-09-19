<div class="card mt-4 border">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Page SEO</h5>
        <small class="text-muted">Search engine title, description and keywords.</small>
    </div>
    <div class="card-body">

        <div class="tab-content p-0 shadow-none">
            <div class="tab-pane fade show active" id="seo-en">
                <div class="mb-4">
                    <label class="form-label" for="seo-title-en">SEO Title </label>
                    <input id="seo-title-en" type="text" class="form-control" name="meta_data[title]" maxlength="255" value="{{ old('meta_data.title', $metaData->title ?? '') }}">
                    @error('meta_data.title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label" for="seo-description-en">SEO Description </label>
                    <textarea id="seo-description-en" rows="3" class="form-control" name="meta_data[description]" maxlength="1024">{{ old('meta_data.description', $metaData->description ?? '') }}</textarea>
                    @error('meta_data.description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="seo-keywords-en">SEO Keywords </label>
                    <textarea id="seo-keywords-en" rows="2" class="form-control" name="meta_data[key_words]" maxlength="1024">{{ old('meta_data.key_words', $metaData->key_words ?? '') }}</textarea>
                    @error('meta_data.key_words')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            
        </div>
    </div>
</div>
