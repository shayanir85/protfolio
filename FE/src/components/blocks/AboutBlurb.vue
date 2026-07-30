<template>
  <div class="about-blurb">
    <div v-if="data?.avatar_url" class="about-blurb__avatar-wrapper">
      <q-img :src="data.avatar_url" :alt="data?.title || 'Profile'" class="about-blurb__avatar" />
    </div>
    <div class="about-blurb__content">
      <h2 v-if="data?.title" class="about-blurb__title">{{ data.title }}</h2>
      <p v-if="data?.text" class="about-blurb__text">{{ data.text }}</p>
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
.about-blurb {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 1.5rem;
  padding: 2rem;
}

.about-blurb__avatar-wrapper {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
  border: 4px solid rgba(99, 102, 241, 0.2);
  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease;
}

.about-blurb__avatar-wrapper:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 40px rgba(99, 102, 241, 0.4);
}

.about-blurb__avatar {
  width: 100%;
  height: 100%;
}

.about-blurb__content {
  max-width: 600px;
}

.about-blurb__title {
  font-size: 2rem;
  font-weight: 700;
  color: #f8fafc;
  margin: 0 0 1rem 0;
  background: linear-gradient(135deg, #818cf8, #c084fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.about-blurb__text {
  font-size: 1.125rem;
  line-height: 1.8;
  color: #94a3b8;
  margin: 0;
}

@media (max-width: 600px) {
  .about-blurb__avatar-wrapper {
    width: 120px;
    height: 120px;
  }

  .about-blurb__title {
    font-size: 1.5rem;
  }

  .about-blurb__text {
    font-size: 1rem;
  }
}
</style>
