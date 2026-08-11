<template>
  <div class="page-builder-renderer">
    <HeroSection :t="t" :stats="stats" @scroll-to="$emit('scroll-to', $event)" />
    <AboutBlurb :t="t" :data="entities?.about || {}" />
    <SkillSet :t="t" :data="entities?.skills || {}" />
    <ExperienceTimeline :t="t" :data="entities?.experience || {}" />
    <ProjectsSection
      :t="t"
      :data="entities?.projects || {}"
      :projects="projects"
      :loading="loadingProjects"
      :error="projectsError"
      @retry="$emit('retry-projects')"
    />
    <ContactSection
      :t="t"
      :data="entities?.contact || {}"
      :email="userEmail"
      :social-links="socialLinks"
      @submit-contact="(payload, reset) => $emit('submit-contact', payload, reset)"
    />
  </div>
</template>

<script setup>
import HeroSection from './blocks/HeroSection.vue'
import AboutBlurb from './blocks/AboutBlurb.vue'
import SkillSet from './blocks/SkillSet.vue'
import ExperienceTimeline from './blocks/ExperienceTimeline.vue'
import ProjectsSection from './blocks/ProjectsSection.vue'
import ContactSection from './blocks/ContactSection.vue'

defineProps({
  t: { type: Object, required: true },
  entities: { type: Object, default: () => ({}) },
  projects: { type: Array, default: () => [] },
  loadingProjects: { type: Boolean, default: false },
  projectsError: { type: String, default: null },
  userEmail: { type: String, default: '' },
  socialLinks: { type: Array, default: () => [] },
  stats: { type: Array, default: () => [] },
})

defineEmits(['scroll-to', 'submit-contact', 'retry-projects'])
</script>
