(function () {
    'use strict';

    const previewTemplate = `<div class="dz-preview dz-file-preview">
        <div class="dz-details">
            <div class="dz-thumbnail">
                <img data-dz-thumbnail>
                <span class="dz-nopreview">No preview</span>
                <div class="dz-success-mark"></div>
                <div class="dz-error-mark"></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div></div>
            </div>
            <div class="dz-filename" data-dz-name></div>
            <div class="dz-size" data-dz-size></div>
            <a href="#" class="dz-remove" data-dz-remove>Remove image</a>
        </div>
    </div>`;

    window.NafuDropzone = {
        mount(element, hiddenInput, existingName) {
            if (!element || !hiddenInput || typeof Dropzone === 'undefined') return null;
            if (element.dropzone) return element.dropzone;
            Dropzone.autoDiscover = false;

            return new Dropzone(element, {
                url: '/', autoProcessQueue: false, maxFiles: 1, maxFilesize: 5,
                acceptedFiles: 'image/jpeg,image/png,image/webp,image/gif',
                previewTemplate,
                init() {
                    if (hiddenInput.value) {
                        const mock = { name: existingName || 'Current image', size: 1234, accepted: true };
                        this.emit('addedfile', mock);
                        this.emit('thumbnail', mock, hiddenInput.value);
                        this.emit('complete', mock);
                        this.files.push(mock);
                    }
                    this.on('addedfile', file => {
                        if (this.files.length > 1) this.removeFile(this.files[0]);
                        if (!(file instanceof File)) return;
                        const reader = new FileReader();
                        reader.addEventListener('load', () => hiddenInput.value = reader.result, { once: true });
                        reader.readAsDataURL(file);
                    });
                    this.on('removedfile', file => {
                        if (this.files.length === 0 || file instanceof File) hiddenInput.value = '';
                    });
                }
            });
        }
    };
})();
