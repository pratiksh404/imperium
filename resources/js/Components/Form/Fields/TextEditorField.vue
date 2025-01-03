<template>
    <Button :label="'Open ' + label" @click="toggleTextEditor" :size="size" fluid icon="ri-external-link-line" />
    <Popover ref="textEditorPanel" style="width: 80vw">
        <!-- Responsive Toolbar -->
        <Toolbar class="p-toolbar-responsive">
            <template #start>
                <div class="toolbar-buttons">
                    <!-- Text Styles -->
                    <Button icon="ri-bold" @click="toggleBold" class="mx-1"
                        :severity="editor.isActive('bold') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-italic" @click="toggleItalic" class="mx-1"
                        :severity="editor.isActive('italic') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-strikethrough" @click="toggleStrike" class="mx-1"
                        :severity="editor.isActive('strike') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-code-line" @click="toggleCode" class="mx-1"
                        :severity="editor.isActive('code') ? 'contrast' : 'secondary'" />

                    <!-- Headings -->
                    <Button label="H1" @click="toggleHeading(1)" class="mx-1"
                        :severity="editor.isActive('heading', { level: 1 }) ? 'contrast' : 'secondary'" />
                    <Button label="H2" @click="toggleHeading(2)" class="mx-1"
                        :severity="editor.isActive('heading', { level: 2 }) ? 'contrast' : 'secondary'" />
                    <Button label="H3" @click="toggleHeading(3)" class="mx-1"
                        :severity="editor.isActive('heading', { level: 3 }) ? 'contrast' : 'secondary'" />

                    <!-- Lists -->
                    <Button icon="ri-list-unordered" @click="toggleBulletList" class="mx-1"
                        :severity="editor.isActive('bulletList') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-list-ordered" @click="toggleOrderedList" class="mx-1"
                        :severity="editor.isActive('orderedList') ? 'contrast' : 'secondary'" />

                    <!-- Block Styles -->
                    <Button icon="ri-double-quotes-l" @click="toggleBlockquote" class="mx-1"
                        :severity="editor.isActive('blockquote') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-separator" @click="toggleHorizontalRule" class="mx-1"
                        :severity="editor.isActive('horizontalRule') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-code-s-slash-line" @click="toggleCodeBlock" class="mx-1"
                        :severity="editor.isActive('codeBlock') ? 'contrast' : 'secondary'" />
                    <Button icon="ri-line-height" @click="toggleHardBreak" class="mx-1"
                        :severity="editor.isActive('hardBreak') ? 'contrast' : 'secondary'" />
                    <ButtonGroup>
                        <Button icon="ri-align-left" @click="editor.chain().focus().setTextAlign('left').run()"
                            :severity="editor.isActive('textAlign', 'left') ? 'contrast' : 'secondary'" />
                        <Button icon="ri-align-center" @click="editor.chain().focus().setTextAlign('center').run()"
                            :severity="editor.isActive('textAlign', 'center') ? 'contrast' : 'secondary'" />
                        <Button icon="ri-align-right" @click="editor.chain().focus().setTextAlign('right').run()"
                            :severity="editor.isActive('textAlign', 'right') ? 'contrast' : 'secondary'" />
                    </ButtonGroup>
                    <Button icon=" ri-youtube-fill" @click="toggleYoutubeLink" class="mx-1" severity="secondary" />
                    <Popover ref="youtubeLinkPanel" style="width: 35vw">
                        <div class="row mb-1">
                            <div class="col-6">
                                <FloatLabel variant="on">
                                    <InputText id="youtubeLinkWidth" v-model="youtubeLinkWidth" fluid size="small" />
                                    <label for="youtubeLinkWidth">Width</label>
                                </FloatLabel>
                            </div>
                            <div class="col-6">
                                <FloatLabel variant="on">
                                    <InputText id="youtubeLinkHeight" v-model="youtubeLinkHeight" fluid size="small" />
                                    <label for="youtubeLinkHeight">Height</label>
                                </FloatLabel>
                            </div>
                        </div>
                        <IconField>
                            <InputIcon class="ri-links-line" />
                            <InputText v-model="youtubeLink" placeholder="Youtube Link" fluid />
                        </IconField>
                        <Divider />
                        <Button label="Insert" @click="insertYoutubeLink" fluid />
                    </Popover>
                    <input type="color" @input="editor.chain().focus().setColor($event.target.value).run()"
                        :value="editor.getAttributes('textStyle').color" style="height:40px;width:40px;" />
                </div>
            </template>
            <template #end>
                <div class="toolbar-actions">
                    <Button icon="ri-arrow-go-back-line" @click="undo" class="mx-1" severity="secondary" text
                        :disabled="!editor.can().undo()" />
                    <Button icon="ri-arrow-go-forward-line" @click="redo" class="mx-1" severity="secondary" text
                        :disabled="!editor.can().redo()" />
                </div>
            </template>
        </Toolbar>

        <!-- Editor -->
        <div class="tiptap-editor">
            <EditorContent :editor="editor" :id="id" :class="class" />
        </div>
    </Popover>
</template>

<script setup>
import { ref, watch, defineProps, computed } from "vue";
import { Editor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import { Color } from '@tiptap/extension-color'
import Youtube from '@tiptap/extension-youtube'
import Placeholder from '@tiptap/extension-placeholder'
import TextStyle from '@tiptap/extension-text-style'
import TextAlign from '@tiptap/extension-text-align'
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";

// Editor content model
const model = ref(null);

const youtubeLinkPanel = ref();
const youtubeLink = ref(null);
const youtubeLinkWidth = ref(null);
const youtubeLinkHeight = ref(null);

const props = defineProps({
    modelValue: {
        type: String,
        default: null,
    },
    placeholder: { type: String, default: 'Write something …' },
    required: { type: Boolean, default: false },
    readOnly: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    class: { type: String },
    id: { type: String, default: () => `input-${Math.random().toString(36).substr(2, 9)}` },
    size: { type: String, default: null },
    error: { type: String, default: null },
    field: { type: Object, default: () => ({}) },
});

const textEditorPanel = ref();

const toggleTextEditor = (event) => {
    textEditorPanel.value.toggle(event);
};

const label = computed(() => props.field.label ?? 'Open Text Editor');

const toggleYoutubeLink = (event) => {
    youtubeLinkPanel.value.toggle(event);
};

// Initialize the editor
const editor = ref(
    new Editor({
        extensions: [
            StarterKit,
            Youtube,
            TextStyle,
            Color,
            TextAlign.configure({
                types: ['heading', 'paragraph'],
            }), ,
            Placeholder.configure({
                // Use a placeholder:
                placeholder: props.placeholder,
            }),
        ],
        content: model.value,
        onUpdate({ editor }) {
            model.value = editor.getHTML();
        },
    })
);

// Watch for external model changes
watch(model, (newValue) => {
    if (editor.value.getHTML() !== newValue) {
        editor.value.commands.setContent(newValue);
    }
});

// Toolbar actions
const toggleBold = () => editor.value.chain().focus().toggleBold().run();
const toggleItalic = () => editor.value.chain().focus().toggleItalic().run();
const toggleStrike = () => editor.value.chain().focus().toggleStrike().run();
const toggleCode = () => editor.value.chain().focus().toggleCode().run();
const toggleHeading = (level) => editor.value.chain().focus().toggleHeading({ level }).run();
const toggleBulletList = () => editor.value.chain().focus().toggleBulletList().run();
const toggleOrderedList = () => editor.value.chain().focus().toggleOrderedList().run();
const toggleBlockquote = () => editor.value.chain().focus().toggleBlockquote().run();
const toggleHorizontalRule = () => editor.value.chain().focus().setHorizontalRule().run();
const toggleCodeBlock = () => editor.value.chain().focus().toggleCodeBlock().run();
const toggleHardBreak = () => editor.value.chain().focus().setHardBreak().run();
const undo = () => editor.value.chain().focus().undo().run();
const redo = () => editor.value.chain().focus().redo().run();
const insertYoutubeLink = () => youtubeLink.value !== null ? editor.value.commands.setYoutubeVideo({ src: youtubeLink.value, width: youtubeLinkWidth.value, height: youtubeLinkHeight.value }) : toast.error('Youtube link is required');
</script>
<style>
.tiptap-editor {
    min-height: 200px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 1rem;
}

.toolbar-buttons,
.toolbar-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

blockquote {
    border-left: 3px solid #ccc;
    margin: 1.5rem 0;
    padding-left: 1rem;
}

.ProseMirror:focus {
    outline: none;
}

/* Responsive toolbar */
.p-toolbar-responsive .toolbar-buttons,
.p-toolbar-responsive .toolbar-actions {
    justify-content: space-between;
}

.tiptap-editor .ProseMirror:focus {
    outline: none;
}

@media (max-width: 768px) {

    .toolbar-buttons,
    .toolbar-actions {
        flex-direction: column;
        align-items: stretch;
    }
}

/* List styles */
ul,
ol {
    padding: 0 1rem;
    margin: 1.25rem 1rem 1.25rem 0.4rem;

    li p {
        margin-top: 0.25em;
        margin-bottom: 0.25em;
    }
}

/* Heading styles */
h1,
h2,
h3,
h4,
h5,
h6 {
    line-height: 1.1;
    margin-top: 2.5rem;
    text-wrap: pretty;
}

h1,
h2 {
    margin-top: 3.5rem;
    margin-bottom: 1.5rem;
}

h1 {
    font-size: 1.4rem;
}

h2 {
    font-size: 1.2rem;
}

h3 {
    font-size: 1.1rem;
}

h4,
h5,
h6 {
    font-size: 1rem;
}

/* Code and preformatted text styles */
code {
    background-color: var(--purple-light);
    border-radius: 0.4rem;
    color: var(--black);
    font-size: 0.85rem;
    padding: 0.25em 0.3em;
}

pre {
    background: var(--black);
    border-radius: 0.5rem;
    color: var(--white);
    font-family: 'JetBrainsMono', monospace;
    margin: 1.5rem 0;
    padding: 0.75rem 1rem;

    code {
        background: none;
        color: inherit;
        font-size: 0.8rem;
        padding: 0;
    }
}

blockquote {
    border-left: 3px solid var(--gray-3);
    margin: 1.5rem 0;
    padding-left: 1rem;
}

hr {
    border: none;
    border-top: 1px solid var(--gray-2);
    margin: 2rem 0;
}

/* Placeholder (at the top) */
p.is-editor-empty:first-child::before {
    color: var(--gray-4);
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
}

/* Placeholder (on every new line) */
/* .is-empty::before {
    color: var(--gray-4);
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
  } */
</style>
