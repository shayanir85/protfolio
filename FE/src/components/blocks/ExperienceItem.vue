<template>
  <div class="experience-item">
    <div class="experience-item__timeline-dot" />
    <div class="experience-item__card">
      <div class="experience-item__header">
        <h3 class="experience-item__position">{{ data?.position }}</h3>
        <span class="experience-item__company">{{ data?.company }}</span>
      </div>
      <div class="experience-item__dates">
        <q-icon name="calendar_today" size="sm" />
        <span
          >{{ formatDate(data?.start_date) }} -
          {{ data?.end_date ? formatDate(data.end_date) : 'Present' }}</span
        >
      </div>
      <p v-if="data?.description" class="experience-item__description">{{ data.description }}</p>
      <div v-if="data?.tech_stack?.length" class="experience-item__tech-stack">
        <q-badge
          v-for="tech in data.tech_stack"
          :key="tech"
          class="experience-item__tech-badge"
          color="deep-purple-8"
          text-color="white"
          :label="tech"
        />
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

function formatDate(dateStr) {
  if (!dateStr) return ''
  const [year, month] = dateStr.split('-')
  const months = [
    'Jan',
    'Feb',
    'Mar',
    'Apr',
    'May',
    'Jun',
    'Jul',
    'Aug',
    'Sep',
    'Oct',
    'Nov',
    'Dec',
  ]
  return `${months[parseInt(month, 10) - 1]} ${year}`
}
</script>

<style scoped>
.experience-item {
  position: relative;
  padding-left: 2rem;
  padding-bottom: 2rem;
}

.experience-item__timeline-dot {
  position: absolute;
  left: 0;
  top: 0.5rem;
  width: 12px;
  height: 12px;
  background: linear-gradient(135deg, #818cf8, #c084fc);
  border-radius: 50%;
  box-shadow:
    0 0 0 4px #0f172a,
    0 0 0 6px rgba(129, 140, 248, 0.3);
}

.experience-item__card {
  background: #1e293b;
  border-radius: 1rem;
  padding: 1.5rem;
  border: 1px solid rgba(148, 163, 184, 0.1);
  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease;
}

.experience-item__card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 32px rgba(99, 102, 241, 0.15);
}

.experience-item__header {
  margin-bottom: 0.75rem;
}

.experience-item__position {
  font-size: 1.25rem;
  font-weight: 600;
  color: #f8fafc;
  margin: 0 0 0.25rem 0;
}

.experience-item__company {
  font-size: 1rem;
  font-weight: 500;
  color: #818cf8;
}

.experience-item__dates {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #64748b;
  font-size: 0.875rem;
  margin-bottom: 1rem;
}

.experience-item__description {
  color: #94a3b8;
  line-height: 1.7;
  margin: 0 0 1rem 0;
}

.experience-item__tech-stack {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.experience-item__tech-badge {
  font-weight: 500;
}
</style>
