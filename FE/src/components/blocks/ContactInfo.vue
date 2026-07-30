<template>
  <div class="contact-info">
    <div class="contact-info__card">
      <h3 class="contact-info__title">Get In Touch</h3>
      <div class="contact-info__methods">
        <a v-if="data?.email" :href="`mailto:${data.email}`" class="contact-info__item">
          <q-icon name="email" size="md" />
          <span>{{ data.email }}</span>
        </a>
        <a v-if="data?.phone" :href="`tel:${data.phone}`" class="contact-info__item">
          <q-icon name="phone" size="md" />
          <span>{{ data.phone }}</span>
        </a>
      </div>
      <div v-if="data?.social_links" class="contact-info__socials">
        <a
          v-if="data.social_links.github"
          :href="data.social_links.github"
          target="_blank"
          rel="noopener noreferrer"
          class="contact-info__social-link"
        >
          <q-icon name="fab fa-github" size="lg" />
        </a>
        <a
          v-if="data.social_links.linkedin"
          :href="data.social_links.linkedin"
          target="_blank"
          rel="noopener noreferrer"
          class="contact-info__social-link"
        >
          <q-icon name="fab fa-linkedin" size="lg" />
        </a>
        <a
          v-if="data.social_links.twitter"
          :href="data.social_links.twitter"
          target="_blank"
          rel="noopener noreferrer"
          class="contact-info__social-link"
        >
          <q-icon name="fab fa-twitter" size="lg" />
        </a>
        <a
          v-if="data.social_links.website"
          :href="data.social_links.website"
          target="_blank"
          rel="noopener noreferrer"
          class="contact-info__social-link"
        >
          <q-icon name="language" size="lg" />
        </a>
      </div>
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
.contact-info {
  padding: 1.5rem;
}

.contact-info__card {
  background: linear-gradient(145deg, #1e293b, #0f172a);
  border-radius: 1.5rem;
  padding: 2.5rem;
  text-align: center;
  border: 1px solid rgba(148, 163, 184, 0.1);
}

.contact-info__title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #f8fafc;
  margin: 0 0 1.5rem 0;
  background: linear-gradient(135deg, #818cf8, #c084fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.contact-info__methods {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2rem;
}

.contact-info__item {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  color: #94a3b8;
  text-decoration: none;
  transition: color 0.3s ease;
}

.contact-info__item:hover {
  color: #818cf8;
}

.contact-info__socials {
  display: flex;
  justify-content: center;
  gap: 1.5rem;
}

.contact-info__social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  background: #0f172a;
  border-radius: 50%;
  color: #94a3b8;
  text-decoration: none;
  transition: all 0.3s ease;
}

.contact-info__social-link:hover {
  background: linear-gradient(135deg, #818cf8, #c084fc);
  color: #f8fafc;
  transform: translateY(-2px);
}
</style>
