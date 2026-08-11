<template>
  <section id="contact" class="section">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ t.contact.subtitle }}</span>
        <h2 class="section-title">{{ t.contact.title }}</h2>
        <div class="section-divider"></div>
      </div>

      <div class="contact-grid">
        <div class="contact-info-col">
          <h3 class="contact-heading">
            {{ t.contact.heading }}<br />
            <span class="gradient-text">{{ t.contact.headingAccent }}</span>
          </h3>
          <p class="contact-text">{{ t.contact.text }}</p>

          <div class="contact-methods">
            <a v-if="email" :href="`mailto:${email}`" class="contact-method">
              <div class="contact-method-icon">
                <q-icon name="email" size="22px" color="white" />
              </div>
              <div>
                <div class="contact-method-label">{{ t.contact.email }}</div>
                <div class="contact-method-value">{{ email }}</div>
              </div>
            </a>

            <a
              v-for="(link, index) in socialLinks"
              :key="index"
              :href="link.social_link"
              target="_blank"
              class="contact-method"
            >
              <div class="contact-method-icon">
                <q-icon :name="getSocialIcon(link.social_media_name)" size="22px" color="white" />
              </div>
              <div>
                <div class="contact-method-label">{{ link.social_media_name }}</div>
                <div class="contact-method-value">
                  {{ link.social_link.replace('https://', '').replace('www.', '') }}
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="contact-form-col">
          <div class="contact-form-card">
            <h3 class="form-title">{{ t.contact.formTitle }}</h3>
            <q-form ref="formRef" @submit.prevent="handleSubmit" class="q-gutter-md">
              <q-input
                v-model="form.name"
                :label="t.contact.namePlaceholder"
                outlined
                dense
                :rules="[(v) => !!v || t.contact.nameRequired]"
              >
                <template #prepend><q-icon name="person" color="grey-7" /></template>
              </q-input>

              <q-input
                v-model="form.phone"
                :label="t.contact.phonePlaceholder"
                type="tel"
                outlined
                dense
                :rules="[(v) => !!v || t.contact.phoneRequired]"
              >
                <template #prepend><q-icon name="call" color="grey-7" /></template>
              </q-input>

              <q-input
                v-model="form.message"
                :label="t.contact.messagePlaceholder"
                type="textarea"
                outlined
                rows="4"
                :rules="[(v) => !!v || t.contact.messageRequired]"
              >
                <template #prepend><q-icon name="message" color="grey-7" /></template>
              </q-input>

              <q-btn
                type="submit"
                color="primary"
                :label="t.contact.send"
                no-caps
                rounded
                unelevated
                icon-right="send"
                size="lg"
                class="full-width btn-primary-grad"
              />
            </q-form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue'

defineProps({
  t: { type: Object, required: true },
  data: { type: Object, default: () => ({}) },
  email: { type: String, default: '' },
  socialLinks: { type: Array, default: () => [] },
})

const emit = defineEmits(['submit-contact'])

const formRef = ref(null)
const form = reactive({ name: '', phone: '', message: '' })

function getSocialIcon(platform) {
  const icons = {
    github: 'fab fa-github',
    linkedin: 'fab fa-linkedin',
    instagram: 'fab fa-instagram',
    twitter: 'fab fa-twitter',
    facebook: 'fab fa-facebook',
    youtube: 'fab fa-youtube',
    telegram: 'fab fa-telegram',
    whatsapp: 'fab fa-whatsapp',
    email: 'email',
    website: 'language',
  }
  return icons[(platform || '').toLowerCase()] || 'link'
}

function handleSubmit() {
  emit('submit-contact', { ...form }, () => {
    form.name = ''
    form.phone = ''
    form.message = ''
    if (formRef.value) formRef.value.resetValidation()
  })
}
</script>

<style scoped>
.section {
  padding: 90px 24px;
}
.section-container {
  max-width: 1200px;
  margin: 0 auto;
}
.section-header {
  text-align: center;
  margin-bottom: 60px;
}
.section-subtitle {
  display: inline-block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #667eea;
  text-transform: uppercase;
  letter-spacing: 0.15em;
}
.lang-fa .section-subtitle {
  text-transform: none;
  letter-spacing: 0;
}
.section-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  margin: 8px 0 20px;
}
.section-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  margin: 0 auto;
  border-radius: 2px;
}

.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 50px;
  align-items: start;
}
@media (max-width: 868px) {
  .contact-grid {
    grid-template-columns: 1fr;
  }
}

.contact-heading {
  font-size: 2rem;
  font-weight: 800;
  line-height: 1.3;
  margin: 0 0 20px;
}
.gradient-text {
  background: linear-gradient(135deg, #667eea, #764ba2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.contact-text {
  font-size: 1.05rem;
  line-height: 1.8;
  color: #475569;
  margin-bottom: 30px;
}
.body--dark .contact-text {
  color: #94a3b8;
}

.contact-methods {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.contact-method {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px 20px;
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
}
.body--dark .contact-method {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}
.contact-method:hover {
  transform: translateX(6px);
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
}
[dir='rtl'] .contact-method:hover {
  transform: translateX(-6px);
}

.contact-method-icon {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  flex-shrink: 0;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
}
.contact-method-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  color: #94a3b8;
  font-weight: 600;
}
.lang-fa .contact-method-label {
  text-transform: none;
}
.contact-method-value {
  font-weight: 600;
  font-size: 0.95rem;
}

.contact-form-card {
  padding: 32px;
  border-radius: 24px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.body--dark .contact-form-card {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}
.form-title {
  font-size: 1.4rem;
  font-weight: 700;
  margin: 0 0 24px;
}
.btn-primary-grad {
  background: linear-gradient(135deg, #667eea, #764ba2) !important;
  font-weight: 600;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
}
</style>
