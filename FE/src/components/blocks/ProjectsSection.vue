<template>
  <section id="projects" class="section section-alt">
    <div class="section-container">
      <div class="section-header">
        <span class="section-subtitle">{{ t.projects.subtitle }}</span>
        <h2 class="section-title">{{ t.projects.title }}</h2>
        <div class="section-divider"></div>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="loading" class="projects-grid">
        <div v-for="n in 6" :key="n" class="project-card-wrapper">
          <div class="project-card skeleton-card">
            <div class="shimmer-row">
              <div class="shimmer-circle shimmer"></div>
              <div class="shimmer-lines">
                <div class="shimmer-line shimmer w-60"></div>
                <div class="shimmer-line shimmer w-40"></div>
              </div>
            </div>
            <div class="shimmer-line shimmer w-100 q-mt-md"></div>
            <div class="shimmer-line shimmer w-80 q-mt-sm"></div>
            <div class="shimmer-line shimmer w-90 q-mt-sm"></div>
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="empty-state">
        <div class="empty-icon"><q-icon name="error_outline" size="64px" color="negative" /></div>
        <h3 class="empty-title">{{ t.projects.error }}</h3>
        <p class="empty-text">{{ error }}</p>
        <q-btn
          color="primary"
          :label="t.projects.tryAgain"
          no-caps
          rounded
          icon="refresh"
          @click="$emit('retry')"
        />
      </div>

      <!-- Empty State -->
      <div v-else-if="projects.length === 0" class="empty-state">
        <div class="empty-icon"><q-icon name="inventory_2" size="64px" color="primary" /></div>
        <h3 class="empty-title">{{ t.projects.noProjects }}</h3>
        <p class="empty-text">{{ t.projects.noProjectsText }}</p>
      </div>

      <!-- Projects Grid -->
      <div v-else class="projects-grid">
        <div
          v-for="(project, idx) in projects"
          :key="project.id || idx"
          class="project-card-wrapper"
          :style="{ animationDelay: idx * 0.1 + 's' }"
        >
          <div class="project-card">
            <div class="project-header-gradient"></div>
            <div class="project-body">
              <div class="project-icon">
                <q-icon name="folder" color="white" size="28px" />
              </div>
              <h3 class="project-name">{{ project.full_name || project.name }}</h3>
              <p class="project-desc">{{ project.description || t.projects.noDesc }}</p>
              <div class="project-meta">
                <div
                  class="meta-item"
                  v-if="project.stargazers_count !== undefined || project.stars !== undefined"
                >
                  <q-icon name="star" color="amber" size="xs" />
                  <span>{{ project.stargazers_count ?? project.stars }}</span>
                </div>
                <div
                  class="meta-item"
                  v-if="project.watchers_count !== undefined || project.watchers !== undefined"
                >
                  <q-icon name="visibility" color="teal" size="xs" />
                  <span>{{ project.watchers_count ?? project.watchers }}</span>
                </div>
                <div class="meta-item" v-if="project.forks_count !== undefined">
                  <q-icon name="call_split" color="primary" size="xs" />
                  <span>{{ project.forks_count }}</span>
                </div>
                <div class="meta-item" v-if="project.language">
                  <q-icon name="code" color="deep-purple-4" size="xs" />
                  <span>{{ project.language }}</span>
                </div>
              </div>
            </div>
            <div class="project-actions">
              <q-btn
                flat
                color="primary"
                :label="t.projects.viewProject"
                no-caps
                icon-right="open_in_new"
                :href="project.html_url || project.url"
                target="_blank"
                class="full-width view-btn"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  t: { type: Object, required: true },
  data: { type: Object, default: () => ({}) },
  projects: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false },
  error: { type: String, default: null },
})
defineEmits(['retry'])
</script>

<style scoped>
.section {
  padding: 90px 24px;
}
@media (max-width: 768px) {
  .section {
    padding: 50px 16px;
  }
}
.section-alt {
  background: #f8fafc;
}
.body--dark .section-alt {
  background: #0f172a;
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

.projects-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 30px;
}

@media (max-width: 600px) {
  .projects-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .project-body {
    padding: 20px 16px;
  }
  .project-actions {
    padding: 12px 16px 20px;
  }
}

.project-card {
  height: 100%;
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  overflow: hidden;
  transition: all 0.3s ease;
}
.body--dark .project-card {
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(255, 255, 255, 0.1);
}
.project-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 16px 36px rgba(102, 126, 234, 0.25);
}

.skeleton-card {
  padding: 24px;
}
.project-header-gradient {
  height: 6px;
  background: linear-gradient(135deg, #667eea, #764ba2);
}
.project-body {
  padding: 28px;
  flex-grow: 1;
}
.project-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}
.project-name {
  font-size: 1.2rem;
  font-weight: 700;
  margin: 0 0 10px;
}
.project-desc {
  color: #475569;
  line-height: 1.6;
  font-size: 0.95rem;
  margin-bottom: 20px;
}
.body--dark .project-desc {
  color: #94a3b8;
}
.project-meta {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
}
.meta-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.85rem;
  font-weight: 600;
  color: #64748b;
}
.project-actions {
  padding: 16px 28px 24px;
}
.view-btn {
  font-weight: 600;
  border-radius: 12px;
}

/* Shimmer */
.shimmer-row {
  display: flex;
  gap: 16px;
  align-items: center;
}
.shimmer-circle {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  flex-shrink: 0;
}
.shimmer-lines {
  flex: 1;
}
.shimmer-line {
  height: 12px;
  border-radius: 6px;
  margin-bottom: 8px;
}
.w-100 {
  width: 100%;
}
.w-80 {
  width: 80%;
}
.w-60 {
  width: 60%;
}
.w-40 {
  width: 40%;
}
.w-90 {
  width: 90%;
}
.shimmer {
  background: linear-gradient(
    90deg,
    rgba(200, 200, 200, 0.15) 25%,
    rgba(200, 200, 200, 0.3) 50%,
    rgba(200, 200, 200, 0.15) 75%
  );
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
}
.empty-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 8px;
}
.empty-text {
  color: #64748b;
  margin-bottom: 24px;
}
</style>
