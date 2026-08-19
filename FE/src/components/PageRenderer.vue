<template>
  <div class="page-builder-renderer">
    <HeroSection
      v-if="hasHeroData"
      :t="t"
      :stats="stats"
      @scroll-to="$emit('scroll-to', $event)"
    />
    <AboutBlurb
      v-if="hasAboutData"
      :t="t"
      :data="entities?.about || {}"
    />
    <SkillSet
      v-if="hasSkillsData"
      :t="t"
      :data="entities?.skills || {}"
      :categories="skillsCategories"
      :loading="loadingSkills"
      :error="skillsError"
      @retry="$emit('retry-skills')"
    />
    <ExperienceTimeline
      v-if="hasExperienceData"
      :t="t"
      :data="entities?.experience || {}"
      :experiences="experiences"
    />
    <ProjectsSection
      v-if="hasProjectsData"
      :t="t"
      :data="entities?.projects || {}"
      :projects="projects"
      :loading="loadingProjects"
      :error="projectsError"
      @retry="$emit('retry-projects')"
    />
    <ContactSection
      v-if="hasContactData"
      :t="t"
      :data="entities?.contact || {}"
      :email="userEmail"
      :social-links="socialLinks"
      @submit-contact="(payload, reset) => $emit('submit-contact', payload, reset)"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import HeroSection from './blocks/HeroSection.vue'
import AboutBlurb from './blocks/AboutBlurb.vue'
import SkillSet from './blocks/SkillSet.vue'
import ExperienceTimeline from './blocks/ExperienceTimeline.vue'
import ProjectsSection from './blocks/ProjectsSection.vue'
import ContactSection from './blocks/ContactSection.vue'

const props = defineProps({
  t: { type: Object, required: true },
  entities: { type: Object, default: () => ({}) },
  projects: { type: Array, default: () => [] },
  loadingProjects: { type: Boolean, default: false },
  projectsError: { type: String, default: null },
  skillsCategories: { type: Array, default: () => [] },
  loadingSkills: { type: Boolean, default: false },
  skillsError: { type: String, default: null },
  userEmail: { type: String, default: '' },
  socialLinks: { type: Array, default: () => [] },
  experiences: { type: Array, default: () => [] },
  stats: { type: Array, default: () => [] },
})

defineEmits(['scroll-to', 'submit-contact', 'retry-projects', 'retry-skills'])

const hasHeroData = computed(() => {
  return Boolean(props.t?.hero && (props.t.hero.greeting || props.t.hero.name || (props.stats && props.stats.length > 0)))
})

const hasAboutData = computed(() => {
  const hasEntitiesAbout = props.entities?.about && Object.keys(props.entities.about).length > 0
  const hasTAbout = props.t?.about && (props.t.about.title || props.t.about.heading || props.t.about.p1 || (props.t.about.infoItems && props.t.about.infoItems.length > 0))
  return Boolean(hasEntitiesAbout || hasTAbout)
})

const hasSkillsData = computed(() => {
  if (props.loadingSkills || props.skillsError) return true
  const hasCategories = Array.isArray(props.skillsCategories) && props.skillsCategories.length > 0
  const hasEntitiesSkills = props.entities?.skills && Object.keys(props.entities.skills).length > 0
  return Boolean(hasCategories || hasEntitiesSkills)
})

const hasExperienceData = computed(() => {
  const hasExps = Array.isArray(props.experiences) && props.experiences.length > 0
  const hasTItems = Array.isArray(props.t?.experience?.items) && props.t.experience.items.length > 0
  const hasEntitiesExp = props.entities?.experience && Object.keys(props.entities.experience).length > 0
  return Boolean(hasExps || hasTItems || hasEntitiesExp)
})

const hasProjectsData = computed(() => {
  if (props.loadingProjects || props.projectsError) return true
  const hasProjs = Array.isArray(props.projects) && props.projects.length > 0
  const hasEntitiesProjects = props.entities?.projects && Object.keys(props.entities.projects).length > 0
  return Boolean(hasProjs || hasEntitiesProjects)
})

const hasContactData = computed(() => {
  const hasEmail = Boolean(props.userEmail && props.userEmail.trim())
  const hasSocials = Array.isArray(props.socialLinks) && props.socialLinks.length > 0
  const hasEntitiesContact = props.entities?.contact && Object.keys(props.entities.contact).length > 0
  const hasTContact = props.t?.contact && (props.t.contact.title || props.t.contact.heading)
  return Boolean(hasEmail || hasSocials || hasEntitiesContact || hasTContact)
})
</script>
