<template>
  <div class="projects-section">
    <h2 class="projects-section__title">Featured Projects</h2>
    <div v-if="loading" class="projects-section__loading">
      <q-spinner-dots size="40px" color="deep-purple" />
    </div>
    <div v-else class="projects-section__grid">
      <div v-for="project in projects" :key="project.name" class="projects-section__card">
        <div class="projects-section__card-header">
          <q-icon name="folder" size="sm" color="deep-purple-4" />
          <a
            :href="project.url"
            target="_blank"
            rel="noopener noreferrer"
            class="projects-section__name"
          >
            {{ project.name }}
          </a>
        </div>
        <p class="projects-section__description">
          {{ project.description || 'No description available' }}
        </p>
        <div class="projects-section__meta">
          <span v-if="project.language" class="projects-section__language">
            <span
              class="projects-section__dot"
              :style="{ backgroundColor: getLanguageColor(project.language) }"
            />
            {{ project.language }}
          </span>
          <span class="projects-section__stars">
            <q-icon name="star" size="sm" />
            {{ formatStars(project.stars) }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { usePageStore } from '@/stores/page-store'

const { projects } = storeToRefs(usePageStore())
const { fetchProjects } = usePageStore()

const loading = ref(true)

onMounted(async () => {
  await fetchProjects()
  loading.value = false
})

function formatStars(stars) {
  if (stars >= 1000) {
    return `${(stars / 1000).toFixed(1)}k`
  }
  return stars
}

function getLanguageColor(lang) {
  const colors = {
    JavaScript: '#f1e05a',
    TypeScript: '#3178c6',
    PHP: '#4F5D95',
    Python: '#3572A5',
    Java: '#b07219',
    Ruby: '#701516',
    Go: '#00ADD8',
    Rust: '#dea584',
    'C++': '#f34b7d',
    C: '#555555',
    Swift: '#F05138',
    Kotlin: '#A97BFF',
    Dart: '#00B4AB',
    Vue: '#41b883',
    CSS: '#563d7c',
    HTML: '#e34c26',
    Shell: '#89e051',
  }
  return colors[lang] || '#8b8b8b'
}
</script>

<style scoped>
.projects-section {
  padding: 2rem;
}

.projects-section__title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #f8fafc;
  margin: 0 0 2rem 0;
  text-align: center;
  background: linear-gradient(135deg, #818cf8, #c084fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.projects-section__loading {
  display: flex;
  justify-content: center;
  padding: 3rem;
}

.projects-section__grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.projects-section__card {
  background: #1e293b;
  border-radius: 1rem;
  padding: 1.5rem;
  border: 1px solid rgba(148, 163, 184, 0.1);
  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease,
    border-color 0.3s ease;
}

.projects-section__card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 32px rgba(99, 102, 241, 0.15);
  border-color: rgba(129, 140, 248, 0.3);
}

.projects-section__card-header {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
}

.projects-section__name {
  font-size: 1rem;
  font-weight: 600;
  color: #818cf8;
  text-decoration: none;
  transition: color 0.3s ease;
}

.projects-section__name:hover {
  color: #c084fc;
}

.projects-section__description {
  color: #94a3b8;
  font-size: 0.9rem;
  line-height: 1.6;
  margin: 0 0 1rem 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.projects-section__meta {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.85rem;
  color: #64748b;
}

.projects-section__language {
  display: flex;
  align-items: center;
  gap: 0.375rem;
}

.projects-section__dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
}

.projects-section__stars {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

@media (max-width: 600px) {
  .projects-section__grid {
    grid-template-columns: 1fr;
  }
}
</style>
