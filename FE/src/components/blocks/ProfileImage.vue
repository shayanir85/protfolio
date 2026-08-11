<template>
  <div class="profile-image-container">
    <div class="image-wrapper glass-card">
      <q-img
        :src="data?.image_url || data?.url || '/avatar.jpg'"
        :alt="data?.alt || 'Profile Image'"
        class="profile-img"
      >
        <template #error>
          <div class="absolute-full flex flex-center bg-grey-3 text-grey-8">
            <q-icon name="person" size="80px" />
          </div>
        </template>
      </q-img>
      <div v-if="data?.caption" class="image-caption">{{ data.caption }}</div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<style scoped>
.profile-image-container {
  display: flex;
  justify-content: center;
  padding: 20px;
}
.image-wrapper {
  overflow: hidden;
  border-radius: 24px;
  max-width: 400px;
  width: 100%;
}
.profile-img {
  width: 100%;
  height: auto;
  aspect-ratio: 1 / 1;
  object-fit: cover;
}
.image-caption {
  padding: 12px;
  text-align: center;
  font-size: 0.9rem;
  color: var(--text-secondary, #64748b);
}
</style>
