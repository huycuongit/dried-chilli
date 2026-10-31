(function () {
    'use strict';

    window.NafuQuill = {
        mount(editorSelector, inputSelector) {
            const element = document.querySelector(editorSelector);
            const input = document.querySelector(inputSelector);
            if (!element || !input || typeof Quill === 'undefined') return null;
            if (element.nafuQuill) return element.nafuQuill;

            // Keep editable native paragraphs/headings in the seeded service layout.
            const Parchment = Quill.import('parchment');
            Quill.register(new Parchment.Attributor.Attribute('servicePart', 'data-service-part', {
                scope: Parchment.Scope.BLOCK,
                whitelist: ['gallery-left', 'gallery-right', 'icon-1', 'icon-2', 'icon-3', 'title-1', 'title-2', 'title-3', 'body-1', 'body-2', 'body-3'],
            }), true);

            let selectedImage = null;
            let uploading = 0;
            const submitButtonStates = new Map();
            const toolbar = [
                ['undo', 'redo'],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ font: [] }, { size: ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ script: 'sub' }, { script: 'super' }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ align: [] }, { direction: 'rtl' }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video', 'formula'],
                ['imageSize', 'imageAlt', 'source', 'clean'],
            ];

            function editImage(attribute) {
                if (!selectedImage || !element.contains(selectedImage)) {
                    AdminUI.toast('Click an image in the editor first.', 'error');
                    return;
                }
                const value = prompt(attribute === 'width' ? 'Image width in pixels (leave blank for automatic):' : 'Alternative text:', selectedImage.getAttribute(attribute) || '');
                if (value === null) return;
                if (attribute === 'width' && value !== '' && !/^[1-9][0-9]{0,3}$/.test(value)) {
                    AdminUI.toast('Please enter a width between 1 and 9999 pixels.', 'error');
                    return;
                }
                const blot = Quill.find(selectedImage);
                if (!blot) return;
                quill.history.cutoff();
                quill.formatText(quill.getIndex(blot), 1, attribute, value || false, 'user');
                sync();
            }

            function editSource() {
                const dialog = document.createElement('dialog');
                dialog.className = 'nafu-quill-source';
                const heading = document.createElement('h3');
                heading.textContent = 'Edit HTML';
                const note = document.createElement('p');
                note.textContent = 'Only HTML formats supported by Quill are retained. Tables and arbitrary page layouts are not supported.';
                const field = document.createElement('textarea');
                field.setAttribute('aria-label', 'HTML content');
                field.spellcheck = false;
                field.value = quill.root.innerHTML;
                const actions = document.createElement('div');
                actions.className = 'nafu-quill-source-actions';
                const cancel = document.createElement('button');
                cancel.type = 'button';
                cancel.textContent = 'Cancel';
                const apply = document.createElement('button');
                apply.type = 'button';
                apply.textContent = 'Apply HTML';
                cancel.addEventListener('click', () => dialog.close());
                apply.addEventListener('click', () => {
                    quill.history.cutoff();
                    quill.clipboard.dangerouslyPasteHTML(field.value, 'user');
                    sync();
                    dialog.close();
                });
                actions.append(cancel, apply);
                dialog.append(heading, note, field, actions);
                dialog.addEventListener('close', () => { dialog.remove(); quill.focus(); }, { once: true });
                document.body.append(dialog);
                dialog.showModal();
                field.focus();
            }

            async function uploadImage(file) {
                if (!['image/jpeg', 'image/png', 'image/webp', 'image/gif'].includes(file.type) || file.size > 5 * 1024 * 1024) {
                    AdminUI.toast('Please choose a JPG, PNG, WEBP or GIF image up to 5 MB.', 'error');
                    return;
                }
                const url = window.nafuEditorUploadUrl;
                if (!url) { AdminUI.toast('Image upload is not configured.', 'error'); return; }
                const range = quill.getSelection(true);
                uploading++;
                if (uploading === 1) {
                    element.closest('form')?.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(button => {
                        submitButtonStates.set(button, button.disabled);
                        button.disabled = true;
                    });
                }
                status.textContent = 'Uploading image…';
                try {
                    const body = new FormData();
                    body.append('image', file);
                    const response = await fetch(url, {
                        method: 'POST', body, credentials: 'same-origin',
                        headers: { Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    });
                    const result = await response.json();
                    if (!response.ok || !result.url) throw new Error(result.errors?.image?.[0] || result.message || 'Image upload failed.');
                    const index = Math.min(range?.index ?? quill.getLength() - 1, quill.getLength() - 1);
                    quill.history.cutoff();
                    quill.insertEmbed(index, 'image', result.url, 'user');
                    quill.setSelection(index + 1, 0, 'silent');
                    sync();
                    status.textContent = 'Image uploaded.';
                } catch (error) {
                    status.textContent = error.message;
                    AdminUI.toast(error.message, 'error');
                } finally {
                    uploading--;
                    if (!uploading) {
                        submitButtonStates.forEach((disabled, button) => { button.disabled = disabled; });
                        submitButtonStates.clear();
                    }
                }
            }

            element.innerHTML = '';
            const quill = new Quill(element, {
                theme: 'snow', placeholder: 'Write your content…',
                modules: {
                    formula: true,
                    history: { delay: 500, maxStack: 200, userOnly: true },
                    toolbar: {
                        container: toolbar,
                        handlers: {
                            undo() { this.quill.history.undo(); },
                            redo() { this.quill.history.redo(); },
                            source: editSource,
                            imageSize() { editImage('width'); },
                            imageAlt() { editImage('alt'); },
                            image() {
                                const picker = document.createElement('input');
                                picker.type = 'file';
                                picker.accept = 'image/jpeg,image/png,image/webp,image/gif';
                                picker.addEventListener('change', () => { if (picker.files[0]) uploadImage(picker.files[0]); }, { once: true });
                                picker.click();
                            },
                        },
                    },
                },
            });
            const sync = () => {
                input.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
                input.dispatchEvent(new Event('input', { bubbles: true }));
            };
            quill.clipboard.dangerouslyPasteHTML(input.value, 'silent');
            quill.history.clear();
            quill.on('text-change', sync);
            const toolbarElement = quill.getModule('toolbar').container;
            toolbarElement.classList.add('nafu-quill-toolbar');
            const customButtons = {
                undo: ['↶', 'Undo'], redo: ['↷', 'Redo'],
                imageSize: ['Size', 'Image size'], imageAlt: ['Alt', 'Image alternative text'],
                source: ['HTML', 'Edit HTML'],
            };
            Object.entries(customButtons).forEach(([name, [text, title]]) => {
                const button = toolbarElement.querySelector('.ql-' + name);
                button.textContent = text;
                button.title = title;
                button.setAttribute('aria-label', title);
            });
            toolbarElement.querySelectorAll('button').forEach(button => {
                if (!button.hasAttribute('aria-label')) {
                    const name = Array.from(button.classList).find(name => name.startsWith('ql-'))?.slice(3) || 'Format';
                    const label = name + (button.value ? ' ' + button.value : '');
                    button.title = label;
                    button.setAttribute('aria-label', label);
                }
            });
            const status = document.createElement('div');
            status.className = 'nafu-quill-status';
            status.setAttribute('role', 'status');
            status.textContent = 'Images: JPG, PNG, WEBP or GIF up to 5 MB. Click an image to edit its size or alt text.';
            element.after(status);
            element.addEventListener('click', event => {
                selectedImage = event.target.tagName === 'IMG' ? event.target : null;
            });
            quill.root.addEventListener('dragover', event => {
                if (Array.from(event.dataTransfer?.types || []).includes('Files')) event.preventDefault();
            });
            ['paste', 'drop'].forEach(eventName => quill.root.addEventListener(eventName, event => {
                const files = Array.from((event.clipboardData || event.dataTransfer)?.files || []);
                if (files.some(file => file.type.startsWith('image/'))) {
                    event.preventDefault();
                    event.stopPropagation();
                    files.filter(file => file.type.startsWith('image/')).forEach(uploadImage);
                }
            }, true));
            element.closest('form')?.addEventListener('submit', event => {
                if (uploading) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    AdminUI.toast('Please wait for image uploads to finish.', 'error');
                }
                sync();
            }, true);
            element.nafuQuill = quill;
            return quill;
        },
    };
})();
