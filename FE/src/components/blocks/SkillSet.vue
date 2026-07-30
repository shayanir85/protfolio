<template>
  <div class="skill-set">
    <h3 v-if="data?.category" class="skill-set__category">{{ data.category }}</h3>
    <div class="skill-set__grid">
      <div v-for="skill in data?.skills || []" :key="skill.name" class="skill-set__item">
        <div class="skill-set__header">
          <span class="skill-set__name">{{ skill.name }}</span>
          <span class="skill-set__level">{{ skill.level }}%</span>
        </div>
        <div class="skill-set__bar">
          <div class="skill-set__progress" :style="{ width: `${skill.level}%` }" />
        </div>
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
.skill-set {
  padding: 1.5rem;
}

.skill-set__category {
  font-size: 1.25rem;
  font-weight: 600;
  color: #c084fc;
  margin: 0 0 1.5rem 0;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.skill-set__grid {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.skill-set__item {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.skill-set__header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.skill-set__name {
  font-size: 0.95rem;
  font-weight: 500;
  color: #e2e8f0;
}

.skill-set__level {
  font-size: 0.85rem;
  font-weight: 600;
  color: #818cf8;
}

.skill-set__bar {
  height: 8px;
  background: #1e293b;
  border-radius: 4px;
  overflow: hidden;
}

.skill-set__progress {
  height: 100%;
  background: linear-gradient(90deg, #818cf8, #c084fc);
  border-radius: 4px;
  transition: width 0.8s ease-out;
}
</style>
