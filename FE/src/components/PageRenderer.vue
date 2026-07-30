<template>
  <div class="page-renderer">
    <div v-if="loading" class="page-renderer__loading">
      <q-spinner-dots size="60px" color="deep-purple" />
      <p class="page-renderer__loading-text">Loading portfolio...</p>
    </div>
    <div v-else-if="error" class="page-renderer__error">
      <q-icon name="error_outline" size="48px" color="negative" />
      <p>{{ error }}</p>
      <q-btn color="deep-purple" label="Retry" @click="loadPage" no-caps />
    </div>
    <div v-else class="page-renderer__content">
      <div v-for="row in rows" :key="row.id" class="page-renderer__row">
        <div class="page-renderer__columns">
          <div
            v-for="col in row.columns"
            :key="col.id"
            class="page-renderer__column"
            :style="{ flex: `0 0 ${(col.width / 12) * 100}%` }"
          >
            <template v-for="block in col.blocks" :key="block.id">
              <component :is="getBlockComponent(block.type)" :data="getEntity(block.entity_id)" />
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { usePageStore } from '@/stores/page-store'
import AboutBlurb from './blocks/AboutBlurb.vue'
import ProfileImage from './blocks/ProfileImage.vue'
import SkillSet from './blocks/SkillSet.vue'
import ExperienceItem from './blocks/ExperienceItem.vue'
import PricingTier from './blocks/PricingTier.vue'
import ContactInfo from './blocks/ContactInfo.vue'
import ProjectsSection from './blocks/ProjectsSection.vue'

const { layout, loading, error } = storeToRefs(usePageStore())
const { fetchPage } = usePageStore()

const rows = computed(() => layout.value?.rows || [])

const blockComponents = {
  about_blurb: AboutBlurb,
  profile_image: ProfileImage,
  skill_set: SkillSet,
  experience_item: ExperienceItem,
  pricing_tier: PricingTier,
  contact_info: ContactInfo,
  projects: ProjectsSection,
}

function getBlockComponent(type) {
  return blockComponents[type] || null
}

function getEntity(entityId) {
  return usePageStore().getEntity(entityId)
}

function loadPage() {
  fetchPage()
}

onMounted(() => {
  fetchPage()
})
</script>

<style scoped>
.page-renderer {
  min-height: 100vh;
}

.page-renderer__loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 60vh;
  gap: 1.5rem;
}

.page-renderer__loading-text {
  color: #94a3b8;
  font-size: 1.125rem;
}

.page-renderer__error {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 60vh;
  gap: 1rem;
  color: #94a3b8;
}

.page-renderer__content {
  display: flex;
  flex-direction: column;
  gap: 3rem;
}

.page-renderer__row {
  width: 100%;
}

.page-renderer__columns {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.page-renderer__column {
  min-width: 0;
}

@media (max-width: 768px) {
  .page-renderer__columns {
    flex-direction: column;
    padding: 0 1rem;
  }

  .page-renderer__column {
    flex: 0 0 100% !important;
  }
}
</style>
