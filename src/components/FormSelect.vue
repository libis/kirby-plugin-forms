<template>
  <div class="form-block">
    <k-icon :type="icon" class="k-block-icon" />
    <span class="k-block-title-text">
      <span v-if="selectedForm" class="k-block-name">{{ selectedForm.title }}</span>
      <span v-else class="k-block-name">Geen formulier geselecteerd</span>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    content: Object,
    fieldset: Object
  },
  data() {
    return {
      selectedForm: null
    };
  },
  computed: {
    icon() {
      return this.fieldset.icon ?? "box";
    }
  },
  mounted() {
    this.fetchSelectedForm();
  },
  watch: {
    'content.formpage'(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.fetchSelectedForm();
      }
    }
  },
  methods: {
    async fetchSelectedForm() {
      try {
        const selectedId = this.content.formpage;
        if (!selectedId) return;

        const formPage = await this.$api.pages.get(selectedId);
        this.selectedForm = formPage;
      } catch (error) {
        console.error('Fout bij ophalen formulier:', error);
      }
    }
  }
};
</script>

<style>
.form-block {
  display: flex;
  gap: 5px;
  background-color: var(--color-gray-200);
  border-radius: var(--rounded-lg);
  padding: 10px;
}
</style>
