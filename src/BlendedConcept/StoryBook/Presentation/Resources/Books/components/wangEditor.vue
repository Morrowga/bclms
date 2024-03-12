<template>
    <div
      style="border: 1px solid #bfbfc8; border-radius: 15px; padding: 5px"
    >
      <Toolbar
        :editor="editorRef"
        :defaultConfig="toolbarConfig"
        style="border-bottom: 1px solid #d4d5d9;"
        :mode="mode"
      />
      <Editor
        :defaultConfig="editorConfig"
        v-model="defaultHtml"
        @on-change="handleChange"
        style="height: 300px; overflow-y: hidden;"
        :mode="mode"
        @on-created="handleCreated"
      />
    </div>
  </template>

  <script setup lang="ts">
  import { onBeforeUnmount, shallowRef, reactive, toRefs } from "vue";
  import { Editor, Toolbar } from "@wangeditor/editor-for-vue";
  import { i18nChangeLanguage } from '@wangeditor/editor'
  import {
    IDomEditor,
    IEditorConfig,
    IToolbarConfig,
  } from "@wangeditor/editor";


  i18nChangeLanguage('en');

  const props = defineProps<{
    modelValue: string;
  }>();

  const emit = defineEmits<{
    (e: "update:modelValue", value: string): void;
  }>();

  // Editor instance shallowRef must be used
  const editorRef = shallowRef<IDomEditor>();

  const state = reactive({
    toolbarConfig: {} as IToolbarConfig,
    editorConfig: {
      placeholder: "Write something...",
    } as IEditorConfig,
    defaultHtml: props.modelValue,
    mode: "default",
  });

  const { toolbarConfig, editorConfig, defaultHtml, mode } = toRefs(state);


  const handleCreated = (editor: IDomEditor) => {
    editorRef.value = editor;
  };

  function handleChange(editor: IDomEditor) {
    emit("update:modelValue", editor.getHtml());
  }

  // When the component is destroyed, the editor is also destroyed in time.
  onBeforeUnmount(() => {
    const editor = editorRef.value;
    if (editor == null) return;
    editor.destroy();
  });
  </script>

<style scoped>
    @import url('../../../../../../../node_modules/@wangeditor/editor/dist/css/style.css');
</style>
