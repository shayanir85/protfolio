<template>
  <div class="profile-image">
    <q-img
      v-if="data?.image_url || data?.avatar_url"
      :src="data.image_url || data.avatar_url"
      :alt="data?.alt || 'Profile Image'"
      class="profile-image__img"
      :ratio="16 / 9"
    >
      <template v-if="data?.overlay_text" #default>
        <div class="profile-image__overlay">
          <span class="profile-image__overlay-text">{{ data.overlay_text }}</span>
        </div>
      </template>
    </q-img>
    <div v-else class="profile-image__placeholder">
      <q-icon name="person" size="4rem" color="grey-6" />
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
.profile-image {
  width: 100%;
  border-radius: 1rem;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.profile-image__img {
  width: 100%;
  display: block;
}

.profile-image__overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 2rem;
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
  display: flex;
  align-items: flex-end;
}

.profile-image__overlay-text {
  color: #f8fafc;
  font-size: 1.5rem;
  font-weight: 600;
}

.profile-image__placeholder {
  width: 100%;
  aspect-ratio: 16 / 9;
  background: #1e293b;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 1rem;
}
</style>
